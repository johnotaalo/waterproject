<?php



class Account extends MX_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->module([
			'template'
		]);

		$this->load->library('encryption');
		$this->load->model('M_Account');
	}

	function signin()
	{
		if ($this->input->post()) {
			$email		=	$this->input->post('email');
			$password	=	$this->input->post('password');
			if ($email && $password) {
				$user = $this->M_Account->getUser($email);
				if($user)
				{
					$decrypted_password = $this->encryption->decrypt($user->password);
					if ($decrypted_password == $password && $user->deleted == 0) {
						$session_data = array(
								'emailaddress'	=>	$user->emailaddress,
								'user_id'		=>	$user->id,
								'user_type'		=>	$user->usertype,
								'logged_in'		=>	TRUE
							);
						// echo "<pre>";print_r($session_data);die;
						$this->session->set_userdata($session_data);
						redirect(base_url() . 'Dashboard');
					}
					else
					{
						if($user->deleted == 1)
						{
							$this->session->set_flashdata('error', "Can not sign you in! Please contact administrator");
						}
						else
						{
							$this->session->set_flashdata('error', "The username or password you entered is wrong");
						}						
					}
				}
				else
				{
					$this->session->set_flashdata('error', "The username or password you entered is wrong");
				}
				redirect(base_url() . 'Account/signin');
			}
		}
		else
		{
			$this->session->sess_destroy();
			$this->template->call_admin_signin();
		}
	}

	function checklogin()
	{
		if (!$this->session->userdata('logged_in'))
		{
			redirect(base_url() . 'Account/signin');
		}
	}

	function myaccount()
	{
		$user_id = $this->session->userdata('user_id');

		$user_details = $this->M_Account->getUserById($user_id);

		if ($user_details) {
			$data['name'] = $user_details->username;
			$data['emailaddress'] = $user_details->emailaddress;
			$data['created'] = date('dS F Y', strtotime($user_details->created_at));

			$data['content_view'] = 'Account/myaccount_v';
			$data['title'] = 'My Account';

			$this->template->call_admin_template($data);
		}
		else
		{
			redirect(base_url() . 'Account/signin');
		}
		
	}

	function secret_signup($username, $password, $email)
	{
		$user_data = array('username' => $username, 'password' => $this->encryption->encrypt($password), 'active' => 1, 'usertype' => 'admin', 'emailaddress' => $email);
		$this->M_Account->addUser($user_data);
	}

	function changepassword()
	{
		$response = [];
		$current_password = $this->input->post('current_password');
		$new_password =	$this->input->post('new_password');
		$confirm_password = $this->input->post('confirm_password');

		if ($current_password !== "" && $new_password !== "" && $confirm_password !== "") {
			$user = $this->M_Account->getUserById($this->session->userdata('user_id'));

			if ($user):
				$decrypted_password = $this->encryption->decrypt($user->password);

				if ($current_password == $decrypted_password) {
					if($new_password == $confirm_password)
					{
						$encrypted_password = $this->encryption->encrypt($new_password);

						$this->load->model('M_User');
						$updated = $this->M_User->update_user($this->session->userdata('user_id'), ['password' => $encrypted_password]);

						if ($updated) {
							header('HTTP/1.1 200 OK');
							$response['message'] = 'Your password has successfully changed! You will have to login again';
						}
						else{
							header('HTTP/1.1 417 Expectation Failed');
							$response['message'] = 'Could not change your password. Please contact administrator';
						}
					}
					else
					{
						header('HTTP/1.1 412 Precondition Failed');
						$response['message'] = 'The new password does not match with the confirmation password';
					}
				}
				else
				{
					header('HTTP/1.1 401 Unauthorized');
					$response['message'] = 'The current password you entered is wrong. Please try again';
				}
			else:
				header('HTTP/1.1 401 Unauthorized');
				$response['message'] = 'You seemed to have been logged out. Please log in and try again';
			endif;
		}
		else
		{
			header('HTTP/1.1 400 Bad Request');
			$response['message'] = 'One of the fields is empty! Please try again';
		}

		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode($response);
	}

	function signout()
	{
		echo "Thank you for using the system. We are logging you out shortly";
		$this->session->sess_destroy();
		redirect(base_url() . 'Account/signin');
	}

}
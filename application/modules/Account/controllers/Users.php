<?php
(defined('BASEPATH')) or exit('No direct access allowed to this script');

class Users extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model([
			'M_User',
			'M_Account'
		]);

		$this->load->library('encryption');
		$this->load->helper('string');
	}

	function index()
	{
		$data['title'] = 'Users List';
		$data['content_view'] = 'Account/users_v';
		$this->template->call_admin_template($data);
	}

	function getuserslist()
	{

		$user_id = $this->session->userdata('user_id');
		$req = $_GET;
		if($req['search']['value'] == ""):
			$users = $this->M_User->get_all_users($user_id);
		else:
			$users = $this->M_User->get_users_by_phrase($req['search']['value'], $user_id);
		endif;

		$user_data = [];

		if ($users) {
			$counter = 1;
			foreach ($users as $user) {
				$activity = '<center><a class = "label label-';
				$activity .= ($user->active == 1) ? 'success">Active' : 'danger">Not Active';
				$activity .= "</a></center>";
				// echo $activity;die;
				$user_data[] = [
					$counter,
					$user->username,
					$user->emailaddress,
					$activity,
					date('dS F Y', strtotime($user->created_at)),
					'<a href = "#" class = "label label-warning password-reset" data-email = "'.$user->emailaddress.'">Reset Password</a>'
				];

				$counter++;
			}
		}

		$json_data = [];

		$json_data = [
			'draw'				=>	$_GET['draw'],
			'recordsTotal'		=>	count($user_data),
			'recordsFiltered'	=>	count($user_data),
			'data'				=>	$user_data
		];

		echo json_encode($json_data);
	}

	function reset_password()
	{
		$response = [];
		if ($this->input->post('email')) 
		{
			$email = $this->input->post('email');

			$user = $this->M_Account->getUser($email);

			if ($user) {
				$user_id = $user->id;
				$generated_password = random_string('numeric', 6);

				$data['name'] = $user->username;
				$data['new_password'] = $generated_password;
				$data['email'] = $user->emailaddress;
				$data['time'] = date('d-F-Y \at\ h:i:s a');

				// send email to the email
				$this->load->library('Mailer');

				$mail = new PHPMailer();

				$mail->IsSMTP(); // Use SMTP
				$mail->IsHTML(true);
				$mail->Host        = "smtp.gmail.com"; // Sets SMTP server
				$mail->SMTPDebug   = 2; // 2 to enable SMTP debug information
				$mail->SMTPAuth    = TRUE; // enable SMTP authentication
				$mail->SMTPSecure  = "tls"; //Secure conection
				$mail->Port        = 25; // set the SMTP port
				$mail->Username    = 'chrizota@gmail.com'; // SMTP account username
				$mail->Password    = 'Chrispine2015'; // SMTP account password
				$mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
				$mail->CharSet     = 'UTF-8';
				$mail->Subject     = "Password Reset";
				$mail->ContentType = 'text/html; charset=utf-8\r\n';
				$mail->From        = 'accounts@enkonguwater.com';
				$mail->FromName    = 'Enkongu Water';
				$mail->Sender      = 'accounts@enkonguwater.com';
				$mail->AddAddress($email);
				$mail->isHTML( TRUE );
				$mail->Body = $this->load->view('template/email/password_reset', $data, TRUE);
				if(!$mail->Send()) {
					header('HTTP/1.1 503 Service Unavailable');
					header('Content-Type: application/json; charset=UTF-8');
					$response['message']	=	"Could not send email";
					$response['code']		=	503;
				} else {

					$encrypted_password = $this->encryption->encrypt($generated_password);

					$this->M_User->update_user($user_id, ['password' => $encrypted_password]);

					header('HTTP/1.1 200 OK');
					header('Content-Type: application/json; charset=UTF-8');
					$response['message']	=	"Password Reset Successfully";
					$response['code']		=	"200";
				}
				$mail->SmtpClose();
			}
			else
			{
				header('HTTP/1.1 404 Page Not Found');
				header('Content-Type: application/json; charset=UTF-8');
				$response['message']	=	"Could not find user. Please try again later";
				$response['code']		=	404;
			}
		}
		else
		{
			header('HTTP/1.1 400 Bad Request');
			header('Content-Type: application/json; charset=UTF-8');
			$response['message']	=	"You did not specify a user to reset the password";
			$response['code']		=	400;
		}

		echo json_encode($response);
	}

	function addUser()
	{
		$response = array();
		if ($this->input->post()) {
			$email  = $this->input->post('emailaddress');
			$username = $this->input->post('username');

			if ($username !== "" && $email !== "") {
				$generated_password = random_string('numeric', 6);

				$data['name'] = $username;
				$data['new_password'] = $generated_password;
				$data['email'] = $email;
				$data['time'] = date('d-F-Y \at\ h:i:s a');

				$this->load->library('Mailer');

				$mail = new PHPMailer();

				$mail->IsSMTP(); // Use SMTP
				$mail->IsHTML(true);
				$mail->Host        = "smtp.gmail.com"; // Sets SMTP server
				// $mail->SMTPDebug   = 2; // 2 to enable SMTP debug information
				$mail->SMTPAuth    = TRUE; // enable SMTP authentication
				$mail->SMTPSecure  = "tls"; //Secure conection
				$mail->Port        = 25; // set the SMTP port
				$mail->Username    = 'chrizota@gmail.com'; // SMTP account username
				$mail->Password    = 'Chrispine2015'; // SMTP account password
				$mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
				$mail->CharSet     = 'UTF-8';
				$mail->Subject     = "Welcome to Enkongu Water";
				$mail->ContentType = 'text/html; charset=utf-8\r\n';
				$mail->From        = 'accounts@enkonguwater.com';
				$mail->FromName    = 'Enkongu Water';
				$mail->Sender      = 'accounts@enkonguwater.com';
				$mail->AddAddress($email);
				$mail->isHTML( TRUE );
				$mail->Body = $this->load->view('template/email/welcome', $data, TRUE);
				if(!$mail->Send()) {
					die("There was an error that could not be understood");
				} else {

					$encrypted_password = $this->encryption->encrypt($generated_password);

					$this->M_Account->addUser(['username' => $username, 'emailaddress' => $email, 'password' => $encrypted_password, 'usertype' => 'admin', 'active' => 1]);

					redirect(base_url() . 'Account/Users');
				}
				$mail->SmtpClose();
			}
			else
			{
				die("There was an error with your request");
			}
		}
		else
		{
			$page = $this->load->view('Account/adduser_v', NULL, TRUE);

			$response['page'] = $page;
			$response['title'] = "Add User";

			echo json_encode($response);
		}
	}

	function search_email()
	{
		$response = [];
		if ($this->input->post()) {
			$email = $this->input->post('email');

			if ($email) {
				$exists = $this->M_Account->getUser($email);

				if($exists)
				{
					header('HTTP/1.1 406 Not Acceptable');
					header('Content-Type: application/json; charset=UTF-8');
					$response['message'] = 'This email address already exists';
					$response['code'] = 406;
				}
				else
				{
					header('HTTP/1.1 200 OK');
					header('Content-Type: application/json; charset=UTF-8');
					$response['message'] = 'proceed';
					$response['code'] = 200;
				}
			}
			else
			{
				header('HTTP/1.1 400 Bad Request');
				header('Content-Type: application/json; charset=UTF-8');
				$response['message'] = 'There is a problem with your request. Please try again later!';
				$response['code'] = 400;
			}
		}
		else{
			header('HTTP/1.1 400 Bad Request');
			header('Content-Type: application/json; charset=UTF-8');
			$response['message'] = 'There is a problem with your request. Please try again later!';
			$response['code'] = 400;
		}

		echo json_encode($response);
	}
}
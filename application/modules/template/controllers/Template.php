<?php

class Template extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->module('Account');
	}

	function call_admin_template($data = NULL)
	{
		$user_details = $this->M_Account->getUser($this->session->userdata('emailaddress'));

		if($user_details)
		{
			$data['template_user_details'] = $user_details;
			
			$this->load->view('template/admin_v', $data);
		}
		else
		{
			redirect(base_url() . 'Account/signin');
		}
	}

	function call_admin_signin($data = NULL)
	{
		$this->load->view('template/signin_v', $data);
	}
}
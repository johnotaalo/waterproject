<?php

class Template extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function call_admin_template($data = NULL)
	{
		$this->load->view('template/admin_v', $data);
	}
}
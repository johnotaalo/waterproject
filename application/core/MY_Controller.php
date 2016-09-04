<?php

class MY_Controller extends MX_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->module([
			'template',
			'Account'
		]);

		$this->config->set_item('system_variable', 'VAR-001');

		$controller = $this->uri->segment(1);

		if($controller != 'Account')
		{
			$this->account->checklogin();
		}
		
	}

	function month_select_box() {
		$month_options = '';
		for( $i = 1; $i <= 12; $i++ ) {
			$month_num = str_pad( $i, 2, 0, STR_PAD_LEFT );
			$month_name = date( 'F', mktime( 0, 0, 0, $i + 1, 0, 0 ) );
			$month_options .= '<option value="' . $month_num . '">' . $month_name . '</option>';
		}
		return $month_options;
	}
}
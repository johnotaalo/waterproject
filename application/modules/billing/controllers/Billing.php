<?php

class Billing extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Billing');
	}

	function index()
	{
		$year = date("Y");
		$month = date("m");
		redirect(base_url() . "Billing/Information/{$year}/{$month}");
	}

	function Information($year, $month)
	{
		$data['title'] = 'Billing Information';
		$data['content_view'] = 'billing/billing_v';
		$dateObj = DateTime::createFromFormat("!m", $month);
		$data["month_words"] = $dateObj->format("F");
		$data["month"] = $month;
		$data["year"] = $year;

		$data["month_list"] = $this->create_month_list($month);

		$billing = $this->M_Billing->getBillingYear($year, $month);

		if ($billing) {
			$data['billing_id'] = $billing->id;
		}

		$this->template->call_admin_template($data);
	}

	function newBilling($year, $month)
	{
		$billing = $this->M_Billing->getBillingYear($year, $month);

		if (!$billing) {
			$added = $this->M_Billing->addBilling(['year' =>$year, 'month' => $month]);
		}
		redirect(base_url() . 'Billing/Information/' . $year . "/" . $month);
	}

	function searchBillingInformation()
	{
		if ($this->input->post()) {
			redirect(base_url(). 'Billing/Information/' . $this->input->post('year') . "/" . $this->input->post('month'));
		}
	}

	function create_year_list($year)
	{
		$years = $this->M_Billing->getAvailableYears();

		// echo "<pre>";print_r($years);die;
	}

	function create_month_list($month = NULL)
	{
		$month_options = '';
		for( $i = 1; $i <= 12; $i++ ) {
			$month_num = str_pad( $i, 2, 0, STR_PAD_LEFT );
			$month_name = date( 'F', mktime( 0, 0, 0, $i + 1, 0, 0 ) );
			if($month == $month_num)
			{
				$month_options .= '<option value="' . $month_num . '" selected>' . $month_name . '</option>';
			}
			else
			{
				$month_options .= '<option value="' . $month_num . '">' . $month_name . '</option>';
			}
			
		}

		return $month_options;
	}
}
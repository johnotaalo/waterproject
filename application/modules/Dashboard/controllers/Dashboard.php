<?php

class Dashboard extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('M_Dashboard');
	}

	function index()
	{
		$data['customer_numbers'] = $this->M_Dashboard->getCustomerNumber();
		$data['unpaid_bills'] = $this->M_Dashboard->getUnpaidBills()->amount;
		$data['total_revenue'] = $this->M_Dashboard->getTotalRevenue()->amount;
		$data['billing_months_numbers'] = $this->M_Dashboard->getBilledMonthsNumbers();

		// echo "<pre>";print_r($data);die;
		$data['content_view'] = 'Dashboard/dashboard_v';
		$this->template->call_admin_template($data);
	}
}
<?php

class StartUp extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('M_Billing');
	}

	function index()
	{

	}

	function CreateStartupDetails()
	{
		$data['months']	=	$this->month_select_box();
		$data['title']	=	"Starting Things Up";
		$data['content_view'] = 'Billing/startup';
		$this->template->call_admin_template($data);
	}

	function startbilling()
	{
		if ($this->input->post()) {
			$year	=	$this->input->post('year');
			$month	=	$this->input->post('month');

			// echo $year . $month;die;

			$billing_month = $this->M_Billing->exists($year, $month);

			if ($billing_month) {
				$this->session->set_flashdata('error', "This combination already exists");
				redirect("Billing/StartUp/CreateStartupDetails");
			}
			else
			{
				$array = [
				'startup' => [
						'year'	=>	$year,
						'month'	=>	$month
					]
				];

				$content = json_encode($array, JSON_NUMERIC_CHECK);

				file_put_contents(CONFIGPATH . 'config.ini', $content);

				$post_data = [
					'year'				=>	$year,
					'month'				=>	$month,
					'billcheckingdate'	=>	$year . '-' . $month . '-01'
				];

				$billing_id = $this->M_Billing->addBillingMonth($post_data);

				$this->load->model('Customer/M_Customer');

				$customers = $this->M_Customer->getCustomers();

				if ($customers) {
					foreach ($customers as $customer) {
						$post_data = [
							'customer_id'		=>	$customer->id,
							'billing_id'		=>	$billing_id,
							'meter_reading_date'=>	date('Y-m-d'),
							'meter_reading'		=>	0,
							'water_used'		=>	0,
							'amount'			=>	0
						];

						$this->M_Billing->addBillingInformation($post_data);
					}
				}

				redirect("Billing");
			}
		}
	}
}
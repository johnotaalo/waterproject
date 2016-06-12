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
		redirect(base_url() . 'Billing/BillingMonths');
	}

	function BillingMonths()
	{
		$data['title'] = "Billing Months";
		$data['content_view'] = 'Billing/billing_v';
		$data['months_list'] = $this->create_billing_months_table();
		$this->template->call_admin_template($data);
	}

	function create_billing_months_table()
	{
		$billing_months = $this->M_Billing->getBillingMonths();

		$months_list = "";
		if ($billing_months) {
			$counter = 1;
			foreach ($billing_months as $month) {
				$dateObj = DateTime::createFromFormat('!m', $month->month);
				$monthName = $dateObj->format('F');
				$volume_for_the_month = $this->M_Billing->getMonthlyVolume($month->id);
				$months_list .= '<tr>';
				$months_list .= "<td>{$counter}</td>";
				$months_list .= "<td>{$month->year}, {$monthName}</td>";
				$months_list .= "<td>{$volume_for_the_month->water_used}</td>";
				$months_list .= "<td><a href = '".base_url()."Billing/Information/{$month->id}' class = 'label label-primary'>Billing Information</a></td>";
				$months_list .= '</tr>';
				$counter++;
			}
		}

		return $months_list;
	}

	function Information($billing_id)
	{
		$data['month_details'] = $this->M_Billing->getMonthDetails($billing_id);
		if($data['month_details'])
		{
			$dateObj = DateTime::createFromFormat('!m', $data['month_details']->month);
			$data['month_name'] = $dateObj->format('F');
			$data['title'] = 'Billing Information';
			$data['content_view'] = 'Billing/billing_information_v';
			$data['billing_id'] = $billing_id;
			$data['billing_information'] = $this->create_billing_information_table($billing_id);
			$this->template->call_admin_template($data);
		}
	}

	function create_billing_information_table($billing_id)
	{
		$billing_information = $this->M_Billing->getBillingInformation($billing_id);

		$billing_information_table = "";

		if ($billing_information) {
			$counter = 1;
			foreach ($billing_information as $key => $value) {
				$billing_information_table .= '<tr>';
				$billing_information_table .= "<td>{$counter}</td>";
				$billing_information_table .= "<td>{$value->firstname}, {$value->othernames}</td>";
				$billing_information_table .= "<td>{$value->plotnumber}</td>";
				$billing_information_table .= "<td>{$value->water_used}</td>";
				$billing_information_table .= "<td class = 'text-center'>";
				if ($value->water_used != "") {
					$billing_information_table .= "<a href = '#' class = 'btn btn-primary btn-sm btn-information' data-id = '{$value->id}'><i class = 'fa fa-pencil'></i>&nbsp;&nbsp;Edit</a>";
				}
				else
				{
					$billing_information_table .= "<a href = '#' class = 'btn btn-primary btn-sm btn-information' data-id = '{$value->id}'><i class = 'fa fa-plus'></i>&nbsp;&nbsp;Add</a>";
				}

				$billing_information_table .= "&nbsp;&nbsp;<a href = '#' class = 'btn btn-warning btn-sm'><i class = 'fa fa-envelope-o'></i>&nbsp;&nbsp;Email Invoice</a>";
				$billing_information_table .= "</td>";
				$billing_information_table .= '</tr>';

				$counter++;
			}
		}

		return $billing_information_table;
	}

	function customerData($type, $billing_id, $customer_id)
	{
		$data['customerData'] = $this->M_Billing->getCustomerData($customer_id, $billing_id);
		$data['billing_id'] = $billing_id;
		$data['customer_id'] = $customer_id;

		$data['page'] = $this->load->view('billing/customer_data_v', $data, TRUE);
		$data['type'] = 'success';

		echo json_encode($data);
	}
}
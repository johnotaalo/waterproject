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
				$months_list .= "<td class = 'text-center'>{$volume_for_the_month->water_used}</td>";
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
				$billing_information_table .= "<td>{$value->supply_location}</td>";
				$billing_information_table .= "<td class = 'text-center'>{$value->water_used}</td>";
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

		$data['title'] = "Billing details for " . $data['customerData']->firstname . " " . $data['customerData']->othernames;
		$data['page'] = $this->load->view('billing/customer_data_v', $data, TRUE);
		$data['type'] = 'success';

		echo json_encode($data);
	}

	function addBillingInformation($billing_id, $customer_id)
	{
		if ($this->input->post()) {
			$exists = $this->M_Billing->getBiilingExistence($billing_id, $customer_id);

			$data['meter_reading'] = $this->input->post('meter_reading');
			$data['meter_reading_date'] = date('Y-m-d', strtotime($this->input->post('meter_reading_date')));
			$data['water_used'] = $this->input->post('water_used');
			$data['amount'] = $data['water_used'] * 100 + 50;
			if ($exists) {
				$this->M_Billing->updateBillingInformation($customer_id, $billing_id, $data);
			}
			else
			{
				$data['customer_id'] = $customer_id;
				$data['billing_id'] = $billing_id;

				$this->M_Billing->addBillingInformation($data);
			}
		}
		
		redirect(base_url() . "Billing/Information/{$billing_id}");

	}

	function addBillingMonth()
	{
		if ($this->input->post()) {

			$exists = $this->M_Billing->exists($this->input->post('year'), $this->input->post('month'));
			if(!$exists)
			{
				$post_data['month'] = $this->input->post('month');
				$post_data['year'] = $this->input->post('year');
				$post_data['billcheckingdate'] = $this->input->post('year') . "-" . $this->input->post('month') . "-1";

				$this->M_Billing->addBillingMonth($post_data);

				$billing_id = $this->db->insert_id();

				redirect(base_url() . "Billing/Information/{$billing_id}");
			}
			else
			{
				$this->session->set_flashdata('type', 'error');
				$this->session->set_flashdata('message', 'The month you tried to enter already exists! Please try another year and month combination');
				redirect(base_url() . 'Billing');
			}
		}
		else
		{
			$modal_data['months'] = $this->month_select_box();
			$data['page'] = $this->load->view("billing/add_billing_month_v", $modal_data, TRUE);
			$data['title'] = "<i class = 'fa fa-calendar-plus-o'></i>&nbsp;Create a New Billing Month";

			echo json_encode($data);
		}
	}

	function SendInvoices($billing_id)
	{
		$eligible_customers = $this->M_Billing->get_customers_with_monthly_bill($billing_id);

		if ($eligible_customers) {
			foreach ($eligible_customers as $customer) {
				$this->send_invoice_to_customer($billing_id, $customer->id);
			}
		}
	}


	function send_invoice_to_customer($billing_id, $customer_id)
	{
		$this->load->module('customer');

		$customer_details = $this->M_Customer->getCustomerById($customer_id);

		$email = $customer_details->emailaddress;
		$fullname = $customer_details->firstname . " " . $customer_details->othernames;

		$carried_forward = $this->M_Billing->getCustomersCarriedForward($customer_id, $billing_id);

		$carried_forward = ($carried_forward) ? $carried_forward->carried_forward : 0;

		$month_billing_details = $this->M_Billing->get_month_payment_details($customer_id, $billing_id);

		$dateObj = DateTime::createFromFormat('!m', $month_billing_details->month);
		$monthName = $dateObj->format('F');

		$previous_data = $this->M_Billing->getPreviousData($customer_id, $billing_id);

		echo "<pre>";print_r($previous_data);die;
	}
}
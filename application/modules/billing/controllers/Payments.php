<?php

class Payments extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(['M_Payments', 'M_Billing']);
	}

	function index()
	{
		redirect(base_url() . 'Billing/Payments/data' );
	}

	function data()
	{
		$data['customer_payments_data_table'] = $this->create_customer_payments_data_table();
		$data['content_view'] = 'billing/payments_v';
		$data['title'] = "Customer Payments";

		$this->template->call_admin_template($data);
	}

	function create_customer_payments_data_table()
	{
		$this->load->module('customer');

		$customers = $this->M_Customer->getCustomers();

		$customer_payments_data_table = '';

		if ($customers) {

			$customer_no = 1;
			foreach ($customers as $customer) {
				$customer_payments_data_table .= "<tr>";
				$customer_payments_data_table .= "<td>{$customer_no}</td>";
				$customer_payments_data_table .= "<td>{$customer->firstname}, {$customer->othernames}</td>";
				$customer_payments_data_table .= "<td>{$customer->phonenumber}</td>";
				$customer_payments_data_table .= "<td>{$customer->emailaddress}</td>";

				$total_amount_paid = $this->M_Payments->getTotalAmountPaidByCustomer($customer->id);
				$total_amount_charged = $this->M_Payments->getTotalAmountChargedByCustomer($customer->id);

				$total_amount_due =$total_amount_charged->amount - $total_amount_paid->amount_paid;

				$customer_payments_data_table .= "<td>{$total_amount_due}</td>";

				$customer_payments_data_table .= "<td><div class = 'btn-group'><a href = '".base_url()."Billing/Payments/addPayment/{$customer->id}' class = 'btn btn-sm btn-default call-modal'><i class = 'fa fa-plus'></i>&nbsp;Add Payments</a><a href = '".base_url()."Billing/Payments/History/{$customer->id}' class = 'btn btn-sm btn-default'><i class = 'fa fa-calendar'></i>&nbsp;View History</a></div></td>";
				$customer_payments_data_table .= "</tr>";
				$customer_no++;
			}
		}

		return $customer_payments_data_table;
	}

	function addPayment($customer_id)
	{
		$this->load->module('customer');
		if ($this->input->post()) {
			$data['comment'] = $this->input->post('comment');
			$data['payment_for'] = $this->input->post('payment_for');
			$data['amount_paid'] = $this->input->post('amount');
			$data['customer_id'] = $customer_id;

			$this->M_Payments->addPayment($data);

			redirect(base_url() . 'Billing/Payments/');
		}
		else{
			$customerDetails = $this->M_Customer->getCustomerById($customer_id);
			$data['customerData'] = $customerDetails;
			$data['payment_for_select'] = $this->create_payment_for_select();
			$return_data['title'] = "Add Payment for {$customerDetails->firstname}, {$customerDetails->othernames}";
			$return_data['page'] = $this->load->view('billing/add_payment_v', $data, true);

			echo json_encode($return_data);
		}
	}

	function create_payment_for_select()
	{
		$payment_for = $this->M_Payments->getPaymentForData();

		$payment_for_select_string = '';
		if ($payment_for) {
			foreach ($payment_for as $key => $value) {
				$payment_for_select_string .= "<option value = '{$value->id}'>{$value->text}</option>";
			}
		}

		return $payment_for_select_string;
	}

	function History($customer_id)
	{
		$this->load->module('customer');
		$data['title'] = "Customer Transaction History";
		$data['customer_data'] = $this->M_Customer->getCustomerById($customer_id);
		$data['bills'] = $this->generateBillingInformation($customer_id);
		$data['payments'] = $this->generatePaymentInformation($customer_id);

		$data['content_view'] = "billing/history_v";
		$this->template->call_admin_template($data);
	}

	function generateBillingInformation($customer_id)
	{
		$customer_billing_information = $this->M_Billing->getCustomerBillingInformation($customer_id);
		$customer_billing_table = "";
		if ($customer_billing_information) {
			$counter = 1;
			foreach ($customer_billing_information as $info) {
				$dateObj = DateTime::createFromFormat('!m', $info->month);
				$monthName = $dateObj->format('F');
				$customer_billing_table .= "<tr>";
				$customer_billing_table .= "<td>{$counter}.</td>";
				$customer_billing_table .= "<td>{$info->year}, {$monthName}</td>";
				$customer_billing_table .= "<td> Ksh. ".number_format($info->amount, 2)."</td>";
				$customer_billing_table .= "</tr>";
				$counter++;
			}
		}

		return $customer_billing_table;
	}

	function generatePaymentInformation($customer_id)
	{
		$customer_payment_information = $this->M_Payments->getPaymentInformation($customer_id);
		$customer_payment_table = "";

		if ($customer_payment_information) {
			$counter = 1;
			foreach ($customer_payment_information as $info) {
				$customer_payment_table .= "<tr>";
				$customer_payment_table .= "<td>{$counter}.</td>";
				$customer_payment_table .= "<td>".date('d-m-Y', strtotime($info->paid_on))."</td>";
				$customer_payment_table .= "<td>Ksh. ".number_format($info->amount_paid)."</td>";
				$customer_payment_table .= "</tr>";
				$counter++;
			}
		}

		return $customer_payment_table;
	}
}
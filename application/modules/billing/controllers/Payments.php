<?php

class Payments extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Payments');
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

	function History($customer_id)
	{

	}

	function addPayment($customer_id)
	{
		$this->load->module('customer');
		$customerDetails = $this->M_Customer->getCustomerById($customer_id);
		$data['customerData'] = $customerDetails;
		$data['payment_for_select'] = $this->create_payment_for_select();
		$return_data['title'] = "Add Payment for {$customerDetails->firstname}, {$customerDetails->othernames}";
		$return_data['page'] = $this->load->view('billing/add_payment_v', $data, true);

		echo json_encode($return_data);
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
}
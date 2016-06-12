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

		$billing_data = $this->create_payment_list($year, $month);
		$data['billing_data'] = $billing_data['payment_list_table'];
		$data['total_monthly_balance'] = number_format($billing_data['overall_total_due'], 2);
		$data['total_carried_forward'] = number_format($billing_data['total_carried_forward'], 2);

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
			$added = $this->M_Billing->addBilling(['year' =>$year, 'month' => $month, 'billcheckingdate' => $year .'-'.$month .'-01']);
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

	function create_payment_list($year, $month)
	{
		$this->load->model('customer/M_Customer');
		$customers = $this->M_Customer->getCustomers();

		$payment_list_table = '';
		$overall_total_due = $total_carried_forward = 0;
		if (count($customers)) {
			$counter = 1;
			foreach ($customers as $customer) {
				$payment_list_table .= "<tr>
				<input type = 'hidden' name = 'customer_id[]' value = '{$customer->id}'/>";
				$payment_list_table .= "<td>{$counter}</td>";
				$payment_list_table .= "<td>{$customer->firstname}, {$customer->othernames}</td>";

				$total_amount_paid = $this->M_Billing->get_total_amount_paid_by_customer($customer->id, $year, $month);
				$total_amount_due = $this->M_Billing->get_total_amount_due_by_customer($customer->id);

				$carried_forward = $total_amount_due->amount - $total_amount_paid->amount_paid;
				// echo "<pre>";print_r($carried_forward);

				$total_carried_forward += $carried_forward;

				$color = "";

				if ($carried_forward < 0) {
					$color = 'green';
				}
				else if($carried_forward > 0)
				{
					$color = 'red';
				}

				$payment_list_table .= "<td style = 'color: {$color}'>Ksh. <span>".abs($carried_forward)."</span></td>";

				$amount_used = $this->M_Billing->get_amount_used_by_customer_in_month($customer->id, $year, $month);

				$amount_used_cash = ($amount_used) ? $amount_used->amount : 50;
				$amount_used_water = ($amount_used) ? $amount_used->water_used : 0;
				$total_due = $amount_used_cash + $carried_forward;

				$overall_total_due += $total_due;

				$amount_to_be_paid = $amount_used_water * 100 + 50;

				$payment_list_table .= "<td style = 'width: 30%;'><input name = 'customer_usage[]' style = 'width: 20%' class = 'form-control amount_used' type = 'text' value = '{$amount_used_water}' /> x Ksh. 100 + Ksh. 50 = Ksh. <span class = 'amount_to_be_paid'>{$amount_to_be_paid}</span></td>";
				$payment_list_table .= "<td>Ksh. <span class = 'total_due' data-customer-id = '{$customer->id}'>{$total_due}</span></td>";
				$payment_list_table .= '</tr>';
				$counter++;
			}

			$billing_data = [
				'payment_list_table' => $payment_list_table,
				'overall_total_due' => $overall_total_due,
				'total_carried_forward' => $total_carried_forward
			];
		}

		return $billing_data;
	}

	function addCustomerBillingInformation($year, $month)
	{
		if ($this->input->post('customer_id')) {
			unset($_POST['DataTables_Table_0_length']);
			$billing = $this->M_Billing->getBillingYear($year, $month);
			if($billing)
			{
				$data = array();
				foreach ($this->input->post('customer_id') as $key => $value) {
					$data[] = [
						'customer_id' => $value,
						'water_used' => $this->input->post('customer_usage')[$key],
						'billing_id' => $billing->id,
						'amount' => $this->input->post('customer_usage')[$key] * 100 + 50
					];
				}

				if (count($data)) {
					foreach ($data as $customer_data) {
						$exists = $this->M_Billing->getCustomerBillingInformation($customer_data['customer_id'], $billing->id);

						if ($exists) {
							unset($customer_data['customer_id']);
							unset($customer_data['billing']);

							$this->M_Billing->updateCustomerBillingInformation($exists->id, $customer_data);
						}
						else
						{
							$this->M_Billing->addCustomerBillingInformation($customer_data);
						}
					}
				}

				redirect(base_url(). "Billing/Information/{$year}/{$month}");
			}
		}
	}
}
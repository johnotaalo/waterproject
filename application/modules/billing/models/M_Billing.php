<?php

class M_Billing extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getBillingYear($year, $month)
	{
		$query = $this->db->get_where('billing', ['year' => $year, 'month' => $month], 1);

		return $query->row();
	}

	function addBilling($data)
	{
		$result = $this->db->insert('billing', $data);

		return $result;
	}

	function getAvailableYears()
	{
		$this->db->distinct('year');
		$this->db->order_by('year', 'desc');
		$this->db->select('year');

		$query = $this->db->get('billing');

		return $query->result();
	}

	function getBalanceCarriedForward($customer_id, $year, $month)
	{
		$sql = "SELECT SUM(cp.amount_paid) AS total_paid, SUM(cb.amount) AS amount_used FROM customer c 
		LEFT JOIN customer_payment cp ON c.id = cp.customer_id
		LEFT JOIN customer_billing cb ON cb.customer_id = c.id
		LEFT JOIN billing b ON b.id = cb.billing_id
		WHERE c.id = 1
		AND b.year <= '2016' AND b.month <= '06'
		GROUP BY c.id ";
	}

	function get_total_amount_paid_by_customer($customer_id, $year, $month)
	{
		$this->db->where(
			[
				'customer_id' => $customer_id
			]
		);
		$this->db->select_sum('amount_paid');
		$query = $this->db->get('customer_payment');

		return $query->row();
	}

	function get_total_amount_due_by_customer($customer_id)
	{
		$this->db->where([
			'customer_id' => $customer_id
		]);
		$this->db->select_sum('amount');
		$query = $this->db->get('customer_billing');

		return $query->row();
	}

	function get_amount_used_by_customer_in_month($id, $year, $month)
	{
		$this->db->select('water_used, amount');
		$this->db->from('customer_billing');
		$this->db->join('billing', 'customer_billing.billing_id = billing.id');
		$this->db->where([
						'billing.year' => $year,
						'billing.month' => $month,
						'customer_billing.customer_id' => $id
						]);
		$query = $this->db->get();

		return $query->row();
	}

	function getCustomerBillingInformation($customer_id, $billing_id)
	{
		$this->db->where([
				'customer_id'=> $customer_id,
				'billing_id' => $billing_id
		]);

		$query = $this->db->get('customer_billing');

		return $query->row();
	}

	function updateCustomerBillingInformation($id, $customer_data)
	{
		$this->db->where('id', $id);

		$this->db->update('customer_billing', $customer_data);
	}

	function addCustomerBillingInformation($customer_data)
	{
		$this->db->insert('customer_billing', $customer_data);
	}

}
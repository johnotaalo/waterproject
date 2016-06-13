<?php

class M_Payments extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getTotalAmountPaidByCustomer($customer_id)
	{
		$this->db->where('customer_id', $customer_id);

		$this->db->select_sum('amount_paid');

		$query = $this->db->get('customer_payment');

		return $query->row();
	}

	function getTotalAmountChargedByCustomer($customer_id)
	{
		$this->db->where('customer_id', $customer_id);

		$this->db->select_sum('amount');

		$query = $this->db->get('customer_billing');

		return $query->row();
	}

	function getPaymentForData()
	{
		$query = $this->db->get('payment_for_types');

		return $query->result();
	}
}
<?php

class M_Billing extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getBillingMonths()
	{
		$this->db->order_by('billcheckingdate', 'DESC');
		$query = $this->db->get('billing');

		return $query->result();
	}

	function getMonthlyVolume($id)
	{
		$this->db->where('billing_id', $id);

		$this->db->select_sum('water_used');

		$query = $this->db->get('customer_billing');

		return $query->row();
	}

	function getMonthDetails($billing_id)
	{
		$this->db->where('id', $billing_id);

		$query = $this->db->get('billing');

		return $query->row();
	}

	function getBillingInformation($billing_id)
	{
		$sql = "SELECT c.*, cb.water_used FROM customer c
		LEFT JOIN customer_billing cb ON cb.customer_id = c.id AND cb.billing_id = $billing_id";

		$query = $this->db->query($sql);

		return $query->result();
	}

	function getCustomerData($customer_id, $billing_id)
	{
		$sql = "SELECT c.*, cb.water_used FROM customer c
		JOIN customer_billing cb ON cb.customer_id = c.id AND cb.billing_id = $billing_id
		WHERE c.id = {$customer_id}";

		$query = $this->db->query($sql);

		return $query->row();
	}

}
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

}
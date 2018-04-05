<?php

class M_Dashboard extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getCustomerNumber()
	{
		$this->db->where_in('is_active', [0,1]);
		$query = $this->db->get('customer');

		return $query->num_rows();
	}

	function getUnpaidBills()
	{
		$this->db->where('paid', 0);

		$this->db->select_sum('amount');

		$query = $this->db->get('customer_billing');

		return $query->row();
	}

	function getTotalRevenue()
	{
		$this->db->where('paid', 1);

		$this->db->select_sum('amount');

		$query = $this->db->get('customer_billing');

		return $query->row();
	}

	function getBilledMonthsNumbers()
	{
		$query = $this->db->get('billing');

		return $query->num_rows();
	}
}
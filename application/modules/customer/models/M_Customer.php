<?php

class M_Customer extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addCustomer()
	{
		$result = $this->db->insert('customer', $this->input->post());

		return $result;
	}

	function getCustomers()
	{
		$this->db->where_in('is_active', [0, 1]);
		$query = $this->db->get('customer');

		return $query->result();
	}

	function updateCustomer($customer_id, $update_data = NULL)
	{
		$update_data = ($update_data == NULL) ? $this->input->post() : $update_data;

		$this->db->where('id', $customer_id);

		$result = $this->db->update('customer', $update_data);

		return $result;
	}

	function getCustomerById($id)
	{
		$this->db->where_in('is_active', [0, 1]);
		$query = $this->db->get_where('customer', ['id' => $id]);

		return $query->row();
	}
}
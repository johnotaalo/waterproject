<?php

class M_Customer extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addCustomer($data = array())
	{
		$insert_data = ($this->input->post()) ? $this->input->post() : $data;

		$result = $this->db->insert('customer', $insert_data);

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

	function getCustomerMonthUsed($billing_id, $customer_id)
	{
		$this->db->where([
				'billing_id'	=>	$billing_id,
				'customer_id'	=>	$customer_id
			]);

		$query = $this->db->get('customer_billing');

		return $query->row();
	}

	function getTotalDueByCustomer($customer_id)
	{
		$this->db->where([
			'customer_id'	=>	$customer_id,
			'paid'			=>	0
		]);
		$this->db->select_sum('amount');

		$query = $this->db->get('customer_billing');

		return $query->row();
	}
<<<<<<< HEAD
	function clearBill($billing_id)
	{
		$this->db->where('billing_id', $billing_id);
=======
	function clearBill($billing_id, $customer_id)
	{
		$this->db->where([
			'billing_id'	=>	$billing_id,
			'customer_id'	=>	$customer_id
		]);
>>>>>>> 217e66f330893f9097dd86605d049ffee36ff4e7
		$this->db->update('customer_billing', ['paid' => 1]);

		return true;
	}
}
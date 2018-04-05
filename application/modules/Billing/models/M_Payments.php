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

	function addPayment($data)
	{
		$inserted = $this->db->insert('customer_payment', $data);
        if (!$inserted):
            $errors = $this->db->error();
            echo "<pre>";print_r($errors);die;
        endif;

        return $inserted;
	}

	function getPaymentInformation($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		$this->db->order_by('paid_on', 'DESC');
		$this->db->from('customer_payment');
		$this->db->join('payment_for_types', 'customer_payment.payment_for_id = payment_for_types.id');

		$query = $this->db->get();

		return $query->result();


	}
}
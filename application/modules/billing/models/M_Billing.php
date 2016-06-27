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
		LEFT JOIN customer_billing cb ON cb.customer_id = c.id AND cb.billing_id = $billing_id
		WHERE c.is_active != -1";

		$query = $this->db->query($sql);

		return $query->result();
	}

	function getCustomerData($customer_id, $billing_id)
	{
		$sql = "SELECT c.*, cb.meter_reading_date, cb.meter_reading, cb.water_used FROM customer c
		LEFT JOIN customer_billing cb ON cb.customer_id = c.id AND cb.billing_id = $billing_id
		WHERE c.id = {$customer_id}";

		$query = $this->db->query($sql);

		return $query->row();
	}

	function getBiilingExistence($billing_id, $customer_id)
	{
		$this->db->where([
			'billing_id' => $billing_id,
			'customer_id' => $customer_id
		]);

		$query = $this->db->get('customer_billing');

		return $query->row();
	}

	function updateBillingInformation($customer_id, $billing_id, $data)
	{
		$this->db->where(['customer_id' => $customer_id, 'billing_id' => $billing_id]);
		$this->db->update('customer_billing', $data);
	}

	function addBillingInformation($data)
	{
		$this->db->insert('customer_billing', $data);
	}

	function getCustomerBillingInformation($customer_id)
	{
		$this->db->where(['customer_id' => $customer_id]);

		$this->db->from('customer_billing');
		$this->db->join('billing', 'billing.id = customer_billing.billing_id');
		$query = $this->db->get();

		return $query->result();
	}

	function exists($year, $month)
	{
		$this->db->where(['year' => $year, 'month' => $month]);
		$query = $this->db->get('billing');

		return $query->row();
	}

	function addBillingMonth($post_data)
	{
		$this->db->insert('billing', $post_data);

		return $this->db->insert_id();
	}

	function get_customers_with_monthly_bill($billing_id)
	{
		$sql = "SELECT id FROM customer WHERE id IN (SELECT customer_id FROM customer_billing WHERE billing_id = {$billing_id})";

		return $this->db->query($sql)->result();
	}

	function getCustomersCarriedForward($customer_id, $billing_id)
	{
		$query = $this->db->query("SELECT SUM(amount) - (SELECT SUM(amount_paid) FROM customer_payment WHERE customer_id = 1) as carried_forward FROM customer_billing WHERE customer_id = {$customer_id} AND billing_id != {$billing_id}");

		return $query->row();
	}

	function get_month_payment_details($customer_id, $billing_id)
	{
		$query = $this->db->query("SELECT b.year, b.month, cb.water_used, cb.meter_reading, cb.meter_reading_date, cb.amount FROM customer_billing cb
			JOIN billing b ON b.id = cb.billing_id
			WHERE cb.customer_id = {$customer_id} AND b.id = {$billing_id}");

		return $query->row();
	}

	function getPreviousData($customer_id, $billing_id)
	{
		$query = $this->db->query("SELECT cb.meter_reading_date, cb.meter_reading FROM customer_billing cb
			JOIN billing b ON b.id = cb.billing_id
			WHERE cb.customer_id = {$customer_id} AND b.id != $billing_id AND cb.meter_reading_date > b.billcheckingdate
			ORDER BY b.billcheckingdate DESC
			LIMIT 1");

		return $query->row();
	}

	function getPreviousBillingData($billing_id, $customer_id)
	{
		$this->db->select_max('id');
		$this->db->where('id <', $billing_id);

		$query = $this->db->get('billing');

		$id = $query->row();

		if ($id) {
			$this->db->where([
					'billing_id' 	=>	$id->id,
					'customer_id'	=>	$customer_id
				]);

			$query = $this->db->get('customer_billing');

			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}

	function getCurrentBillingMonth()
	{
		$this->db->select_max('id');

		$id = $this->db->get('billing')->row();

		if ($id) {
			$this->db->select('year, month');

			$this->db->where('id', $id->id);

			$result = $this->db->get('billing')->row();

			return $result;
		}
		else
		{
			return FALSE;
		}
	}
}
<?php

defined("BASEPATH") or exit("No direct script access allowed");

class M_Settings extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getStandingCharges()
	{
		$query = $this->db->get('standing_charges');

		return $query->result();
	}

	function addStandingCharge($insert_data)
	{
		$this->db->insert('standing_charges', $insert_data);
	}

	function deactivateAllCharges()
	{
		$sql = "UPDATE standing_charges SET is_active = 0";

		$this->db->query($sql);
	}

	function findChargeByAmount($amount)
	{
		$this->db->where('amount', $amount);

		$query = $this->db->get('standing_charges');

		return $query->result();
	}

	function activateChargeById($id)
	{
		$this->db->where('id', $id);

		$result = $this->db->update('standing_charges', ['is_active'	=>	1]);

		return $result;
	}

	function findVariables()
	{
		$query = $this->db->get("system_variables");

		return $query->result();
	}

	function addVariables($data)
	{
		$this->db->insert('system_variables', $data);
	}

	function updateVariables($data)
	{
		$this->db->where('id', $this->config->item('system_variable'));
		$this->db->update('system_variables', $data);
	}

	function findVariablesById($variable_id)
	{
		$this->db->where('id', $variable_id);

		$query = $this->db->get('system_variables');

		return $query->row();
	}

	function findBillingByChargeId($charge_id)
	{
		$this->db->where('standing_charge_id', $charge_id);

		$query = $this->db->get('customer_billing');

		return $query->result();
	}

	function deleteCharge($charge_id)
	{
		$this->db->query("DELETE FROM standing_charges WHERE id = {$charge_id}");
	}
}
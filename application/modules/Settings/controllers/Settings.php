<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Settings extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Settings');
	}

	function index()
	{
		$data['title'] = "System Settings";

		$data['content_view'] = 'Settings/settings_v';

		$data['standing_charges'] = $this->createStandingChargesTable();
		$data['variables_details'] = $this->M_Settings->findVariablesById($this->config->item('system_variable'));

		$this->template->call_admin_template($data);
	}

	function createStandingChargesTable()
	{
		$standing_charges = $this->M_Settings->getStandingCharges();

		$standing_charges_table = "";

		if ($standing_charges) {
			$counter = 1;
			foreach ($standing_charges as $charge) {
				$standing_charges_active = "";
				if ($charge->is_active == 0) {
					$standing_charges_active = "<a class = 'label label-warning charge-activation' data-id = '{$charge->id}' data-action = 'activate' title = 'Click to activate'>Inactive</a>";
				}else{
					$standing_charges_active = "<a class = 'label label-success charge-activation' data-id = '{$charge->id}' data-action = 'deactivate' title = 'Click to deactivate'>Active</a>";
				}

				$standing_charges_table .= "<tr>
					<td>{$counter}</td>
					<td>{$charge->amount}</td>
					<td>{$standing_charges_active}</td>
					<td><a class = 'label label-danger delete-charge' data-id = '{$charge->id}'>Delete</a></td>
				</tr>";

				$counter++;
			}
		}else{
			$standing_charges_table = "<tr>
				<td colspan = '4'><center>There are no standing charges</center></td>
			</tr>";
		}

		return $standing_charges_table;
	}

	function addStandingCharge()
	{
		if ($this->input->post()) {

			$insert_data = [];
			$standing_charge = $this->input->post('standing_charge_amount');
			$current = $this->input->post('set_as_current');

			$insert_data['amount'] = $standing_charge;
			if ($current == "on") {
				//	Before you add update the others and set them to inactive
				$this->M_Settings->deactivateAllCharges();

				$insert_data['is_active'] = 1;
			}

			//	Now add the standing charge
			$this->M_Settings->addStandingCharge($insert_data);

			redirect(base_url() . "Settings");
		}
	}

	function search_amount($amount)
	{
		$charge = $this->M_Settings->findChargeByAmount($amount);

		$response = "";

		if ($charge) {
			$response['exists'] = true;
		}else{
			$response['exists'] = false;
		}

		echo json_encode($response);
	}

	function ChargeActivation()
	{
		if($this->input->post())
		{
			$action = $this->input->post('action');
			$id = $this->input->post('id');

			if ($action == "activate") {
				$response = [];
				//	Before you change to active update the others and set them to inactive
				$this->M_Settings->deactivateAllCharges();

				$result = $this->M_Settings->activateChargeById($id);
				if ($result) {
					$response['type'] = true;
				}else{
					$response['type'] = false;
				}

				echo json_encode($response);
			}
		}
	}

	function ManageVariables()
	{
		$exists = $this->M_Settings->findVariables();

		$data = [];

		$data['company_name'] = $this->input->post('company_name');
		$data['company_phone_number'] = $this->input->post('company_phone_number');
		$data['company_email_address'] = $this->input->post('company_email_address');
		$data['company_address'] = $this->input->post('company_address');

		if (count($exists) == 0) {
			// Add the variables
			$data['id'] = $this->config->item('system_variable');

			$this->M_Settings->addVariables($data);
		}else{
			// Update the existing variable
			$this->M_Settings->updateVariables($data);
		}

		redirect(base_url() . 'Settings');
	}

	function searchUsedCharge($charge_id)
	{
		$exists = $this->M_Settings->findBillingByChargeId($charge_id);
		$response = [];
		if (count($exists) > 0) {
			$response['type'] = true;
		}else{
			$response['type'] = false;
		}

		if ($this->input->is_ajax_request()) {
			echo json_encode($response);
		}else{
			return $response['type'];
		}
	}

	function deleteCharge()
	{
		$exists = $this->M_Settings->findBillingByChargeId($charge_id);
		$response = [];
		if(count($exists) > 0)
		{
			$response['type'] = false;
		}
		else{
			$this->M_Settings->deleteCharge($this->input->post('id'));

			$response['type'] = true;
		}

		echo json_encode($response);
	}
}
<?php

class Customer extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Customer');
	}

	function index()
	{
		$data['title'] = "Customers page";
		$data['customers_list'] = $this->getcustomerslist();
		$data['content_view'] = "customer/customer_v";
		$this->template->call_admin_template($data);
	}

	function addcustomer()
	{
		if ($this->input->post()) {
			$added = $this->M_Customer->addCustomer();

			if ($added) {
				redirect(base_url() . 'Customer');
			} else {
				echo "There was a problem adding the customer. Please try again later";
			}

		}else{
			$data['title'] = "Add a Customer";
			$data['content_view'] = 'customer/add_customer_v';
			$this->template->call_admin_template($data);
		}
	}

	function getcustomerslist()
	{
		$customers_list = "";
		$customers = $this->M_Customer->getCustomers();

		if (count($customers)) {
			$count = 1;
			foreach ($customers as $customer) {
				$customers_list .= "<tr>";
				$customers_list .= "<td>{$count}</td>";
				$customers_list .= "<td>{$customer->firstname}</td>";
				$customers_list .= "<td>{$customer->othernames}</td>";
				$customers_list .= "<td>{$customer->phonenumber}</td>";
				$customers_list .= "<td>{$customer->emailaddress}</td>";
				$customers_list .= "<td class = 'text-center'>";
				if ($customer->is_active == 1) {
					$customers_list .= "<a data-action = 'deactivate' href = '".base_url()."Customer/activation/deactivate/{$customer->id}' class = 'label label-success activation'>Active</a>";
				}else{
					$customers_list .= "<a data-action = 'activate' href = '".base_url()."Customer/activation/activate/{$customer->id}' class = 'label label-danger activation'>Deactivated</a>";
				}
				$customers_list .= "</td>";
				$customers_list .= "<td><a href = '#' class = 'label label-primary text-center'>Billing Information</a></td>";
				$customers_list .= "<td class = 'text-center'><a href = '".base_url()."Customer/editCustomer/{$customer->id}'><i class = 'fa fa-pencil'></i></a>&nbsp;|&nbsp;<a data-action = 'delete' class = 'activation' href = '".base_url()."Customer/activation/delete/{$customer->id}'><i class = 'fa fa-trash'></td>";
				$customers_list .= "</tr>";
				$count++;
			}
		}

		return $customers_list;
	}

	function activation($type, $customer_id)
	{
		$activation_no = 0;
		switch ($type) {
			case 'deactivate':
				$activation_no = 0;
				break;
			case 'activate':
				$activation_no = 1;
				break;
			case 'delete':
				$activation_no = -1;
				break;
			default:
				$activation_no = 0;
				break;
		}

		$activated = $this->M_Customer->updateCustomer($customer_id, ['is_active' => $activation_no]);

		if ($activated) {
			redirect(base_url() . 'Customer');
		} else {
			echo "There was a problem updating the customer. Please try again later";
		}
	}

	function editCustomer($customer_id)
	{
		if ($this->input->post()) {
			$updated = $this->M_Customer->updateCustomer($customer_id, $this->input->post());

			if ($updated) {
				$this->session->set_flashdata('type', 'success');
				$this->session->set_flashdata('message', 'Successfully Editted customer\'s data');
				redirect(base_url() . "Customer/editCustomer/" . $customer_id);
			}
			else
			{
				$this->session->set_flashdata('type', 'error');
				$this->session->set_flashdata('message', 'There was a problem updating the customer. Please try again later');
				redirect(base_url() . "Customer/editCustomer/" . $customer_id);
			}
		}
		else
		{
			if (isset($customer_id)) {
				$customer = $this->M_Customer->getCustomerById($customer_id);

				if ($customer) {
					$data['customer_details'] = $customer;
					$data['content_view'] = 'customer/add_customer_v';
					$data['title'] = "Editting Customer";
					$data['page_header'] = "Editting: " . $customer->firstname . ", " . $customer->othernames;
					$this->template->call_admin_template($data);
				}
				else
				{
					die("There was an error finding this customer. Please go back and try again");
				}
			}
			else
			{
				redirect(base_url() . "Customer");
			}
		}
	}
}
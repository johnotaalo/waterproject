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
<<<<<<< HEAD

		$data['content_view'] = "Customer/customer_v";

=======
		$data['content_view'] = "Customer/customer_v";
>>>>>>> 217e66f330893f9097dd86605d049ffee36ff4e7
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
<<<<<<< HEAD

			$data['content_view'] = 'Customer/add_customer_v';

=======
			$data['content_view'] = 'Customer/add_customer_v';
>>>>>>> 217e66f330893f9097dd86605d049ffee36ff4e7
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

				$customers_list .= "<td>{$customer->ews_no}</td>";

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
<<<<<<< HEAD

				$customers_list .= "<td><a href = '".base_url()."Customer/billinginformation/{$customer->id}' class = 'label label-primary text-center'>Billing Information</a></td>";

=======
				$customers_list .= "<td><a href = '".base_url()."Customer/billinginformation/{$customer->id}' class = 'label label-primary text-center'>Billing Information</a></td>";
>>>>>>> 217e66f330893f9097dd86605d049ffee36ff4e7
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
<<<<<<< HEAD

					$data['content_view'] = 'Customer/add_customer_v';

=======
					$data['content_view'] = 'Customer/add_customer_v';
>>>>>>> 217e66f330893f9097dd86605d049ffee36ff4e7
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

<<<<<<< HEAD


	function billinginformation($customer_id)

	{

		$customer = $this->M_Customer->getCustomerById($customer_id);

		if ($customer) {

			$this->load->module("Billing");



			$billing = $this->M_Billing->getBillingMonths();

			$billing_table = "<tr><td colspan = '5'>There are no billing months yet. <a class = 'label label-success' href = '".base_url()."Billing'></a></td></tr>";

			if ($billing) {

				$billing_table = "";

				$counter = 1;

				foreach ($billing as $month) {

					$dateObj = DateTime::createFromFormat('!m', $month->month);

					$monthName = $dateObj->format('F');



					$volume_used = $this->M_Customer->getCustomerMonthUsed($month->id, $customer_id);



					$amount = ($volume_used) ? $volume_used->amount : "N/A";

					if ($volume_used) {

						$status = ($volume_used->paid == 1) ? "<a href = '#' class = 'text-green'>Paid</a>" : "<span class = 'text-red'>Not Paid</span>";

						$cleared = ($volume_used->paid == 1) ? "<a href = '#' class = 'text-muted'>cleared</a>" : "<a href = '".base_url()."Customer/clear_bill/{$month->id}/{$customer_id}'>Clear Bill?</a>";

					}

					else

					{

						$status = "N/A";

						$cleared = "N/A";

					}

					



					$billing_table .= '<tr>';

					$billing_table .= "<td>{$counter}</td>";

					$billing_table .= "<td>{$month->year}, {$monthName}</td>";

					$billing_table .= "<td>{$amount}</td>";

					$billing_table .= "<td>{$status}</td>";

					$billing_table .= "<td>{$cleared}</td>";

					$billing_table .= '</tr>';

					$counter++;

				}

			}



			$data['total_due'] 		=	$this->M_Customer->getTotalDueByCustomer($customer_id);

			$data['billing_table']	=	$billing_table;

			$data['customer']		=	$customer;

			$data['title']			=	"Billing Information for {$customer->firstname}";

			$data['content_view']	=	'Customer/billing_v';



			$this->template->call_admin_template($data);

		}

		else

		{

			die("There was an error getting this page");

		}

	}



	function clear_bill($billing_id, $customer_id)

	{

		$cleared = $this->M_Customer->clearBill($billing_id);

		if ($cleared) {

			redirect('Customer/billinginformation/' . $customer_id);

		}

	}

	function import_customer_data()
	{
		$file_path = './data/june_balances.xlsx';

		$this->load->module('Export');

		$customer_data = $this->export->import_excel($file_path);

		echo "<pre>";print_r($customer_data);die;

		$cleaned_customer_data = [];

		// cleaning $customer_data

		$counter = 0;
		foreach ($customer_data['values'] as $key => $value) {
			foreach ($value as $k => $v) {
				if($k != "" && $v != ""):
					$cleaned_customer_data[$counter][$customer_data['header'][1][$k]] = $v;
				endif;
			}
			$counter++;
		}

		// column mapping
		$column_map = [
			'customer_details'	=>	[
					'FIRST NAME'				=>	'firstname',
					'LAST NAME'					=>	'othernames',
					'CONTACT TEL'				=>	'phonenumber',
					'METER NO'					=>	'meter_no',
					'EWS NO.'					=>	'ews_no',
					'LOCATION'					=>	'supply_location'
			],
			'customer_billing'	=>	[
					'CURRRENT METER READING'	=>	'meter_reading',
					'BAL (KES)'					=>	'amount'
			]
		];

		$customer_mapped_data = [];
		foreach ($column_map as $table => $map_array) {
			foreach ($map_array as $k => $v) {
				foreach ($cleaned_customer_data as $key => $value) {
					$customer_mapped_data[$key][$table][$v] = $value[$k];
				}
			}	
		}

		$this->load->module('Billing');
		foreach ($customer_mapped_data as $key => $value) {
			$value['customer_details']['created_by'] = $this->session->userdata('user_id');
			$value['customer_details']['is_active'] = 1;

			$inserted = $this->M_Customer->addCustomer($value['customer_details']);

			if ($inserted) {
				if($value['customer_billing']['meter_reading'] != '' && $value['customer_billing']['amount'] != ''){
					$customer_id = $this->db->insert_id();

					$value['customer_billing']['customer_id'] = $customer_id;
					$value['customer_billing']['billing_id'] = 1;
					$value['customer_billing']['meter_reading_date'] = '2016-06-01';
					$value['customer_billing']['water_used'] = $value['customer_billing']['meter_reading'];

					$inserted = $this->M_Billing->addBillingInformation($value['customer_billing']);

					if(!$inserted)
					{
						die("There was an error with: {$customer_id}");
					}
				}
			}
		}

		redirect(base_url() . 'Customer');
	}

=======
	function billinginformation($customer_id)
	{
		$customer = $this->M_Customer->getCustomerById($customer_id);
		if ($customer) {
			$this->load->module("Billing");

			$billing = $this->M_Billing->getBillingMonths();
			$billing_table = "<tr><td colspan = '5'>There are no billing months yet. <a class = 'label label-success' href = '".base_url()."Billing'></a></td></tr>";
			if ($billing) {
				$billing_table = "";
				$counter = 1;
				foreach ($billing as $month) {
					$dateObj = DateTime::createFromFormat('!m', $month->month);
					$monthName = $dateObj->format('F');

					$volume_used = $this->M_Customer->getCustomerMonthUsed($month->id, $customer_id);

					$amount = ($volume_used) ? $volume_used->amount : "N/A";
					if ($volume_used) {
						$status = ($volume_used->paid == 1) ? "<a href = '#' class = 'text-green'>Paid</a>" : "<span class = 'text-red'>Not Paid</span>";
						$cleared = ($volume_used->paid == 1) ? "<a href = '#' class = 'text-muted'>cleared</a>" : "<a href = '".base_url()."Customer/clear_bill/{$month->id}/{$customer_id}'>Clear Bill?</a>";
					}
					else
					{
						$status = "N/A";
						$cleared = "N/A";
					}
					

					$billing_table .= '<tr>';
					$billing_table .= "<td>{$counter}</td>";
					$billing_table .= "<td>{$month->year}, {$monthName}</td>";
					$billing_table .= "<td>{$amount}</td>";
					$billing_table .= "<td>{$status}</td>";
					$billing_table .= "<td>{$cleared}</td>";
					$billing_table .= '</tr>';
					$counter++;
				}
			}

			$data['total_due']		=	$this->M_Customer->getTotalDueByCustomer($customer_id);
			$data['billing_table']	=	$billing_table;
			$data['customer']		=	$customer;
			$data['title']			=	"Billing Information for {$customer->firstname}";
			$data['content_view']	=	'Customer/billing_v';

			$this->template->call_admin_template($data);
		}
		else
		{
			die("There was an error getting this page");
		}
	}

	function clear_bill($billing_id, $customer_id)
	{
		$cleared = $this->M_Customer->clearBill($billing_id, $customer_id);
		if ($cleared) {
			redirect('Customer/billinginformation/' . $customer_id);
		}
	}
>>>>>>> 217e66f330893f9097dd86605d049ffee36ff4e7
}
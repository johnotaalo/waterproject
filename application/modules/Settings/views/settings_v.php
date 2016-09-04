<?php
	$company_name = $company_address = $company_phone_number = $company_email_address = "";

	if($variables_details != NULL)
	{
		$company_name = $variables_details->company_name;
		$company_address = $variables_details->company_address;
		$company_phone_number = $variables_details->company_phone_number;
		$company_email_address = $variables_details->company_email_address;
	}
?>
<div class = "col-md-12">
	<div class = "box box-default">
		<div class = "box-header with-border">
			<h3 class = "box-title">System Settings: Variables</h3>
		</div>
		<div class = "box-body">
			<form method="POST" action="<?= @base_url('Settings/ManageVariables'); ?>">

				<div class = "form-group">
					<div class = "input-group">
						<span class="input-group-addon">Company Name</span>
						<input type = "text" name = "company_name" class = "form-control" value = "<?= @$company_name; ?>" required/>
					</div>
				</div>

				<div class = "form-group">
					<div class = "input-group">
						<span class="input-group-addon">Company Address</span>
						<input type = "text" name = "company_address" class = "form-control" value = "<?= @$company_address; ?>"required/>
					</div>
				</div>

				<div class = "form-group">
					<div class = "input-group">
						<span class="input-group-addon">Company Phone Number</span>
						<input type = "text" name = "company_phone_number" class = "form-control" value = "<?= @$company_phone_number; ?>"required/>
					</div>
				</div>

				<div class = "form-group">
					<div class = "input-group">
						<span class="input-group-addon">Company Email Address</span>
						<input type = "text" name = "company_email_address" class = "form-control" value = "<?= @$company_email_address; ?>"required/>
					</div>
				</div>

				<button class = "btn btn-success pull-right"><i class = "fa fa-credit-card"></i>&nbsp;Save Changes</button>
			</form>
		</div>
	</div>
</div>

<div class = "col-md-12">
	<div class = "box box-default">
		<div class = "box-header with-border">
			<h3 class = "box-title">System Settings: Billing Standing Charge</h3>
		</div>
		<div class = "box-body">
			<div class = "row">
				<div class = "col-md-8">
					<table class = "table table-bordered">
						<thead>
							<tr>
								<td>#</td>
								<td>Standing Charge Amount</td>
								<td>Status</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?= @$standing_charges; ?>
						</tbody>
					</table>
				</div>
				<div class = "col-md-4">
					<form method="POST" action = "<?php echo base_url('Settings/addStandingCharge'); ?>" id = "standing_charge_form">
						<div class = "form-group">
							<label class = "control-label">Enter Standing Charge Amount</label>
							<input type = "text" class = "form-control" name = "standing_charge_amount" required />
						</div>
						<div class = "form-group">
							<input type="checkbox" name = "set_as_current" id = "set_as_current" /> <label for = "set_as_current">Set as Active Standing Charge</label>
						</div>

						<button class = "btn btn-success" id = "add_standing_charges">Add Standing Charge</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
</script>
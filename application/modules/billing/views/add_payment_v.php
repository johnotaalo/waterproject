<form method = "POST" action = "<?php echo base_url(); ?>Billing/Payment/addPayment/<?php echo $customerData->id; ?>">
	
	<div class = 'box box-solid'>
		<div class = "box-header with-border">
			<h3 class = "box-title">Customer Details</h3>
		</div>
		<div class = "box-body">
			<div class = "col-md-6 border-right">
				<dl>
					<dt>Customer Name</dt>
					<dd><?php echo $customerData->firstname . ', ' . $customerData->othernames;?></dd>
					<dt>Meter No.</dt>
					<dd><?php echo $customerData->meter_no;?></dd>
					<dt>Town</dt>
					<dd><?php echo $customerData->town; ?></dd>
				</dl>
			</div>
			<div class = "col-md-6">
				<dl>
					<dt>Plot Number</dt>
					<dd><?php echo $customerData->plotnumber;?></dd>
					<dt>Supply Location</dt>
					<dd><?php echo $customerData->supply_location;?></dd>
					<dt>Email Address</dt>
					<dd><?php echo $customerData->emailaddress; ?></dd>
				</dl>
			</div>
		</div>
	</div>

	<div class = "form-group">
		<label>Payment For</label>
		<select name = "payment_for" id = "payment_for" class = "form-control">
			<?= @$payment_for_select; ?>
		</select>
	</div>

	<div class = "form-group">
		<label>Amount in Kshs.</label>
		<div class = "input-group">
			<span class="input-group-addon">Ksh.</span>
			<input type = 'text' class = 'form-control' name = 'amount'/>
		</div>
	</div>
</form>
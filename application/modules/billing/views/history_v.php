<div class = "col-md-12">
	<div class="box box-success">
		<div class = "box-header with-border">
			<i class="fa fa-clock-o"></i>

			<h3 class = "box-title">Customer Transaction History</h3>
		</div>
		<div class = "box-body">
			<div class="row">
				<div class = "col-md-12">
					<h4>Customer Name: <?= @$customer_data->firstname . " " . $customer_data->othernames; ?></h4>
				</div>
				<div class = "col-md-6">
					<table class = "table table-striped">
						<tr>
							<th>Meter No</th>
							<td><?= @$customer_data->meter_no; ?></td>
						</tr>
						<tr>
							<th>Phone Number</th>
							<td><?= @$customer_data->phonenumber; ?></td>
						</tr>
						<tr>
							<th>Email Address</th>
							<td><?= @$customer_data->emailaddress; ?></td>
						</tr>
					</table>
				</div>
				<div class = "col-md-6">
					<table class = "table table-striped">
						<tr>
							<th>Town</th>
							<td><?= @$customer_data->town; ?></td>
						</tr>
						<tr>
							<th>Plot Number</th>
							<td><?= @$customer_data->plotnumber; ?></td>
						</tr>
						<tr>
							<th>Supply Location</th>
							<td><?= @$customer_data->supply_location; ?></td>
						</tr>
					</table>
				</div>
			</div>

			<div class = ""></div>
		</div>
	</div>

<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#billing_information" data-toggle="tab">Customer Billing History</a></li>
		<li><a href="#payment_information" data-toggle="tab">Customer Payment Information</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="billing_information">
			<table class="table table-striped table-bordered">
				<thead>
					<th>No.</th>
					<th>Month</th>
					<th>Amount</th>
				</thead>
				<tbody>
					<?= @$bills; ?>
				</tbody>
			</table>
		</div>
		<!-- /.tab-pane -->
		<div class="tab-pane" id="payment_information">
			<table class="table table-striped table-bordered">
				<thead>
					<th>No.</th>
					<th>Payment Date</th>
					<th>Amount</th>
				</thead>
				<tbody>
					<?= @$payments; ?>
				</tbody>
			</table>
		</div>
		<!-- /.tab-pane -->
	</div>
	<!-- /.tab-content -->
</div>
</div>
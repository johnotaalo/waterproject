<div class = "col-md-12">
	<div class = "box box-success">
		<div class = "box-header with-border">
			<i class = 'fa fa-money'></i>
			<h3 class = "box-title">Payment Details</h3>
		</div>
		<div class = "box-body">
			<table class="table table-bordered table-hover datatable">
				<thead>
					<th>No. </th>
					<th style = "width: 30%;">Customer Name</th>
					<th>Phone Number</th>
					<th>Email Adderss</th>
					<th>Total Due</th>
					<th>Action</th>
				</thead>
				<tbody>
					<?php echo $customer_payments_data_table; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
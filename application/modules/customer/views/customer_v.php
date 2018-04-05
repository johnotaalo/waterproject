<div class = "col-md-12">
	<div class="box box-default">
		<div class="box-header with-border">
			<i class="fa fa-users"></i>

			<h3 class="box-title">Customers</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row m-b-10">
				<div class = "col-md-12">
					<div class = "pull-right">
						<div class="clearfix">
							<a href = "<?php echo base_url(); ?>Customer/addcustomer" class = "btn btn-success btn-flat"><i class = "ion ion-android-person-add"></i>&nbsp;Add Customer</a>
						</div>
					</div>
				</div>
			</div>
			<div class = "row">
				<div class = "col-md-12">
					<table class = "table table-bordered table-hover table-stripped datatable">
						<thead>
							<th>#</th>
							<th>E.W.S No.</th>
							<th>First Name</th>
							<th>Other Names</th>
							<th>Phone Number</th>
							<th>Email Address</th>
							<th>Status</th>
							<th>Billing</th>
							<th>Actions</th>
						</thead>
						<tbody>
							<?php echo $customers_list; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /.box-body -->
	</div>
</div>
<div class = "col-md-12">
	<div class = "box box-success">
		<div class = "box-header with-border">
			<i class = "fa fa-user-secret" id = "icon"></i>
			<h3 class = "box-title">Users List</h3>
		</div>
		<div class = "box-body">
			<div class="row">
				<div class = "col-md-12" style="margin-bottom: 15px;">
					<a href="<?php echo base_url(); ?>Account/Users/addUser" class = "btn btn-primary pull-right call-modal">Add User</a>
				</div>
			</div>
			<div class = "table-responsive">
				<table class = "table table-bordered" id = 'usertable'>
					<thead>
						<th>#</th>
						<th>Name</th>
						<th>Email Address</th>
						<th>Status</th>
						<th>Created</th>
						<th>Password</th>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
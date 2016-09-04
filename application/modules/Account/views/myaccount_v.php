<div class = "col-md-3">
	<div class = "box box-primary">
		<div class = "box-body box-profile">
			<img class="profile-user-img img-responsive img-circle" src = "<?= @base_url(); ?>assets/images/waterfaucet.jpg" style = 'width: 128px;height:128px;'>
			<h3 class = "profile-username text-center"><?= @$name; ?></h3>
			<p class = "text-muted text-center"><?= @$emailaddress; ?></p>

			<ul class="list-group list-group-unbordered">
				<li class="list-group-item">
					<b>Member Since</b> <a class="pull-right"><?= @$created; ?></a>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class = "col-md-6">
	<div class = "box box-primary">
		<div class = "box-header">
			<h2 class = "box-title">Password</h2>
			<small>This is the only item you are allowed to change</small>
		</div>
		<div class = "box-body">
			<form class = "form-horizontal" method="POST" data-action = "<?php echo base_url('Account/changepassword'); ?>" id = "changePasswordForm">
				<div class = "form-group">
					<label class = "col-sm-3 control-label">Current Password</label>
					<div class = "col-sm-9">
						<input type="password" name="current_password" class = "form-control">
					</div>
				</div>
				<div class = "form-group">
					<label class = "col-sm-3 control-label">New Password</label>
					<div class = "col-sm-9">
						<input type="password" name="new_password" class = "form-control">
					</div>
				</div>
				<div class = "form-group">
					<label class = "col-sm-3 control-label">Confirm Password</label>
					<div class = "col-sm-9">
						<input type="password" name="confirm_password" class = "form-control">
					</div>
				</div>

				<div class = "form-group">
					<label class = "col-sm-3 control-label"></label>
					<div class = "col-sm-9">
						<button class = "btn btn-success" id = "change_password">Change Password</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class = "col-md-8">
	<div class="box box-solid">
		<div class="box-header with-border">
			<h3 class="box-title">Starting Things up</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<?php if($this->session->flashdata('error')) { ?>
				<?php echo $this->session->flashdata('error'); ?>
			<?php } ?>
			<form method="POST" action="<?php echo base_url(); ?>Billing/StartUp/startbilling">
				<div class="form-group">
					<div class = "input-group">
						<span class = "input-group-addon">Choose the Year</span>
						<input type="text" name="year" class="year-picker form-control" required>
					</div>
				</div>

				<div class="form-group">
					<div class = "input-group">
						<span class = "input-group-addon">Choose the Month</span>
						<select name = "month" class = "form-control" required>
							<?= @$months; ?>
						</select>
					</div>
				</div>

				<button class="btn btn-success">Start Billing</button>
			</form>
		</div>
		<!-- /.box-body -->
	</div>
</div>

<div class="col-md-4">
	<div class = "box box-solid">
		<div class = "box-body">
			<h3>Explanation</h3>
			<p>This page lets you create your first billing month.</p>
			<p>Please keep in mind that once you create your first billing month, the billing starts from this month. You cannot change this in the future</p>
		</div>
	</div>
</div>
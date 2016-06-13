<form method="POST" action="<?php echo base_url(); ?>Billing/addBillingMonth">
	<div class = "form-group">
		<div class = "input-group">
			<span class = "input-group-addon">Year</span>
			<input type = 'text' class = "form-control year-picker" name = "year"/>
		</div>
	</div>
		<div class = "form-group">
			<div class = "input-group">
				<span class = "input-group-addon">Month</span>
				<select name = "month" class = "form-control">
					<?= @$months; ?>
				</select>
			</div>
		</div>

	</div>
</form>
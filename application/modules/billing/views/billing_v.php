<div class = "col-md-12">
	<div class="box box-solid">
		<div class="box-header with-border">
			<i class="fa fa-credit-card"></i>

			<h3 class="box-title">Billing Information for: <?php echo $year ." " . $month_words; ?></h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<?php if(!isset($billing_id)) { ?>
				<div class="alert alert-warning">
					<h4><i class="icon fa fa-warning"></i> New Month! New Bill?</h4>
					Hello Admin,<br/>
					I have noticed this month does not have any billing information as per our usual schedule.<br/>
					If you want to add this month's billing information, please click on the button below<br/>
					<a href = "<?php echo base_url(); ?>Billing/newBilling/<?php echo $year; ?>/<?php echo $month; ?>" class = "btn btn-success btn-flat">Start adding billing information for <?php echo $year; ?>, <?php echo $month_words; ?></a>
				</div>
			<?php } ?>

			<div class = 'row'>
				<form class = "col-md-12" method="POST" action="<?php echo base_url(); ?>Billing/searchBillingInformation">
					<legend>Filter Data</legend>
					<div class = "col-md-4">
						<div class = "form-group">
							<label>Year</label>
							<input class = "form-control year-picker" name = 'year' value = '<?php echo $year; ?>' />
						</div>
					</div>
					<div class = "col-md-4">
						<div class = "form-group">
							<label>Month</label>
							<select name = "month" class = "form-control">
								<?php echo $month_list; ?>
							</select>
						</div>
					</div>
					<div class = "col-md-4">
						<div class = "form-group">
							<label></label>
							<button class = "btn btn-primary form-control"><i class = 'fa fa-search'></i>&nbsp;Search Data</button>
						</div>
					</div>
				</form>
			</div>
			<?php if(isset($billing_id)) { ?>
			<div class = "row">
				<div class = "col-md-12">
					<legend>Month Details</legend>
				</div>
				<div class = "col-md-12">
					<label>Estimated total earnings for this month: </label> Ksh. 15,000
				</div>

				<div class = "col-md-12">
					<div class = "table-responsive">
						<table class = "table table-hover table-bordered table-stripped">
							<thead>
								<th>No.</th>
								<th>Name</th>
								<th>Amount in m3</th>
								<th>Total Due</th>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	<!-- /.box-body -->
	</div>
</div>

<script>
	var year = '<?php echo $year; ?>';
</script>
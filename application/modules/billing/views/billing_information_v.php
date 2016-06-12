<div class = "col-md-12">
	<div class = "box box-solid box-flat">
		<div class = "box-header">
			<i class = "fa fa-credit-card"></i>
			<h3 class = "box-title">Billing Information</h3>
		</div>
		<div class = "box-body">
			<p>Viewing information for: <b><?php echo $month_details->year .', ' . $month_name; ?></b></p>

			<table class="table table-bordered table-hover datatable">
				<thead>
					<th>No.</th>
					<th>Customer Name</th>
					<th>Plot Number</th>
					<th>Volume Used(M<sup>3</sup>)</th>
					<th>Action</th>
				</thead>
				<tbody>
					<?php echo $billing_information; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	var billing_id = '<?php echo $billing_id;?>';
</script>
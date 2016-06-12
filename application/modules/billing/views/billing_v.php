<div class = "row">
	<div class = "col-md-12">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<a href = "#">
				<div class="info-box bg-aqua">
					<span class="info-box-icon"><i class="fa ion-android-calendar"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">This Month</span>
						<span class="info-box-number"><?php echo $year ." " . $month_words; ?></span>

						<div class="progress">
						<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							<?php if(isset($billing_id)) { ?>
								Ksh. <?php echo $total_monthly_balance; ?>
							<?php } else { ?>
								Start Billing
							<?php } ?>
						</span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</a>
			<!-- /.info-box -->
		</div>

		<div class="col-md-3 col-sm-6 col-xs-12">
			<a href = "#">
				<div class="info-box bg-yellow">
					<span class="info-box-icon"><i class="fa ion-android-list"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">View another Month</span>
						<span class="info-box-number">Carried Forward</span>

						<div class="progress">
							<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">Ksh. <?php echo $total_carried_forward; ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</a>
			<!-- /.info-box -->
		</div>

		<div class="col-md-3 col-sm-6 col-xs-12">
			<a href = "#">
				<div class="info-box bg-red">
					<span class="info-box-icon"><i class="fa fa-file-pdf-o"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Export To</span>
						<span class="info-box-number">PDF</span>
						<span class="progress-description"></span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</a>
			<!-- /.info-box -->
		</div>

		<div class="col-md-3 col-sm-6 col-xs-12">
			<a href="#">
				<div class="info-box bg-green">
					<span class="info-box-icon"><i class="fa fa-file-excel-o"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Export To</span>
						<span class="info-box-number">Excel</span>
						<span class="progress-description"></span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</a>
			<!-- /.info-box -->
		</div>
	</div>
</div>
<div class = "col-md-12">
	<div class = "box box-solid box-flat">
		<div class="box-header with-border">
			<i class="fa fa-credit-card"></i>
			<h3 class="box-title">Billing Information</h3>
			<!-- <a href = "#" class = "btn btn-default pull-right" id = "email_invoice">Email Invoices to Customers</a>
			<a href = "#" class = "btn btn-default pull-right" id = "save-data">Save Data</a> -->
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool bg-green" id = 'save-data'><i class="fa fa-save"></i> &nbsp;Save Changes</button>
                <button type="button" class="btn btn-box-tool bg-yellow" data-toggle="tooltip" title="Email Invoices to Customers"><i class="fa fa-envelope-o"></i>&nbsp;Email Invoices</button>
              </div>

		</div>
		<div class = "box-body">
			<form method = "POST" action="<?php echo base_url(); ?>Billing/addCustomerBillingInformation/<?php echo $year . '/' . $month; ?>" id = "customerbilling">
				<table class = "table table-bordered table-hover table-striped datatable">
					<thead>
						<th>No.</th>
						<th>Name</th>
						<th>Carried Forward</th>
						<th>Water Used (m<sup>3</sup>)</th>
						<th>Total Due</th>
					</thead>
					<tbody>
						<?php echo $billing_data; ?>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.amount_used').keyup(function(){
		amount_used = $(this).val();
		carried_forward = $(this).parent().closest('td').prev('td').find('span').text();
		total_due_span = $(this).parent().closest('td').next('td').find('span');

		if ($.isNumeric(amount_used)) {
			amount_used = amount_used;
		}
		else
		{
			amount_used = 0;
		}

		if ($.isNumeric(carried_forward))
		{
			carried_forward = parseInt(carried_forward);
		}
		else
		{
			carried_forward = 0;
		}

		total_to_be_paid = amount_used * 100 + 50;

		total_due = carried_forward + total_to_be_paid;

		$(this).parent().find('.amount_to_be_paid').text(total_to_be_paid);

		total_due_span.text(total_due);

	});

	$('#save-data').click(function(e){
		e.preventDefault();
		$('form#customerbilling').submit();
	});
</script>
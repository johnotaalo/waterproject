<div class = "col-md-12">
	<div class = "box box-success">
		<div class = "box-header with-border">
			<h3 class = "box-title">Billing Information for <?php echo $customer->firstname; ?> <?php echo $customer->othernames; ?></h3>
		</div>
		<div class="box-body">
			<div class = "row">
				<div class="col-md-8">
					<table class="table table-bordered table-striped">
						<thead>
							<th>#</th>
							<th>Month</th>
							<th>Amount</th>
							<th>Status</th>
							<th>Clearance</th>
						</thead>
						<tbody>
							<?= @$billing_table; ?>
						</tbody>
					</table>
				</div>
				<div class="col-md-4">
					<div class="info-box bg-red">
						<span class="info-box-icon"><i class="fa fa-credit-card"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Total Due</span>
							<span class="info-box-number">Ksh. <?php echo number_format($total_due->amount); ?></span>

							<div class="progress">
							<div class="progress-bar" style="width: 100%"></div>
							</div>
							<span class="progress-description">
							Lifetime
							</span>
						</div>
						<!-- /.info-box-content -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
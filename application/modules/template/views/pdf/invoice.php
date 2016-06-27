<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="<?php echo $this->config->item('assets_url'); ?>custom/invoice.css" media="all" />
	</head>
	<body>
		<header class="clearfix">
			<div class="logo">
				<img style = "height: 70px;" src="<?php echo $this->config->item('assets_url'); ?>images/waterfaucet.jpg">
			</div>
			<div class="company">
				<h2 class="name">ENKONG'U ENKARE WATER</h2>
				<div>P.O Box 179-00206, KISERIAN</div>
				<div>0733-952586</div>
				<div><a href="mailto:manager@enkonguwater.com">manager@enkonguwater.com</a></div>
			</div>
		</header>
		<main>
			<div class="details" class="clearfix">
				<div class="client">
					<div class="to">INVOICE TO:</div>
					<h2 class="name"><?php echo $customer->firstname . " " . $customer->othernames; ?></h2>
					<div class="address"><?php echo $customer->town; ?></div>
					<div class="email"><a href="mailto:<?php echo $customer->emailaddress; ?>"><?php echo $customer->emailaddress; ?></a></div>
					<div class = "address">Meter No. <?php echo $customer->meter_no; ?></div>
				</div>
				<div class="invoice">
					<h1>INVOICE <?php echo str_pad($billing_details->id, 4, '0', STR_PAD_LEFT);; ?></h1>
					<div class="date">Date of Invoice: <?php echo date('d/m/Y', strtotime($current->meter_reading_date)); ?></div>
					<div class="date">Due Date: <?php echo date('d/m/Y', strtotime($current->meter_reading_date . ' + 4 days')); ?></div>
				</div>
			</div>

			<div class = "clearfix" style="margin-top: 15px;">
				<table border="0" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<th class = "unit">Previous Meter Reading Date</th>
							<th class = "">Previous Meter Reading</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class = "unit" style="text-align: center; "><?php echo date('d/m/Y', strtotime($previous->meter_reading_date)); ?></td>
							<td class = "qty" style="text-align: center;"><?php echo $previous->meter_reading; ?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<table border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th class="no">#</th>
						<th class="desc">DESCRIPTION</th>
						<th class="unit">UNIT PRICE</th>
						<th class="qty">QUANTITY</th>
						<th class="total">TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="no">01</td>
						<td class="desc"><h3>Billing for: <?php echo $billing_month->year;?> <?php echo $billing_month->month; ?></h3>This is the billing month that is needed</td>
						<td class="unit">Ksh. 100.00</td>
						<td class="qty"><?php echo $current->water_used; ?> M<sup>3</sup></td>
						<td class="total">Ksh. <?php echo number_format($current->water_used * 100, 2); ?></td>
					</tr>
					<tr>
						<td class="no">02</td>
						<td class="desc"><h3>Standing Charge</h3>This amount has to be paid monthly regardless</td>
						<td class="unit">Ksh. 50.00</td>
						<td class="qty">1 month</td>
						<td class="total">Ksh. 50.00</td>
					</tr>
					<tr>
					<td class="no">03</td>
						<td class="desc"><h3>Balance Carried Forward</h3>Balance brought down from last month</td>
						<td class="unit">Ksh. <?php echo number_format($carried_forward, 2); ?></td>
						<td class="qty"></td>
						<td class="total">Ksh. <?php echo number_format($carried_forward, 2); ?></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"></td>
						<td colspan="2">TOTAL</td>
						<td>KSH. <?php echo number_format($total_to_be_paid, 2); ?></td>
					</tr>
				</tfoot>
			</table>
			<div id="thanks">Thank you!</div>
			<footer>
				Invoice was created on a computer and is valid without the signature and seal.
			</footer>
			<pagebreak />
			<div id="notices">
			<div>NOTICE:</div>
			<div class="notice">
				1. The applicants required to provide their own 127mm(1/2 inch)High density PVC piping from the main line to the premises
				<br/>2. The applicant agrees to provide their own water meter secured in a LOCKABLE metal box and cemented to the ground
				<br/>3. The recommended meter is the sensus metering system model 405s available from Davis and shirtliff ,Dundori road Nairobi
				<br/>4. All due bills must be paid by the 5th day of the following month
				<br/>5. water supply will be disconnected on the 6th day of the month
				<br/>6. The applicant agrees to pay a reconnection fee of shs 500.00
				<br/>7. The applicant agrees to report and repair all water leaks within their property
				<br/>8. The applicant agrees not to install any water sucking devices or pumps which will deprive their neighbors and other consumers water
				<br/>9. The applicant agrees NOT TO RESELL WATER OR DO IRRIGATION. Penalty will be immediate disconnection and any reconnection will be on a deposit of shs5000.00
				<br/>10. Water mete standing charges :50.00/month
			</div>
			</div>
		</main>
		<footer>
		Invoice was created on a computer and is valid without the signature and seal.
		</footer>
	</body>
</html>
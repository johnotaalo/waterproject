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
			<div id="notices">
			<div>NOTICE:</div>
			<div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
			</div>
		</main>
		<footer>
		Invoice was created on a computer and is valid without the signature and seal.
		</footer>
	</body>
</html>
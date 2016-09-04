<html>
	<head>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans|Lato' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Pacifico|Permanent+Marker' rel='stylesheet' type='text/css'>
	</head>
	<body style="font-family: 'Open Sans', sans-serif;text-align: center;font-size:20px;">
		<p>Hi, <?= @$name; ?></p>

		<p>Welcome to Enkongu water!</p>
		<p>We are glad to inform you that your account is ready. You can now be able to access the Enkongu Water System. Use the credentials below to log in.</p>

		<p><b>Username: </b><?= @$email; ?></p>
		<p><b>Password: </b><?= @$new_password; ?></p>

		<p>Oh! And before we forget. Make sure you master the password or change it and delete this email. There are spies out there!</p>

		<div style="text-align: right;font-family: 'Pacifico', cursive;">
			<p>Accounts Team
			<br/>Enkongu Water</p>
		</div>
	</body>
</html>
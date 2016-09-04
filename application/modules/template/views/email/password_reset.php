<html>
	<head>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans|Lato' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Pacifico|Permanent+Marker' rel='stylesheet' type='text/css'>
	</head>
	<body style="font-family: 'Open Sans', sans-serif;text-align: center;font-size:25px;">
		<p>Hi, <?= @$name; ?></p>

		<p>Your password has been reset!</p>

		<h2>Your New Password!</h2>
		<div style="padding: 10px;background-color:#0D47A1;width:50%;height:80px;margin: 0 auto;color:white;">
			<h1 style="line-height: 20px;"><?= @$new_password; ?></h1>
		</div>

		<p style="">Go ahead and test out the new password while logging in!</p>

		<div style="text-align: right;font-family: 'Pacifico', cursive;">
			<p>Accounts Team</p>
			<p>Enkongu Water</p>
		</div>
	</body>
</html>
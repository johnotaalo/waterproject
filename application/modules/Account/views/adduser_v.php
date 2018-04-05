<form method = "POST" action = "<?php echo base_url('Account/Users/addUser'); ?>" id = "adduser_form">
	<div class = "form-group">
		<label>Please enter the name</label>
		<input type="text" name="username" class = "form-control">
	</div>
	<div class = "form-group">
		<label>Please enter the email address</label>
		<input type="email" name="emailaddress" class = "form-control">
	</div>
	<ul class = "error"></ul>
</form>
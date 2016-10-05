$(document).ready(function(){
	$('.datatable').DataTable();
	$('#usertable').DataTable({
		fixedHeader: true,
		processing: true,
		serverSide: true,
		"ajax": base_url + 'Account/Users/getuserslist',
		"fnDrawCallback" : function(){
			$('.password-reset').click(function(e){
				email = $(this).attr('data-email');
				e.preventDefault();
				swal({
					title: "Reset Password",
					text: "You will reset the password of the user with email address: " + email,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#4CAF50",
					confirmButtonText: "Yes, Reset!",
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				}, function(){
					$.ajax({
						method 	: "post",
						url 	: base_url + "Account/Users/reset_password",
						data 	: {	email: email},
						success : function(jqXHR, textStatus, errorThrown){
							swal("Password Reset!", "Successfully Reset Password", "success");
						},
						error 	: function(jqXHR, textStatus, errorThrown)
						{
							error_message = jqXHR.responseJSON.message;

							swal("Error!", error_message, "error");
						}
					});
				});
			});
		}
	});
	$('.activation').click(function(e){
		e.preventDefault();

		var myself = $(this);
		var text;
		if ($(this).attr('data-action') == "activate")
		{
			text = "You are about to activate this customer";
		}
		else
		{
			text = "You are about to deactivate this customer";
		}

		swal({
			title: "Are you sure?",
			text: text,
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, Proceed!",
			closeOnConfirm: false 
		}, function(){
			window.location = myself.attr('href');
		});
	});

	if ($('.year-picker')[0]) {
		$('.year-picker').datepicker({
			format: "yyyy", 
			viewMode: "years", 
			minViewMode: "years"
		});
	}

	$('.datepicker').datepicker();

	$('.modal button#save_changes').click(function(){
		if($('#add_customer_billing')[0])
		{
			volume_used = $('#volume_used').val();
			if(volume_used == "")
			{
				$('#volume_used').parent().addClass('has-error');
			}
			else
			{
				$('.modal form').submit();
			}
		}
		else if($('#adduser_form')[0])
		{
			var form = $('#adduser_form');
			username = form.find('input[name = "username"]').val();
			email = form.find('input[name = "emailaddress"]').val();

			var errors = [];
			if(username == "" || email == "")
			{
				errors.push("Please ensure all fields are filled in before submitting");

				if(email)
				{
					var isemail = isEmail(email);

					if(!isemail)
					{
						errors.push("The email you entered doesn't feel right");
					}
				}
			}
			else
			{
				var isemail = isEmail(email);

				if(!isemail)
				{
					errors.push("The email you entered doesn't feel right");
				}
			}

			$('ul.error').empty();

			if(errors.length > 0)
			{
				for (var i = errors.length - 1; i >= 0; i--) {
					$('ul.error').append('<li>'+errors[i]+'</li>');
				}
			}
			else
			{
				// check whether email already exists
				url = base_url + "Account/Users/search_email/";

				data = {"email" : email};
				$.ajax({
					method : "post",
					url : url,
					data: data,
					success : function(res)
					{
						form.submit();
					},
					error : function(jqXHR, textStatus, errorThrown)
					{
						$('ul.error').html('<li>'+jqXHR.responseJSON.message+'</li>');
					}
				});
			}
		}
		else
		{
			$('.modal form').submit();
		}
	});

	if ($('.btn-information')[0])

	{

		$('.btn-information').click(function(){

			customer_id = $(this).attr('data-id');

			$('.modal .modal-body').load(base_url + 'Billing/customerData/json/' + billing_id + '/' + customer_id, function(data){

				$('.modal .modal-body').html("");

				obj = jQuery.parseJSON(data);

				$('.modal .modal-body').html(obj.page);

				$('.modal .modal-title').html(obj.title);

				$('.datepicker').datepicker({

					endDate: '+0d',

					autoclose: true,

					format: 'dd-mm-yyyy',

				});

				$('#current_reading').keyup(function(){

					current = $('#current_reading').val();



					current = parseInt(current);

					

					previous = parseInt($('#previous_reading').val());



					volume_used = current - previous;



					if(volume_used < 0)

					{

						$('#volume_used').parent().addClass('has-error');

					}

					else

					{

						if(!isNaN(volume_used))

						{

							$('#volume_used').parent().removeClass('has-error');

							$('#volume_used').val(volume_used);

						}

						else

						{

							$('#volume_used').val("");

						}

					}



				});

			});

			$('.modal').modal();

		});

	}

	if($('.call-modal')[0])
	{
		$('.call-modal').click(function(event){
			event.preventDefault();
			url = $(this).attr('href');
			$('.modal .modal-body').load(url, function(data){
				obj = jQuery.parseJSON(data);
				$('.modal .modal-body').html(obj.page);
				$('.modal .modal-title').html(obj.title);
			});
			$('.modal').modal();
		});
	}



	if ($('#addnewmonth')[0])
	{
		$('#addnewmonth').click(function(e){
			e.preventDefault();
			$('.modal .modal-body').load(base_url  + "Billing/addBillingMonth", function(data){
				obj = jQuery.parseJSON(data);
				$('.modal .modal-body').html(obj.page);
				$('.modal .modal-title').html(obj.title);
				$('.year-picker').datepicker({
					format: "yyyy", 
					viewMode: "years", 
					minViewMode: "years",
					autoclose: true
				});
				$('.modal').modal();
			});
		});
	}

	if ($('.clearance'))
	{
		$('.clearance').click(function(e){
			e.preventDefault();
			id = $(this).attr('data-id');
		});
	}
	if($('#change_password')[0])
	{
		console.log("Found");
		$('#change_password').click(function(e){
			e.preventDefault();
			var form = $('#changePasswordForm');

			current_password = form.find('input[name="current_password"]').val();
			new_password = form.find('input[name="new_password"]').val();
			confirm_password = form.find('input[name="confirm_password"]').val();

			if(current_password !== "" && new_password !== "" && confirm_password !== "")
			{
				var post_data = {
					"current_password"	: current_password,
					"new_password"		: new_password,
					"confirm_password"	: confirm_password
				};

				swal({
					title: "Change Password?",
					text: "You will change your password. This cannot be undone, unless you change it",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#4CAF50",
					confirmButtonText: "Yes, Change It!",
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				}, function(){
					$.ajax({
						method : "post",
						url : form.attr('data-action'),
						data: post_data,
						success : function(res){
							swal({
								title: "Password Changed",
								text : res.message,
								type: "success",
								closeOnConfirm: true
							}, function(){
								window.location = base_url + 'Account/signin';
							});
							// swal("Password Changed", res.message, "success");

							
						},
						error : function(jqXHR, textStatus, errorThrown){
							error_message = jqXHR.responseJSON.message;

							swal("Error", error_message, "error");
						}
					});
				});
				
			}
		});
	}

	if($('#add_standing_charges')[0])
	{
		$('#add_standing_charges').click(function(event){
			event.preventDefault();

			var amount = $('input[name="standing_charge_amount"]').val();
			if (amount === "")
			{
				swal({
					title: "Error!", 
					text: "You must enter a value", 
					type: "error"
				}, function(){
					$('input[name="standing_charge_amount"]').focus();
				});
			}
			else
			{
				$.get(base_url + "Settings/search_amount/" + amount, function(res){
					resObj = $.parseJSON(res);
					if (resObj.exists == true)
					{
						swal("Error!", "This amount already exists. Check the table on the left to activate it", "error")
					}
					else
					{
						checked = $('input[name="set_as_current"]:checked').length;

						if (checked){
							swal({
								title: "Are you sure?",
								text: "Setting This As the current will mean that the others will be set as inactive and any other billing from now hence forth will use Ksh. " + amount + " as the standing charge. Do you want to proceed?",
								type: "warning",
								showCancelButton: true,
								confirmButtonColor: "#DD6B55",
								confirmButtonText: "Yes, Proceed!",
								closeOnConfirm: false 
							}, function(){
								$("#standing_charge_form").submit();
							});
						}
						else{
							$("#standing_charge_form").submit();
						}
					}
				});
			}
		});
	}

	if($('.charge-activation')[0])
	{
		$('.charge-activation').click(function(event){
			event.preventDefault();

			var action = $(this).attr('data-action');
			var id = $(this).attr('data-id');

			if (action == "deactivate")
			{
				swal("Information", "You cannot have all set as inactive", "info");
			}
			else{

				swal({
						title: "Cross Checking",
						text: "Are you sure you want to activate this standing charge?",
						type: "info",
						showCancelButton: true,
						closeOnConfirm: false,
						showLoaderOnConfirm: true,
					},
				function(){
					var postData = {
						action 	: action,
						id 		: id
					};


					$.post(base_url + "Settings/ChargeActivation", postData, function(res){
						resObj = $.parseJSON(res);

						if (resObj.type == true)
						{
							swal({
								title: "Success",
								text: "Succesfully activated the standing charge", 
								type: "success"
							}, function(){
								window.location = base_url + "Settings";
							});
						}else{
							swal("Error!", "There was an error trying to activate the standing charge. Contact your administrator", "error");
						}
					});
				});
			}
		});
	}

	if($('.delete-charge')[0])
	{
		$('.delete-charge').click(function(event){
			event.preventDefault();

			var id = $(this).attr('data-id');

			$.get(base_url + 'Settings/searchUsedCharge/' + id, function(res){
				resObj = $.parseJSON(res);

				if (resObj.type == true)
				{
					swal("Error", "Cannot delete this standing charge because some billing information is already tied to it. Please contact your system administrator", "error");
				}
				else
				{
					swal({
						title: "Confirmation",
						text: "Are you sure you want to delete this standing charge?",
						type: "info",
						showCancelButton: true,
						closeOnConfirm: false,
						showLoaderOnConfirm: true,
					}, function(){
						// proceed and delete
						var postData = {id : id};
						$.post(base_url + 'Settings/deleteCharge/', postData, function(result){
							console.log(result);
							resultObj = $.parseJSON(result);

							if (resultObj.type == true)
							{
								swal({
									title: "Success",
									text: "Succesfully deleted the standing charge", 
									type: "success"
								}, function(){
									window.location = base_url + "Settings";
								});
							}
							else
							{
								swal("Error!", "There was an error deleting standing charge. Please contact administrator", "error");
							}
						});
					});
					
				}
			});
		});
	}
});

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}
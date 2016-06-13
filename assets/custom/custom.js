$(document).ready(function(){
	$('.datatable').DataTable({
		fixedHeader: true
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

	$('.modal button').click(function(){
		$('.modal form').submit();
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
			});
			$('.modal').modal();
		});
	}
});
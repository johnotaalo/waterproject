$(document).ready(function(){
	$('.datatable').DataTable();

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
});
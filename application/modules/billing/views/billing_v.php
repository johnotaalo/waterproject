<div class = "col-md-12">
	<?php if($this->session->flashdata('type') == "error"){ ?>
		<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Error!</h4>
			<?php echo $this->session->flashdata("message"); ?>
		</div>
	<?php } ?>
	<div class = "box box-solid box-flat">
		<div class="box-header with-border">
			<i class = 'fa fa-calendar-o'></i>
			<h3 class = "box-title">&nbsp;Billing Months</h3>
		</div>
		<div class = "box-body">

			<div class = "pull-right">
				<button class = "btn btn-success btn-sm m-b-10" id = "addnewmonth"><i class = "fa fa-calendar-plus-o"></i>&nbsp;Add New Month Billing</button>
			</div>

			<div class = "clearfix"></div>
			<div class = "table-responsive">
				<table class = 'table table-bordered table-hover datatable'>
					<thead>
						<th>#</th>
						<th style = "width: 40%;">Months</th>
						<th class = 'text-center'>Volume Recorded(M<sup>3</sup>)</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php echo $months_list; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
</script>
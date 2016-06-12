<div class = "col-md-12">
	<div class="box box-default">
		<div class="box-header with-border">
			<i class="ion ion-android-person-add"></i>

			<h3 class="box-title"><?php if(!isset($customer_details)){ ?>Add a Customer <?php } else { ?>Edit Customer<?php } ?>
				<?php if(!isset($customer_details)) { ?><small>Add a customer to the system</small> <?php } ?>
			</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<?php
				if (isset($customer_details) && $this->session->flashdata())
				{
					if ($this->session->flashdata('type') == "success") {
			?>
					<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-check"></i> Success!</h4>
						<?php echo $this->session->flashdata('message'); ?>
					</div>
			<?php
				} else if ($this->session->flashdata('type') == "error") {
			?>
					<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-ban"></i> Error!</h4>
						<?php echo $this->session->flashdata('message'); ?>
					</div>	
			<?php } ?>
			<?php
				}
			?>
			<form method="POST" action="<?php echo base_url(); ?>Customer/<?php if(!isset($customer_details)){?>addcustomer<?php }else{ ?>editCustomer/<?php echo $customer_details->id;} ?>">
				<div class = "form-group">
					<div class="input-group">
						<span class="input-group-addon">First Name</span>
						<input name = "firstname" type="text" class="form-control" placeholder="Customer First Name" 
						value = "<?php if(isset($customer_details)){ echo $customer_details->firstname; }?>" required />
					</div>
				</div>

				<div class = "form-group">
					<div class="input-group">
						<span class="input-group-addon">Other Names</span>
						<input name = "othernames" type="text" class="form-control" placeholder="Customer's Other Names" value = "<?php if(isset($customer_details)){ echo $customer_details->othernames; }?>" required />
					</div>
				</div>

				<div class = "form-group">
					<div class="input-group">
						<span class="input-group-addon">Phone Number</span>
						<input name = "phonenumber" type="text" class="form-control" placeholder="Customer's Phone Number"  value = "<?php if(isset($customer_details)){ echo $customer_details->phonenumber; }?>" required />
					</div>
				</div>

				<div class = "form-group">
					<div class="input-group">
						<span class="input-group-addon">Email Address</span>
						<input name = "emailaddress" type="text" class="form-control" placeholder="Customer's Email Address" value = "<?php if(isset($customer_details)){ echo $customer_details->emailaddress; }?>" required />
					</div>
				</div>

				<div class = "form-group">
					<div class="input-group">
						<span class="input-group-addon">Town</span>
						<input name = "town" type="text" class="form-control" placeholder="Customer's Town" value = "<?php if(isset($customer_details)){ echo $customer_details->town; }?>" required />
					</div>
				</div>

				<div class = "form-group">
					<div class="input-group">
						<span class="input-group-addon">Plot Number</span>
						<input name = "plotnumber" type="text" class="form-control" placeholder="Customer's Plot Number" value = "<?php if(isset($customer_details)){ echo $customer_details->plotnumber; }?>"  required />
					</div>
				</div>

				<div class = "form-group">
					<div class="input-group">
						<span class="input-group-addon">Supply Location</span>
						<input name = "supply_location" type="text" class="form-control" placeholder="Customer's Supply Location" value = "<?php if(isset($customer_details)){ echo $customer_details->supply_location; }?>" required />
					</div>
				</div>

				<div class = "form-group">
					<div class="input-group">
						<span class="input-group-addon">Meter Number</span>
						<input name = "meter_no" type="text" class="form-control" placeholder="Customer's Meter No" value = "<?php if(isset($customer_details)){ echo $customer_details->meter_no; }?>"  required />
					</div>
				</div>

				<div class = "form-group">
					<button class = "btn btn-success btn-flat"><?php if(!isset($customer_details)) { ?>Complete Registration<?php } else { ?>Edit Customer Details<?php } ?></button>
				</div>

			</form>
		</div>
		<!-- /.box-body -->
	</div>
</div>
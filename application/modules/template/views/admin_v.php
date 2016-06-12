<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $title; ?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="<?php echo $this->config->item('assets_url'); ?>bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_url'); ?>dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?php echo $this->config->item('assets_url'); ?>dist/css/skins/_all-skins.min.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_url'); ?>plugins/datatables/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_url'); ?>plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_url'); ?>plugins/sweetalert/dist/sweetalert.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_url'); ?>plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_url'); ?>custom/custom.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

		<!-- Main Header -->
		<header class="main-header">

			<!-- Logo -->
			<a href="<?php echo base_url(); ?>" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>E</b>EW</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>ENKONG'U</b> ENKARE</span>
			</a>

			<!-- Header Navbar -->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<!-- Navbar Right Menu -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<!-- Menu Toggle Button -->
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<!-- The user image in the navbar-->
								<img src="<?php echo $this->config->item('assets_url'); ?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
								<!-- hidden-xs hides the username on small devices so only the image appears. -->
								<span class="hidden-xs">Test User</span>
							</a>
							<ul class="dropdown-menu">
								<!-- The user image in the menu -->
								<li class="user-header">
									<img src="<?php echo $this->config->item('assets_url'); ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

									<p>
									Test User - Administrator
									<small>Member since Jun. 2016</small>
									</p>
								</li>
								<!-- Menu Body -->
								<li class="user-body">
									<div class="row">
										<div class="col-xs-4 text-center">
											<a href="#">Customers</a>
										</div>
										<div class="col-xs-4 text-center">
											<a href="#">Billing</a>
										</div>
										<div class="col-xs-4 text-center">
											<a href="#">This month</a>
										</div>
									</div>
									<!-- /.row -->
								</li>
								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<a href="#" class="btn btn-default btn-flat">Profile</a>
									</div>
									<div class="pull-right">
										<a href="#" class="btn btn-default btn-flat">Sign out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">

			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">

				<!-- Sidebar user panel (optional) -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="<?php echo $this->config->item('assets_url'); ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p>Test User</p>
						<!-- Status -->
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				</div>

				<!-- search form (Optional) -->
				<form action="#" method="get" class="sidebar-form">
					<div class="input-group">
						<input type="text" name="q" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
							</button>
						</span>
					</div>
				</form>
				<!-- /.search form -->

				<!-- Sidebar Menu -->
				<ul class="sidebar-menu">
					<li class="header">NAVIGATION MENU</li>
					<!-- Optionally, you can add icons to the links -->
					<li class="active"><a href="#"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
					<li><a href="#"><i class="fa fa-users"></i> <span>Customers</span></a></li>
					<li><a href="#"><i class="fa fa-credit-card"></i> <span>Billing</span></a></li>
					<li><a href="#"><i class="fa fa-user-secret"></i> <span>Account</span></a></li>
					<li><a href="#"><i class="fa ion-log-out"></i> <span>Sign Out</span></a></li>
				</ul>
				<!-- /.sidebar-menu -->
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<?php if (isset($page_header)) { ?>
					<h1>
					<?php echo  $page_header; ?>
					<small><?php echo (isset($page_description)) ? $page_description : ""; ?></small>
					</h1>
				<?php } ?>
				<ol class="breadcrumb">
					<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
					<li class="active">Here</li> -->
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				<div class = "row">
					<?php if(isset($content_view)) { ?>
						<?php $this->load->view($content_view); ?>
					<?php } else { ?>
						<?php $this->load->view('template/partials/no-page'); ?>
					<?php } ?>
				</div>
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

			<!-- Main Footer -->
		<footer class="main-footer">
			<!-- To the right -->
			<div class="pull-right hidden-xs">
				<b>Powered by <a href = "http://www.symatechlabs.com" target="_blank">Symatech Labs</a></b>
			</div>
			<!-- Default to the left -->
			<strong>Copyright &copy; <?php echo date("Y");?> <a href="#">Enkoru Enkare Water</a>.</strong> All rights reserved.
		</footer>
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- jQuery 2.2.0 -->
	<script src="<?php echo $this->config->item('assets_url'); ?>plugins/jQuery/jQuery-2.2.0.min.js"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="<?php echo $this->config->item('assets_url'); ?>bootstrap/js/bootstrap.min.js"></script>
	<!-- SlimScroll -->
	<script src="<?php echo $this->config->item('assets_url'); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="<?php echo $this->config->item('assets_url'); ?>plugins/fastclick/fastclick.js"></script>

	<script src="<?php echo $this->config->item('assets_url'); ?>plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url'); ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url'); ?>plugins/sweetalert/dist/sweetalert.min.js"></script>
	<script src="<?php echo $this->config->item('assets_url'); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo $this->config->item('assets_url'); ?>dist/js/app.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo $this->config->item('assets_url'); ?>dist/js/demo.js"></script>

	<script src="<?php echo $this->config->item('assets_url'); ?>custom/custom.js"></script>
</body>
</html>
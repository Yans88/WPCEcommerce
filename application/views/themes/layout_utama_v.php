<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $judul_browser;?> - GTS</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>icon.ico" type="image/x-icon" />
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- bootstrap 3.0.2 -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Ionicons -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />	
	
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />	
	
	<link href="<?php echo base_url(); ?>assets/bootstrap-toggle/css/bootstrap-toggle.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />	
	<link href="<?php echo base_url(); ?>assets/morris.js/morris.css" rel="stylesheet" type="text/css" />	
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />	
	

	<!-- jQuery 2.0.2 -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>	
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>
	
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jqClock.min.js" type="text/javascript"></script>
	<link href="<?php echo base_url(); ?>assets/magnific/magnific-popup.css" rel="stylesheet" type="text/css" />	

	<!-- jQuery 2.0.2 -->
	<script src="<?php echo base_url(); ?>assets/magnific/jquery.magnific-popup.js"></script>		

	

	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/AdminLTE/app.js" type="text/javascript"></script>
	
<script src="<?php echo base_url(); ?>assets/raphael/raphael.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/morris.js/morris.min.js"></script>
	
	<!-- Waktu -->
	<script type="text/javascript">
    $(document).ready(function(){    
      $(".jam").clock({"format":"24","calendar":"false"});
    });    
  </script>
	
</head>
<body class="skin-blue">
	<!-- header logo: style can be found in header.less -->
	<header class="header">
		<a href="<?php echo site_url();?>" class="logo" style="text-align:center;">
			<!-- Add the class icon to your logo image or logo icon to add the margining -->
			<div>GTS</div>
		</a>

		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="navbar-right">
				<ul class="nav navbar-nav">

					
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="glyphicon glyphicon-user"></i>
							<span><?php echo $u_name;?> <i class="caret"></i></span>
						</a>
						<ul class="dropdown-menu">
						<!--
							<li><a href="<?php echo base_url();?>ubah_password"> <i class="fa fa-key"></i>Ubah Password</a></li>-->
							<li><a href="<?php echo base_url();?>login/logout"> <i class="fa fa-sign-out"></i>Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="left-side sidebar-offcanvas">                
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- Sidebar user panel -->
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<?php $sub_view['level'] = ''; ?>
				<?php $this->load->view('menu_v', $sub_view); ?>
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- Right side column. Contains the navbar and content of the page -->
		<aside class="right-side">                
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					<?php echo $judul_utama;?> 
					<small> <?php echo $judul_sub;?> </small>
				</h1>
				<ol class="breadcrumb">
					<li> 
						<i class="fa fa-calendar"></i> <?php echo date('d F Y'); ?> &nbsp; 
						<i class="fa fa-clock-o"></i> <span  class="jam"></span>
					</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				<?php
				if (! empty ($isi)){
					echo $isi;
				}
				?>

			</section><!-- /.content -->
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->
</body>
</html>
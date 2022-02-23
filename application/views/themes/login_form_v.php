<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>GTS</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>icon.ico" type="image/x-icon" />
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- bootstrap 3.0.2 -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
</head>
<style>
.bg-gray {
    background-color: #eaeaec !important;
}
.form-box .footer {
    padding: 10px 20px;
    background: #fff;
    color: #444;
}
.form-box .header {
    -webkit-border-top-left-radius: 4px;
    -webkit-border-top-right-radius: 4px;
    -webkit-border-bottom-right-radius: 0;
    -webkit-border-bottom-left-radius: 0;
    -moz-border-radius-topleft: 4px;
    -moz-border-radius-topright: 4px;
    -moz-border-radius-bottomright: 0;
    -moz-border-radius-bottomleft: 0;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
   
    box-shadow: inset 0px -3px 0px rgba(0, 0, 0, 0.2);
    padding: 20px 10px;
    text-align: center;
    font-size: 26px;
    font-weight: 300;
    color: #fff;
}
</style>
<body>
	<br><br>
	
	<p align="center">
		
	</p>
	<div class="form-box" id="login-box">
		<div class="header"><b>GTS</b></div>
		<form action="" method="post">
			<div class="body bg-gray">
				<?php 
				if (!empty($pesan)) {
					echo '<div style="color: red;">' . $pesan . '</div>';
				}
				?>
				<div class="form-group">
					<input style="width:92%" type="text" name="u_name" id="u_name" class="form-control" placeholder="Username" value="<?php echo set_value('u_name');?>" />
					<?php echo form_error('u_name', '<p style="color: red;">', '</p>');?>
				</div>
				<div class="form-group">
					<input style="width:92%" type="password" name="pass_word" class="form-control" placeholder="Password" />
					<?php echo form_error('pass_word', '<p style="color: red;">', '</p>');?>
				</div> 
				<button type="submit" class="btn btn-primary btn-block">Login</button>
			</div>
			<div class="footer"> 
				&copy; Copyright <?php echo date('Y'); ?> |andTechnology
			</div>
		</form>
	</div>

	<!-- jQuery 2.0.2 -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>


<script type="text/javascript">
	$(document).ready(function() {
		$('#u_name').focus();
	});
</script>

</body>
</html>
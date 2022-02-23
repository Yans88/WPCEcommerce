<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>KLIKDISKON</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>icon.ico" type="image/x-icon" />
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- bootstrap 3.0.2 -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />

	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>	
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>

<section class="content">
				<style type="text/css">
	.row * {
		box-sizing: border-box;
	}
	.kotak_judul {
		 border-bottom: 1px solid #fff; 
		 padding-bottom: 2px;
		 margin: 0;
	}
	.table > tbody > tr > td{
		vertical-align : middle;
	}
	.custom-file-input::-webkit-file-upload-button {
		visibility: hidden;
	}
	.custom-file-input::before {
	  content: 'Select Photo';
	  display: inline-block;
	  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
	  border: 1px solid #999;
	  border-radius: 3px;
	  padding: 1px 4px;
	  outline: none;
	  white-space: nowrap;
	  -webkit-user-select: none;
	  cursor: pointer;
	  text-shadow: 1px 1px #fff;
	  font-weight: 700;  
	}
	.custom-file-input:hover::before {	 
	  color: #d3394c;
	}

	.custom-file-input:active::before {
	  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
	  color: #d3394c;
	}

</style>

<div class="box box-success">

<div class="box-body">	
	<?php if(!empty($msg)) { ?>
		<div class="box-body">
			<div class="alert alert-success alert-dismissable">
		     	<i class="fa fa-check"></i>
		        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		        		<?php echo $msg;?>
		    </div>
		</div>
	<?php } ?>
	<table class="table table-bordered table-reponsive">
	<form name="frm_edit" method="post" id="frm_edit" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
    <input type="hidden" name="upline" value="<?php echo $upline;?>"/>
		<tbody>
        	<tr class="header_kolom">
				<th style="vertical-align: middle; text-align:center"> Register  </th>
			</tr>
			<tr>
			<td> 
				<table class="table table-responsive">
					<tbody>
                    <tr style="vertical-align:middle;">
						<td width="8%"><b>Your Name </b></td>
						<td width="2%">:</td>
						<td>
                        <span class="label label-danger pull-right nama_member_err" style="margin-bottom:2px;"></span>
                        <input class="form-control" name="nama_member" id="nama_member" placeholder="Your Name" style="width:93%; height:18px;" type="text" value=""></td>
            
            			<td><b>Phone </b></td>
						<td>:</td>
            			<td><span class="label label-danger pull-right phone_err" style="margin-bottom:2px;"></span><input class="form-control" name="phone" id="phone" placeholder="Phone" style="width:95%; height:18px;" type="text" value=""></td>
					</tr>
            
					<tr>
						<td><b>Email</b></td><td width="2%">:</td>
						<td>
                        <span class="label label-danger pull-right email_err" style="margin-bottom:2px;"></span>
                        <input class="form-control" name="email" id="email" placeholder="Email" style="width:93%; height:18px;" type="text" value=""></td>
						<td width="8%"><b>Birth Date</b> </td><td width="2%">:</td>
                        <td>
                        <span class="label label-danger pull-right dob_err" style="margin-bottom:2px;"></span>
                        <input class="form-control" name="dob" id="dob" placeholder="Birth Date" style="width:95%; height:18px;" type="text" value=""></td>
					</tr>
            
        			<tr>
						<td><b>City</b></td><td width="2%">:</td>
						<td><input class="form-control" name="kota" id="kota" placeholder="City" style="width:93%; height:18px;" type="text" value=""></td>
						<td><b>Postal Code</b> </td><td width="2%">:</td>
                        <td><input class="form-control" name="kode_pos" id="kode_pos" placeholder="Postal Code" style="width:95%; height:18px;" type="text" value=""></td>
					</tr>
			
                    <tr>
                        <td><b>Gender</b></td><td width="2%">:</td>
                        <td>
                            <select class="form-control" name="jk" id="jk" style="width:98%;">
                                <option value="">- Select -</option>
                                <option value="2">Female</option>
                                <option value="1">Male</option>
                            </select>
                        </td>
						<td><b>Password</b><span class="label label-danger pull-right password_error"></span></td><td width="2%">:</td>
            			<td><input class="form-control" name="password" id="password" placeholder="Password" style="width:95%; height:18px;" type="password" value=""></td>
					</tr>
          
                    <tr>
                    	<td><b>Photo</b> </td><td width="2%">:</td>
                        <td><input name="photo" id="photo" type="file" value=""></td>
                    	<td><b>Address</b></td><td width="2%">:</td>
                        <td><textarea name="alamat" id="alamat" class="form-control" style="width:94%;" rows="5" cols="40"></textarea></td>
                    </tr>		
                    	
					</tbody>
               </table>
			</td>
		</tr>
	</tbody>
    </form>
    </table>
	
	
	

</div>
<div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
		
		<button type="button" class="btn btn-success btn_save"><i class="glyphicon glyphicon-ok"></i> Save</button>		
	</div>
</div>
</div>

</section>
<link href="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.js"></script>
<script>
$('.btn_save').click(function(){
	$('.nama_member_err').text('');
	$('.phone_err').text('');
	$('.email_err').text('');
	$('.dob_err').text('');
	$('.password_error').text('');
	var nama_member = $('#nama_member').val();
	var phone = $('#phone').val();
	var email = $('#email').val();
	var dob = $('#dob').val();
	var password = $('#password').val();
	if(nama_member == ''){
		$('.nama_member_err').text('Nama harus diisi');
		return false;
	}
	if(phone == ''){
		$('.phone_err').text('Phone harus diisi');
		return false;
	}
	if(email == ''){
		$('.email_err').text('Email harus diisi');
		return false;
	}
	if (validateEmail(email.trim()) == false){
        $(".email_error").text('Email invalid format');
		return false;
    }
	if(dob == ''){
		$('.dob_err').text('Tanggal lahir harus diisi');
		return false;
	}
	if(password == ''){
		$('.password_error').text('Password harus diisi');
		return false;
	}
	var action = '<?php echo site_url('register/action_reg');?>';
	$('#frm_edit').attr('action', action);
	$('#frm_edit').submit();
});
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
var date_now = '<?php echo date('d/m/Y');?>';
$('#dob').datetimepicker({
	dayOfWeekStart : 1,
	changeYear: false,
	timepicker:false,
	scrollInput:false,
	format:'d-m-Y',
	lang:'en',
	maxDate: date_now
});
</script>
</body>
</html>
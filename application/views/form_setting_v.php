<style>
.form-control{
	height:20px;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title">Setting</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php if($tersimpan == 'Y') { ?>
					<div class="box-body">
						<div class="alert alert-success alert-dismissable">
		                    <i class="fa fa-check"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data berhasil disimpan.
		                </div>
					</div>
				<?php } ?>

				<?php if($tersimpan == 'N') { ?>
					<div class="box-body">
						<div class="alert alert-danger alert-dismissable">
		                    <i class="fa fa-warning"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data tidak berhasil disimpan, silahkan ulangi beberapa saat lagi.
		                </div>
					</div>
				<?php } 
				
				?>

				<div class="form-group">
					<?php 
					echo form_open('');
					//nama sekolah
					$data = array(
		              'name'        => 'email',
		              'id'			=> 'email',
		              'class'		=> 'form-control',
		              'value'       => $email,		   
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Email', 'email');
					echo form_input($data);
					echo '<br>';
					
					//nama ketua
					$data = array(
		              'name'        => 'pass',
		              'id'			=> 'pass',
		              'class'		=> 'form-control',
		              'value'       => $pass,		           
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Mail Password', 'pass');
					echo form_input($data);
					echo '<br>';
					
					
					
					//hp ketua
					$data = array(
		              'name'        => 'subj_email_register',
		              'id'			=> 'subj_email_register',
		              'class'		=> 'form-control',
		              'value'       => $subj_email_register,		              
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Subject Email for Registration', 'subj_email_register');
					echo form_input($data);
					echo '<br>';

					// alamat
					$data = array(
		              'name'        => 'subj_email_forgot',
		              'id'			=> 'subj_email_forgot',
		              'class'		=> 'form-control',
		              'value'       => $subj_email_forgot,		              
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Subject Email for Forgot Password', 'subj_email_forgot');
					echo form_input($data);
					echo '<br>';

					$data = array(
		              'name'        => 'disc_payment',
		              'id'			=> 'disc_payment',
		              'class'		=> 'form-control',
		              'value'       => $disc_payment,		              
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Diskon Pembayaran Manual Transfer(Rp.)', 'disc_payment');
					echo form_input($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'disc_va',
		              'id'			=> 'disc_va',
		              'class'		=> 'form-control',
		              'value'       => $disc_va,		              
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Diskon Pembayaran VA(Rp.)', 'disc_va');
					echo form_input($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'content_forgotPass',
		              'id'			=> 'content_forgotPass',
		              'class'		=> 'form-control',
		              'value'       => $content_forgotPass,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Content Email forgot password', 'content_forgotPass');
					echo form_textarea($data);
					echo '<br>';
					
					// $data = array(
		              // 'name'        => 'content_verifyReg',
		              // 'id'			=> 'content_verifyReg',
		              // 'class'		=> 'form-control',
		              // 'value'       => $content_verifyReg,		              
		              // 'style'       => 'width: 97%'
	            	// );
					// echo form_label('Content Email for Verify Registration', 'content_verifyReg');
					// echo form_textarea($data);
					// echo '<br>';
					
					$data = array(
		              'name'        => 'term_condition',
		              'id'			=> 'term_condition',
		              'class'		=> 'form-control',
		              'value'       => $term_condition,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Term & Condition', 'term_condition');
					echo form_textarea($data);
					echo '<br/>';
					
					$data = array(
		              'name'        => 'policy',
		              'id'			=> 'policy',
		              'class'		=> 'form-control',
		              'value'       => $policy,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Policy', 'policy');
					echo form_textarea($data);
					echo '<br/>';
					
					// submit
					$data = array(
				    'name' 		=> 'submit',
				    'id' 		=> 'submit',
				    'class' 	=> 'btn btn-primary',
				    'value'		=> 'true',
				    'type'	 	=> 'submit',
				    'content' 	=> 'Update'
					);
					// echo '<br>';
					echo form_button($data);


					echo form_close();

					?>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script>
$("input").attr("autocomplete", "off"); 
 $(function (config) {
	CKEDITOR.config.allowedContent = true;
	// CKEDITOR.replace('content_verifyReg');
	CKEDITOR.replace('content_forgotPass');
  	CKEDITOR.replace('term_condition');
	CKEDITOR.replace('policy');
	CKEDITOR.replace('address');
	CKEDITOR.replace('about_us');
	CKEDITOR.replace('sms_verification');
	
});
$('#disc_payment').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
})
$('#disc_va').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
})
</script>
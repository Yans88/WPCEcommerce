<style type="text/css">
	.row * {
		box-sizing: border-box;
	}
	.kotak_judul {
		 border-bottom: 1px solid #fff; 
		 padding-bottom: 2px;
		 margin: 0;
	}
	.box-header {
		color: #444;
		display: block;
		padding: 10px;
		position: relative;
	}
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = $txt_periode_arr[1] . ' ' . $txt_periode_arr[0];
	}

?>

<div class="modal fade" role="dialog" id="confirm_del">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
				<input type="hidden" id="del_id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del">Delete</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal fade" role="dialog" id="frm_user">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Payment Tempo</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="form_users" autocomplete="off">
                <!-- text input -->
				<div class="row">
				
                
				
				<div class="form-group">
					<input type="hidden" value="" name="id_payment" id="id_payment">
                  <label>Payment Tempo</label><span class="label label-danger pull-right payment_name_error"></span>
                  <input type="text" class="form-control" name="payment_name" id="payment_name" value="" placeholder="Payment Tempo" autocomplete="off" />
                </div>	
				
				<div class="form-group">
                  <label>Type</label><span class="label label-danger pull-right type_error"></span>
                  <select class="form-control" name="type" id="type" style="width:100%;">
                	<option value="">- Type -</option>
                    <option value="1">IDR</option>
					<option value="2">Percentage (%)</option>
					</select>
                </div>
				
				<div class="form-group">
                  <label>Admin Fee</label><span class="label label-danger pull-right convenience_fee_error"></span>
                  <input type="text" class="form-control" name="convenience_fee" id="convenience_fee" value="" placeholder="Admin Fee" autocomplete="off" />
                </div>	

                </div>
				
              </form>

              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_save">Save</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>


 <div class="box box-success">
 <div class="box-header">
    <a href="#"><button class="btn btn-success add_user"><i class="fa fa-plus"></i> Add Payment Tempo</button></a>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:50%">Payment Tempo</th>
			
			<th style="text-align:center; width:30%">Admin Fee</th>
			
			<th style="text-align:center; width:16%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;	
				$admin_fee = '';
				$typee = '';
				if(!empty($master_payment)){
					foreach($master_payment as $mp){
						$admin_fee = '';
						$admin_fee = str_replace('.',',',$mp['admin_fee']);
						if($mp['type'] == 1){
							$typee = 'IDR';
							$admin_fee = number_format($mp['admin_fee'],0,',','.');
						}
						$info = $mp['id_payment'].'Þ'.ucwords($mp['nama_payment']).'Þ'.$mp['kode_payment'].'Þ'.$mp['type'].'Þ'.$admin_fee;
						if($mp['type'] == 2){	
							$typee = '%';
							$admin_fee = str_replace('.',',',$mp['admin_fee']).' %';
						}					
						echo '<tr>';
						echo '<td align="center" style="vertical-align: middle;">'.$i++.'.</td>';
						echo '<td style="vertical-align: middle;">'.$mp['nama_payment'].'</td>';
							
						echo '<td align="right" style="vertical-align: middle;">'.$admin_fee.'</td>'; 
						echo '<td align="center" style="vertical-align: middle;">
			<a href="#" title="Edit" id="'.$info.'" class="edit_user"><button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</button></a>
			<a href="#" title="Delete" id="'.$mp['id_payment'].'" class="del_user"><button class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</button></a></td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
</div>

</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 
$('.del_user').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});

$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var url = '<?php echo site_url('payment_tempo/del');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data telah dihapus');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});

$('.yes_save').click(function(){
	var id_payment = $('#id_user').val();	
	
	var payment_name = $('#payment_name').val();
	var convenience_fee = $('#convenience_fee').val();
	var type = $('#type').val();
	
	$('.payment_name_error').text('');
	
	$('.convenience_fee_error').text('');	
	$('.type_error').text('');	
	
	
	if(payment_name <= 0 || payment_name == '') {
		$('.payment_name_error').text('Payment Tempo harus diisi');
		return false;
	}
	if(type <= 0 || type == '') {
		$('.type_error').text('Type harus diisi');
		return false;
	}
	if(convenience_fee == '') {
		$('.convenience_fee_error').text('Biaya Admin harus diisi');
		return false;
	}
	var dt = $('#form_users').serialize();
	var url = '<?php echo site_url('payment_tempo/save');?>';
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){			
			if(response > 0 && response != 'exist'){
				$('#frm_user').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah disimpan');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
			if(response == 'exist'){
				$('.kode_payment_error').text('Kode Payment sudah digunakan');
			}
			
		}
	})
});

$('.add_user').click(function(){
	$('#form_users').find("input[type=text], select, input[type=hidden]").val("");
	
	$('.payment_name_error').text('');
	$('.kode_payment_error').text('');
	$('.type_error').text('');	
	$('#frm_user').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_user').modal('show');
});
$(function() {               
    $('#example88').dataTable({});
});
$('.edit_user').click(function(){
	$('#form_users').find("input[type=text], select").val("");
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#kode_payment').prop('disabled', true);
	$('.payment_name_error').text('');
	$('.kode_payment_error').text('');
	$('.type_error').text('');	
	$('#id_payment').val(dt[0]);
	$('#kode_payment').val(dt[2]);
	$('#payment_name').val(dt[1]);
	$('#type').val(dt[3]);
	$('#convenience_fee').val(dt[4]);
	
	$('#frm_user').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_user').modal('show');
});
$('#convenience_fee').keyup(function(event) {
  $('.convenience_fee_error').text('');
  // format number
  var type = $('#type').val();
  if(type == 1){
	  $(this).val(function(index, value) {
		return value
		.replace(/[^\d]/g,'')
		.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	  });
  }
  if(type == 2){
	  $(this).val(function(index, value) {
		return value
		.replace(/[^\d,]/g,'');		
	  });
  }
  if(type == '' || type <= 0){
	$(this).val('');
	$('.convenience_fee_error').text('Type harus diisi terlebih dahulu');
  }
});
</script>

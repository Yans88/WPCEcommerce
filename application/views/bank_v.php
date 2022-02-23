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
                <h4 class="modal-title">Add Bank</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="form_users" autocomplete="off">
                <!-- text input -->
				<div class="row">
				
                
				
				<div class="form-group">
					<input type="hidden" value="" name="id_bank" id="id_bank">
                  <label>Nama Bank</label><span class="label label-danger pull-right nama_bank_error"></span>
                  <input type="text" class="form-control" name="nama_bank" id="nama_bank" value="" placeholder="Nama Bank" autocomplete="off" />
                </div>	
				
				<div class="form-group">
                  <label>Holder Name</label><span class="label label-danger pull-right holder_name_error"></span>
                  <input type="text" class="form-control" name="holder_name" id="holder_name" value="" placeholder="Holder Name" autocomplete="off" />
                </div>	
				
				<div class="form-group">
                  <label>No. Rekening</label><span class="label label-danger pull-right no_rek_error"></span>
                  <input type="text" class="form-control" name="no_rek" id="no_rek" value="" placeholder="No. Rekening" autocomplete="off" />
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
    <a href="#"><button class="btn btn-success add_user"><i class="fa fa-plus"></i> Add Bank</button></a>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:20%">Nama Bank</th>
			<th style="text-align:center; width:30%">Holder Name</th>
			
			<th style="text-align:center; width:30%">No. Rekening</th>
			
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
						
						$info = $mp['id_bank'].'Þ'.$mp['nama_bank'].'Þ'.$mp['holder_name'].'Þ'.$mp['no_rek'];
									
						echo '<tr>';
						echo '<td align="center" style="vertical-align: middle;">'.$i++.'.</td>';
						echo '<td style="vertical-align: middle;">'.$mp['nama_bank'].'</td>';
							
						echo '<td style="vertical-align: middle;">'.$mp['holder_name'].'</td>'; 
						echo '<td style="vertical-align: middle;">'.$mp['no_rek'].'</td>'; 
						echo '<td align="center" style="vertical-align: middle;">
			<a href="#" title="Edit" id="'.$info.'" class="edit_user"><button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</button></a>
			<a href="#" title="Delete" id="'.$mp['id_bank'].'" class="del_user"><button class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</button></a></td>';
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
	var url = '<?php echo site_url('master_bank/del');?>';
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
	var id_bank = $('#id_bank').val();	
	
	var nama_bank = $('#nama_bank').val();
	var holder_name = $('#holder_name').val();
	var no_rek = $('#no_rek').val();
	$('.nama_bank_error').text('');
	$('.holder_name_error').text('');
	$('.no_rek_error').text('');	
	if(nama_bank <= 0 || nama_bank == '') {
		$('.nama_bank_error').text('Nama Bank harus diisi');
		return false;
	}
	if(holder_name <= 0 || holder_name == '') {
		$('.holder_name_error').text('Holder Name harus diisi');
		return false;
	}
	if(no_rek == '') {
		$('.no_rek_error').text('No.Rekening harus diisi');
		return false;
	}
	var dt = $('#form_users').serialize();
	var url = '<?php echo site_url('master_bank/save');?>';
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
	$('.nama_bank_error').text('');
	$('.holder_name_error').text('');
	$('.no_rek_error').text('');
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
	
	$('.nama_bank_error').text('');
	$('.holder_name_error').text('');
	$('.no_rek_error').text('');	
	$('#id_bank').val(dt[0]);
	$('#nama_bank').val(dt[1]);
	$('#holder_name').val(dt[2]);
	$('#no_rek').val(dt[3]);
	
	
	$('#frm_user').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_user').modal('show');
});

</script>

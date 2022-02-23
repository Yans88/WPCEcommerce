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
	.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
	.toggle.ios .toggle-handle { border-radius: 20px; }
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = $txt_periode_arr[1] . ' ' . $txt_periode_arr[0];
	}

?>

<div class="modal fade" role="dialog" id="confirm_del">
          <div class="modal-dialog" style="width:300px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>

              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<input type="hidden" id="del_isd" value="">
				
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success yes_del">Yes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal fade" role="dialog" id="appr">
          <div class="modal-dialog" style="width:600px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>

              <div class="modal-body" style="padding-bottom:10px;">
				<h4 class="text-center"><b>Apakah anda yakin ? </b></h4>
				<br/>
				<form role="form" id="form_users" autocomplete="off">
                <!-- text input -->
				<div class="row">
				<div class="col-md-6">
					<input type="hidden" id="del_id" value="">
					<input type="hidden" id="status" value="">
					<div class="form-group">
					  <label>Kode Customer</label><span class="label label-danger pull-right kd_cust_error"></span>
					  <input type="text" class="form-control" name="kd_cust" id="kd_cust" value="" placeholder="Kode Customer" autocomplete="off">
					  
					</div>
					<div class="form-group">
					  <label>Sales Person Code</label><span class="label label-danger pull-right slp_code_error"></span>
					  
					  <select class="form-control" name="id_sls" id="id_sls" >
						  <option value="">-- Sales Person Code --</option>
						  <?php if(!empty($sales)){
							  foreach($sales as $c){
								  echo ' <option value="'.$c['id_sales'].'">'.$c['slp_code'].'</option>';
							  }
						  }?>
					  
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
					  <label>WHS CODE</label><span class="label label-danger pull-right id_whs_error"></span>
					  <!-- <input type="text" class="form-control" name="ocrcode_p" id="ocrcode_p" value="" placeholder="WHSCODE" autocomplete="off"> -->
						<select class="form-control" name="id_whs" id="id_whs" >
						  <option value="">-- WHS CODE --</option>
						  <?php if(!empty($warehouse)){
							  foreach($warehouse as $c){
								  echo ' <option value="'.$c['id_whs'].'">'.$c['nama_whs'].'</option>';
							  }
						  }?>
					  
						</select>
					</div>
					<div class="form-group">
					  <label>Ocrcode</label><span class="label label-danger pull-right ocrcode_c_error"></span>
					  <input type="text" class="form-control" name="ocrcode_c" id="ocrcode_c" value="" placeholder="Ocrcode" autocomplete="off">
					  
					</div>
					<div class="form-group hide">
					  <label>Limit Credit</label><span class="label label-danger pull-right limit_credit_error"></span>
					  <input type="text" class="form-control" name="limit_credit" id="limit_credit" value="" placeholder="Limit Credit" autocomplete="off">
					  
					</div>
				</div>
                </div>
				
              </form>
				
				
              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success yes_appr">Approve</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal fade" role="dialog" id="import_dialog">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Import</strong></h4>
              </div>
			 
              <div class="modal-body">
				<form role="form" action="<?php echo site_url('members/import');?>" id="frm_import" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
				<div class="row">
				 <div class="form-group">
                  <label>Pilih file (.csv or .xls)</label><span class="label label-danger pull-right"></span>
                  <input type="file" class="form-control custom-file-input" name="user_import" id="user_import" accept=".csv, .xls" required />
                 
                </div>
                </div>
				
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="submit" class="btn btn-success">Import</button>               
              </div>
            </div>
			</form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

 <div class="box box-success">
 <div class="box-header">
    
	<button class="btn btn-info btn_import"><i class="fa fa-cloud-download"></i> Import</button>
	<button class="btn btn-warning btn_export"><i class="fa fa-cloud-upload"></i> Eksport</button>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">

    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:15%">Name</th>			
			<th style="text-align:center; width:13%">Email</th>		
			<th style="text-align:center; width:20%">Address</th>
			<th style="text-align:center; width:15%">Tier</th>		
			<th style="text-align:center; width:7%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php
				$i =1;
				$status = '';
				$view_member = '';
				if(!empty($member)){
					foreach($member as $e){
						$status = '';
						$view_member = '';
						if($e['status'] == 2){
							$status = '<small class="label label-info">Approved</small>';
						}
						if($e['status'] == 3){
							$status = '<small class="label label-danger">Rejected</small>';
						}
						if($e['status'] == 4){
							$status = '<small class="label label-success">Active</small>';
						}
						if($e['status'] == 5){
							$status = '<small class="label label-warning">Inactive</small>';
						}
						
						$view_member = site_url('members/view_member/'.$e['id_member']);
						$view_alamat = site_url('members/alamat/'.$e['id_member']);
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.$e['nama'].' - '.$e['kd_cust'].'<br/>'.$e['phone'].'<br/>'.$status.'</td>';
						echo '<td>'.$e['email'].'</td>';				
						echo '<td>'.$e['address'].'</td>'; 
						if((int)$e['id_tier'] > 0){
							echo '<td>'.$e['nama_tier'].'<br/>Diskon : '.$e['diskon'].'%</td>';
						}else{
							echo '<td> - </td>';
						}						
						echo '<td align="center">';
						if($e['status'] == 1){ //request  2=>appr(none), 3 => reject, 4=>active
							echo '<button id="'.$e['id_member'].'" style="margin-top:5px; width:69px;" title="Reject" class="btn btn-xs btn-danger btn_rej"><i class="glyphicon glyphicon-remove"></i> Reject</button><br/><button id="'.$e['id_member'].'" style="margin-top:5px; width:69px;" title="Approve" class="btn btn-xs btn-success btn_appr"><i class="fa fa-check"></i> Approve</button>';
						}
						
						//if($e['status'] == 4){
						echo '<a href="'.$view_member.'"/><button title="View" style="width:69px; margin-top:5px;"  class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</button></a>';
						echo '<a href="'.$view_alamat.'"/><button title="Alamat" style="width:69px; margin-top:5px;"  class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-list-alt"></i> Alamat</button></a>';
						//}
						echo '</td></tr>';
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
$('.btn_appr').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#status').val(4);
	$('#appr').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#appr").modal('show');
});
$('.btn_rej').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#status').val(3);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});
$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var status = $('#status').val();	
	var url = '<?php echo site_url('members/appr_rej');?>';
	$.ajax({
		data : {id : id, status:status},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data member telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});
		}
	});
});

$('.yes_appr').click(function(){
	var id = $('#del_id').val();
	var status = $('#status').val();
	var kd_cust = $('#kd_cust').val();
	var slp_code = $('#id_sls').val();
	var limit_credit = $('#limit_credit').val();
	var id_whs = $('#id_whs').val();
	var ocrcode_c = $('#ocrcode_c').val();
	$('.limit_credit_error').text('');
	$('.kd_cust_error').text('');
	$('.slp_code_error').text('');
	if(kd_cust == ''){
		$('.kd_cust_error').text('Kode Customer harus di isi');
		return false;
	}
	if(slp_code == ''){
		$('.slp_code_error').text('Sales Person Code harus di isi');
		return false;
	}
	var url = '<?php echo site_url('members/appr_rej');?>';
	$.ajax({
		data : {id : id, status:status, limit_credit:limit_credit,kd_cust:kd_cust,id_sls:slp_code,id_whs:id_whs,ocrcode_c:ocrcode_c},
		url : url,
		type : "POST",
		success:function(response){
			$('#appr').modal('hide');
			$("#id_text").html('<b>Success,</b> Data member telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});
		}
	});

});

$('.btn_import').click(function(){	
	$('#import_dialog').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#import_dialog').modal('show');
});
$('.btn_export').click(function(){	
	var url = '<?php echo site_url('members/export_r');?>';
	window.location.href = url;
});
$(function() {
    $('#example88').dataTable({});
});

$('#limit_credit').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
});
</script>

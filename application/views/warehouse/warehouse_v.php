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

<div class="modal fade" role="dialog" id="frm_category">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add/Edit</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_cat" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				<div class="row">
				
				<div class="form-group">
                  <label>WHS Code</label><span class="label label-danger pull-right whs_code_error"></span>
                  <input type="text" class="form-control" name="whs_code" id="whs_code" value="" placeholder="WHS Code" autocomplete="off" />
                  
                </div>
				<div class="form-group">
                  <label>Warehouse</label><span class="label label-danger pull-right warehouse_error"></span>
                  <input type="text" class="form-control" name="warehouse" id="warehouse" value="" placeholder="Warehouse" autocomplete="off" />
                  <input type="hidden" value="" name="id_warehouse" id="id_warehouse">
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
    <a href="#"><button class="btn btn-success add_category"><i class="fa fa-plus"></i> Add</button></a>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:10%">ID</th>			
			<th style="text-align:center; width:20%">WHS Code</th>			
			<th style="text-align:center; width:30%">Warehouse</th>			
			
			<th style="text-align:center; width:14%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$info = '';	
				$path = '';		
				if(!empty($warehouse)){		
					foreach($warehouse as $c){	
						$view_sub = '';
						
						$info = $c['id_whs'].'Þ'.$c['nama_whs'].'Þ'.$c['whs_code'];
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.$c['id_whs'].'</td>';
						echo '<td>'.$c['whs_code'].'</td>';
						echo '<td>'.ucwords($c['nama_whs']).'</td>';
						
						
						echo '<td align="center" style="vertical-align: middle;">		
			
			
			<button id="'.$info.'" class="btn btn-xs btn-success edit_category"><i class="fa fa-edit"></i> Edit</button>
			<button title="Delete" id="'.$c['id_whs'].'" class="btn btn-xs btn-danger del_category"><i class="fa fa-trash-o"></i> Delete</button>		
						</td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
</div>

</div>
<script src="<?php echo base_url(); ?>assets/bootstrap-toggle/js/bootstrap-toggle.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 

$('.add_category').click(function(){
	$('#frm_cat').find("input[type=text], select, input[type=hidden]").val("");
	
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});
$('.edit_category').click(function(){
	$('#frm_cat').find("input[type=text], select").val("");
	
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_warehouse').val(dt[0]);
	$('#warehouse').val(dt[1]);	
	$('#whs_code').val(dt[2]);	
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});

$('.del_category').click(function(){
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
	var url = '<?php echo site_url('warehouse/del');?>';
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
	var warehouse = $('#warehouse').val();
	$('.warehouse_error').text('');
	if(warehouse <= 0 || warehouse == '') {
		$('.warehouse_error').text('Warehouse harus diisi');
		return false;
	}
	
	var url = '<?php echo site_url('warehouse/simpan');?>';
	$('#frm_cat').attr('action', url);
	$('#frm_cat').submit();
	
});



$(function() {               
    $('#example88').dataTable({});
});


</script>

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

<div class="modal fade" role="dialog" id="act_dialog">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>

              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<input type="hidden" id="act_id" value="">
				<input type="hidden" id="status" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success yes_act">Yes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

 <div class="box box-success">
 <div class="box-header">
    <a href="<?php echo site_url('merchants/add');?>"><button class="btn btn-success"><i class="fa fa-plus"></i> Add Principal</button></a>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
            <th style="text-align:center; width:20%">Principal Name</th>
            
            <th style="text-align:center; width:50%">Address</th>		
				
			<th style="text-align:center; width:18%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$info = '';			
				if(!empty($merchants)){		
					foreach($merchants as $m){	
						$view_sub = '';
						$info = $m['id_merchants'].'Þ'.$m['nama_merchants'].'Þ'.$m['description'];
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.$m['nama_merchants'].'</td>';
						
						echo '<td>'.$m['address'].'</td>';
						
						echo '<td align="center" style="vertical-align: middle;">';
						
						echo '
			<a class="hide" href="'.site_url('merchants/detail/'.$m['id_merchants']).'" title="Detail"><button class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</button></a>
			<a href="'.site_url('merchants/add/'.$m['id_merchants']).'" title="Edit"><button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</button></a>
			<button title="Delete" id="'.$m['id_merchants'].'" class="btn btn-xs btn-danger del_news"><i class="fa fa-trash-o"></i> Delete</button>		
						</td>';
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

$('.btn_active').click(function(){
	var val = $(this).get(0).id;
	$('#act_id').val(val);
	$('#status').val(1);
	$('#act_dialog').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#act_dialog").modal('show');
});
$('.btn_inactive').click(function(){
	var val = $(this).get(0).id;
	$('#act_id').val(val);
	$('#status').val(0);
	$('#act_dialog').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#act_dialog").modal('show');
});
$('.yes_act').click(function(){
	var id = $('#act_id').val();
	var status = $('#status').val();
	var url = '<?php echo site_url('merchants/inactive');?>';
	$.ajax({
		data : {id : id, status:status},
		url : url,
		type : "POST",
		success:function(response){
			$('#act_dialog').modal('hide');
			$("#id_text").html('<b>Success,</b> Data merchant telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});
		}
	});

});

$('.del_news').click(function(){
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
	var url = '<?php echo site_url('merchants/del');?>';
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
	//var content = $('#content').val();
	var content = CKEDITOR.instances['content'].getData();
	$('.content_error').text('');
	if(content <= 0 || content == '') {
		$('.content_error').text('Konten harus diisi');
		return false;
	}
	for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
	var dt = $('#frm_cat').serialize();
	var url = '<?php echo site_url('news/simpan');?>';
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){			
			if(response > 0){
				$('#frm_category').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah disimpan');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}else{
				
			}
		}
	})
});


$(function() {               
    $('#example88').dataTable({});
});


</script>
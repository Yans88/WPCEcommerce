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




 <div class="box box-success">
 <div class="box-header">
    <a href="<?php echo site_url('role/add');?>"><button class="btn btn-success add_user"><i class="fa fa-plus"></i> Add Level</button></a>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:5%">No.</th>
			<th style="text-align:center; width:70%">Level Name</th>			
			<th style="text-align:center; width:15%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				if(!empty($level)){
					$link = '';
					foreach($level as $l){	
						$info = 0;
						echo '<tr>';
						echo '<td align="center" style="vertical-align: middle;">'.$i++.'.</td>';
						echo '<td style="vertical-align: middle;">'.$l['level_name'].'</td>';
						$link = site_url('role/add/'.$l['id']);
						echo '<td align="center" style="vertical-align: middle;">			
			<a href="'.$link.'" title="Edit Level" class="edit_user"><button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</button></a>
			<a href="#" title="Delete Level" id="'.$l['id'].'" class="del_level"><button class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</button></a>
			
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
$('.del_level').click(function(){
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
	var url = '<?php echo site_url('role/del');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data level telah dihapus');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});




$(function() {               
    $('#example88').dataTable({});
});


</script>

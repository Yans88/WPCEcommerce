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
          <div class="modal-dialog" style="width:800px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Notif</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_cat" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				<div class="row">
				<div class="form-group">
                  <label>Content</label><span class="label label-danger pull-right code_error"></span>
                  <textarea class="form-control" rows=10 name="content_notif" id="content_notif" value="" placeholder="Content" autocomplete="off" ></textarea>
                  <input type="hidden" value="0" name="id_promo" id="id_promo">
                </div>
               
                
				</div>
                
              </form>

              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_save">Send</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>


 <div class="box box-success">
 <div class="box-header">
    <a href="#"><button class="btn btn-success add_news"><i class="fa fa-plus"></i> Add Notif</button></a>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
            <th style="text-align:center; width:13%">Date</th>
            
			<th style="text-align:center; width:50%">Content</th>	
            <th style="text-align:center; width:20%">Created By</th>
			
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$status = '';
				$img = '';	
				$path = '';	
				$info = '';	
				if(!empty($blast_notif)){		
					foreach($blast_notif as $bn){	
						
						
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.date('d, M Y', strtotime($bn['created_at'])).'</td>';
						echo '<td>'.$bn['content'].'</td>';
						echo '<td align="center">'.$bn['fullname'].'</td>';
						
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
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 
// $(function (config) {
	// CKEDITOR.config.allowedContent = true;
	// CKEDITOR.replace('content_notif');
// });
$('.add_news').click(function(){
	$('.code_error').text('');
	$('#frm_cat').find("input[type=text], select, textarea, input[type=hidden]").val("");
	$('#blah').attr('src', '');
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});
$('.edit_news').click(function(){
	$('#frm_cat').find("input[type=text], select").val("");
	$('#blah').attr('src', '');
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_promo').val(dt[0]);
	$('#code_promo').val(dt[1]);
	$('#potongan').val(dt[2]);
	$('#blah').attr('src', dt[4]);
	
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
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
	var url = '<?php echo site_url('promo/del');?>';
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
	var content_notif = $('#content_notif').val();
	console.log(content_notif);
	var url2 = '<?php echo site_url('blast_notif/simpan');?>';
	$('.code_error').text('');
	// alert(content_notif);
	if(content_notif == '' || content_notif.length == 0){
		$('.code_error').text('Silahkan di isi pesan yang mau dikirim');
		return false;
	}
	$.ajax({
		data : {content_notif : content_notif},
		url : url2,
		type : "POST",
		success:function(response){
			$('#frm_category').modal('hide');
			$("#id_text").html('<b>Success,</b> Data telah dikirim');
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
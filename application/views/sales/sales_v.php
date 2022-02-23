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
                  <label>Sales person code</label><span class="label label-danger pull-right slp_code_error"></span>
                  <input type="text" class="form-control" name="slp_code" id="slp_code" value="" placeholder="Sales person code" autocomplete="off" />
                  
                </div>
				<div class="form-group">
                  <label>Nama Sales</label><span class="label label-danger pull-right nama_sales_error"></span>
                  <input type="text" class="form-control" name="nama_sales" id="nama_sales" value="" placeholder="Nama Sales" autocomplete="off" />
                  
                </div>
				<div class="form-group">
                  <label>Password</label><span class="label label-danger pull-right password_error"></span>
                  <input type="text" class="form-control" name="password" id="password" value="" placeholder="Password" autocomplete="off" />
                  <input type="hidden" value="" name="id_sales" id="id_sales">
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
			<th style="text-align:center; width:30%">Nama Sales</th>			
			<th style="text-align:center; width:40%">Sales person code</th>			
					
			
			<th style="text-align:center; width:14%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$info = '';	
				$path = '';		
				if(!empty($sales)){		
					foreach($sales as $c){	
						$view_sub = '';
						
						$info = $c['id_sales'].'Þ'.$c['slp_code'].'Þ'.$this->converter->decode($c['password']).'Þ'.$c['nama_sales']; 
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.$c['id_sales'].'</td>';
						echo '<td>'.$c['nama_sales'].'</td>';
						echo '<td>'.$c['slp_code'].'</td>';				
						
						echo '<td align="center" style="vertical-align: middle;">		
			<button id="'.$info.'" class="btn btn-xs btn-success edit_category"><i class="fa fa-edit"></i> Edit</button>
			<button title="Delete" id="'.$c['id_sales'].'" class="btn btn-xs btn-danger del_category"><i class="fa fa-trash-o"></i> Delete</button>		
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
	$('.slp_code_error').text('');
	$('.password_error').text('');
	$('.nama_sales_error').text('');
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});
$('.edit_category').click(function(){
	$('#frm_cat').find("input[type=text], select").val("");
	$('.slp_code_error').text('');
	$('.password_error').text('');
	$('.nama_sales_error').text('');
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_sales').val(dt[0]);
	$('#slp_code').val(dt[1]);	
	$('#password').val(dt[2]);	
	$('#nama_sales').val(dt[3]);	
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
	var url = '<?php echo site_url('sales/del');?>';
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
	var slp_code = $('#slp_code').val();
	var password = $('#password').val();
	var nama_sales = $('#nama_sales').val();
	$('.slp_code_error').text('');
	$('.password_error').text('');
	$('.nama_sales_error').text('');
	if(slp_code <= 0 || slp_code == '') {
		$('.slp_code_error').text('Sales person code harus diisi');
		return false;
	}
	if(nama_sales <= 0 || nama_sales == '') {
		$('.nama_sales_error').text('Nama Sales harus diisi');
		return false;
	}
	if(password <= 0 || password == '') {
		$('.password_error').text('Password harus diisi');
		return false;
	}
	var url = '<?php echo site_url('sales/simpan');?>';
	$('#frm_cat').attr('action', url);
	$('#frm_cat').submit();
	
});



$(function() {               
    $('#example88').dataTable({});
});


</script>

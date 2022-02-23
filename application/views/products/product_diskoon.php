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
	.box-header {
		color: #444;
		display: block;
		padding: 10px;
		position: relative;
	}
.inbox_chats { height: 539px;}
.inbox_chat { height: 539px; overflow-y: scroll;}
.inbox_chat2 { max-height: 300px; overflow-y: scroll;}
</style>
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
                <h4 class="modal-title">Edit Stock</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_cat" method="post" autocomplete="off">
                <!-- text input -->
				<div class="row">
				<div class="form-group">
                  <label>Product</label>
                  <input type="text" class="form-control" id="product_name" value="<?php echo $product->nama_barang;?>" placeholder="WHS Code" autocomplete="off" disabled readonly />
                </div>
				
				<div class="form-group">
                  <label>Diskon(%)</label><span class="label label-danger pull-right diskon_error"></span>
                  <input type="text" class="form-control" name="diskon" id="diskon" value="" placeholder="Diskon" autocomplete="off" />
                  <input type="hidden" value="" name="id_diskon" id="id_diskon">
                  <input type="hidden" value="" name="id_product" id="id_product">
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
<div class="row">
<div class="col-md-6">
<div class='alert alert-info alert-dismissable' id="success-alert">
  
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
 <div class="box box-success">
 <div class="box-header">
	<h4 class="box-title" style="padding:5px;"><?php echo $product->nama_barang;?></h4>
    <button class="btn btn-success btn-sm pull-right edit_diskon"><i class="fa fa-plus"></i> Add Diskon</button>
	
</div>
<div class="inbox_chats">
<div class="box-body">	
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:1%">No.</th>
            <th style="text-align:center; width:14%">Diskon(%)</th>           	
			<th style="text-align:center; width:22%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i=1;
				if(!empty($list_diskon)){		
					foreach($list_diskon as $c){	
						$info = '';						
						$info = $c['id_diskon'].'Þ'.$c['diskon'];
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.$c['diskon'].'</td>';								
						echo '<td align="center" style="vertical-align: middle;">				
			<button id="'.$info.'" class="btn btn-xs btn-warning edit_diskon"><i class="fa fa-pencil"></i> Edit</button>
			<button title="Delete" id="'.$c['id_diskon'].'" class="btn btn-xs btn-danger del_news"><i class="fa fa-trash-o"></i> Delete</button>
				<button id="'.$c['diskon'].'Þ'.$c['id_diskon'].'" class="btn btn-xs btn-info view_member"><i class="fa fa-list"></i> List Members</button>
						</td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>	

</div>
</div>

</div>
</div>

<div class="col-md-6">
<div class="box box-primary">
            <div class="box-header with-border">
              <h4 class="box-title member_diskon" style="padding:5px;">List Members</h4>
			
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			<div class="inbox_chat">
				<div id="list_members">
				<br/><br/><br/><br/><br/><br/><br/><br/><br/>
				<h4 class="text-center" style="color:#3A4C02; font-weight:600;">Silahkan pilih diskon<br/> untuk melihat member yang terdaftar</h4></div>
            </div>
            </div>
            
          </div>
</div>

<div class="col-sm-12 box_assign">
	<div class="box box-warning">
		<div class="box-header with-border">
            <h4 class="box-title member_diskon_available" style="padding:5px;">List Members Available</h4>			
             <div class="pull-right">
				<div class="form-group">
                  <input type="text" class="form-control .input-sm search_member" name="Search_member" placeholder="search by kode customer, name, phone or email" style="width: 21.7em;">
                </div>
			 </div>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="inbox_chat2">
				<div id="list_members_available"><h4 class="text-center" style="color:#3A4C02; font-weight:600;">Silahkan pilih diskon<br/> untuk melihat member yang terdaftar</h4></div>
			</div>
			</div>
		</div>
		<div class="box-footer clearfix">
              <button type="button" class="btn-sm btn-flat pull-right btn btn-warning" id="btn_close"> Close
               </button>
            </div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
$("#success-alert").hide();
$(".box_assign").hide();
$("input").attr("autocomplete", "off"); 

var id_product = '<?php echo $product->id_product;?>';
$('.edit_diskon').click(function(){
	$('.diskon_error').text('');
	$('#frm_cat').find("input[type=text], select").val("");
	$('#product_name').val('');
	$('#diskon').val('');	
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_diskon').val(dt[0]);
	$('#diskon').val(dt[1]);
	$('#product_name').val('<?php echo $product->nama_barang;?>');	
	$('#id_product').val(id_product);
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});

$('.yes_save').click(function(){
	$('.diskon_error').text('');
	var diskon = $('#diskon').val();
	if(diskon == '' || diskon <= 0){
		$('.diskon_error').text('Required');
		return false;
	}
	var dt = $('#frm_cat').serialize();
	var url = '<?php echo site_url('product/simpan_diskon');?>';
	$.ajax({
		data : dt,
		url : url,
		type : "POST",
		success:function(response){
			if(response == 'exist'){
				$('.diskon_error').text('Diskon already exist');
				return false;
			}else{
				$('#frm_category').modal('hide');
				$("#id_text").html('<b>Success,</b> Data diskon telah disimpan');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});	
			}					
		}
	});
	
});

$('.view_member').click(function(){
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_diskon').val(dt[1]);
	$('.member_diskon').text('List Members Diskon '+dt[0]+'%');
	$('.member_diskon_available').text('List Members Available - Diskon '+dt[0]+'%');
	var url = '<?php echo site_url('product/get_members');?>';
	$.ajax({
		data : {id_diskon:dt[1],id_product:id_product},
		url : url,
		type : "POST",
		success:function(response){
			var obj = JSON.parse(response);				
			$('#list_members').html(obj.list_members);						
			$('#list_members_available').html(obj.list_members_available);						
		}
	});
	$('.box_assign').show(800);
	$("html, body").animate({ scrollTop: $(document).height() }, 1000);
});
 

$('#diskon').keyup(function(event) {  
if($(this).val() > 100) $(this).val(100);
  // format number
	$(this).val(function(index, value) {
		return value
		.replace(/\D/g, "")
		.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
	var url = '<?php echo site_url('product/del_diskon');?>';
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
$('.search_member').keyup(function(){
	var val = $(this).val();
	var url = '<?php echo site_url('product/get_members');?>';
	$.ajax({
		data : {id_diskon:$('#id_diskon').val(),search_member:val,id_product:id_product},
		url : url,
		type : "POST",
		success:function(response){
			var obj = JSON.parse(response);	
				//console.log(obj);
			//$('#list_members').html(obj.list_members);						
			$('#list_members_available').html(obj.list_members_available);						
		}
	});
});
function assign(id){
	$('#'+id).hide(500);
	var url = '<?php echo site_url('product/assign_members');?>';
	$.ajax({
		data : {id_diskon:$('#id_diskon').val(),id_member:id},
		url : url,
		type : "POST",
		success:function(response){
			var obj = JSON.parse(response);	
			$('#list_members').html(obj.list_members);								
		}
	});
}
function unassign(id){
	$('#'+id).hide(500);
	var url = '<?php echo site_url('product/unassign_members');?>';
	$.ajax({
		data : {id_diskon:$('#id_diskon').val(),id_member:id},
		url : url,
		type : "POST",
		success:function(response){
			$('.search_member').keyup();							
		}
	});
}
$('#btn_close').click(function(){
	$("html, body").animate({ scrollTop: 0 }, "slow");
	$('.box_assign').hide(1000);	
});
$(function() {               
    $('#example88').dataTable({responsive:true});
});
</script>

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




 <div class="box box-success">
 <div class="box-header">
    <a href="<?php echo site_url('paket/add_prod/'.$this->converter->encode($id_paket));?>"><button class="btn btn-success"><i class="fa fa-plus"></i> Add Product</button></a>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
            <th style="text-align:center; width:34%">Product Name</th>
            <th style="text-align:center; width:10%">Qty</th>		
			<th style="text-align:center; width:30%">Image</th>			
			<th style="text-align:center; width:13%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$info = '';	
				$path = '';	
				if(!empty($product)){		
					foreach($product as $p){	
						$view_sub = '';
						$path = '';
						$path = !empty($p['img']) ? base_url('uploads/products/'.$p['img']) : base_url('uploads/no_photo.jpg');
						
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.$p['nama_barang'].'</td>';
						
						echo '<td align="right"><input type="text" id="qty_'.$p['id_product'].'" name="qty_'.$p['id_product'].'" value='.number_format($p['qty'],0,',','.').' class="form-control qty" style="width:97%; height:24px;"></td>'; 
						echo '<td class="first" align="center"><a class="" href="'.$path.'" title="'.$p['nama_barang'].'"><img width="200" height="200" src="'.$path.'"></a></td>';
						//$view_sub = site_url('category/subcategory/'.$c['id_kategori']);
						echo '<td align="center" style="vertical-align: middle;">		
			
			
			<button title="Delete" id="'.$p['id_paket_detail'].'" class="btn btn-xs btn-danger del_news"><i class="fa fa-trash-o"></i> Delete</button><br/>	
			
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
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 
var id_paket = '<?php echo $id_paket;?>';

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
	var url = '<?php echo site_url('paket/del');?>';
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




$(function() {               
    $('#example88').dataTable({});
});

$('.qty').keyup(function(event) {
  
  // format number
	$(this).val(function(index, value) {
		return value
		.replace(/\D/g, "")
		.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	});
});

$('.qty').keyup(function() {
	var id = $(this).get(0).id;
	var val = $("#"+id).val();
	$("#"+id).val(val);
	var val = $("#"+id).val();
	var dt = id.split('_');
	var url = '<?php echo site_url('paket/simpan_prod');?>';
	$.ajax({
		data : {id_product : dt[1],id_paket:id_paket, qty:val},
		url : url,
		type : "POST",
		success:function(response){
				
		}
	});
});



$('.first').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title');
				// return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
			}
		}
	});
</script>
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


 <div class="box box-success">
 <div class="box-header">
    <a href="<?php echo site_url('paket/view_product/'.$this->converter->encode($id_paket));?>"><button class="btn btn-warning"><i class="fa fa-mail-reply"></i> Back</button></a>
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
			<th style="text-align:center; width:13%">Select</th>
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
						if($_LEVEL == 1){
							echo '<td>'.$p['nama_barang'].'<br/>Principle : '.$p['nama_merchants'].'<br/>Kategori : '.$p['nama_kategori'].'<br/>Harga : '.number_format($p['harga'],0,',','.').'</td>';
						}
						if($_LEVEL == 2){
							echo '<td>'.$p['nama_barang'].'<br/>Kategori : '.$p['nama_kategori'].'<br/>Harga : '.number_format($p['harga'],0,',','.').'</td>';
						}
						echo '<input type="hidden" value="" id="del_'.$p['id_product'].'" />';
						echo '<td align="right"><input type="text" id="qty_'.$p['id_product'].'" name="qty_'.$p['id_product'].'" value=0 class="form-control qty" style="width:97%; height:24px;" disabled></td>'; 
						echo '<td class="first" align="center"><a class="" href="'.$path.'" title="'.$p['nama_barang'].'"><img width="200" height="200" src="'.$path.'"></a></td>';
						//$view_sub = site_url('category/subcategory/'.$c['id_kategori']);
						echo '<td align="center" style="vertical-align: middle;">		
						<input type="checkbox" class="_chk" name="chk_'.$p['id_product'].'" id="chk_'.$p['id_product'].'" style="height:17px; width:17px;" />		
						</td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
</div>

</div>
<
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 
var id_paket = '<?php echo $id_paket;?>';
$(function() {
    $('._chk').click(function() {
		var id = $(this).get(0).id;
		var dt = id.split('_');
        if ($(this).is(':checked')) {			
			$('#qty_'+dt[1]).val(1);
			$('#qty_'+dt[1]).removeAttr('disabled');
			var qty = $('#qty_'+dt[1]).val();
			var url = '<?php echo site_url('paket/simpan_prod');?>';
			$.ajax({
				data : {id_product : dt[1],id_paket:id_paket, qty:qty},
				url : url,
				type : "POST",
				success:function(response){
					$('#del_'+dt[1]).val(response);	
				}
			});
        } else {
			$('#qty_'+dt[1]).val(0);
            $('#qty_'+dt[1]).attr('disabled', 'disabled');
			var id = $('#del_'+dt[1]).val();
			var url = '<?php echo site_url('paket/del');?>';
			$.ajax({
				data : {id : id},
				url : url,
				type : "POST",
				success:function(response){
							
				}
			});
        }
    });
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



$(function() {               
    $('#example88').dataTable({});
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
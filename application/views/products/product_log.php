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
 
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
            <th style="text-align:center; width:12%">Date</th>
            <th style="text-align:center; width:30%">Product Name</th>
          	
			<th style="text-align:center; width:20%">Keterangan</th>			
			<th style="text-align:center; width:12%">User</th>			
			
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
						$diskon = $p['diskon'] > 0 ? $p['diskon'].'%' : '-';
						
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.date('d-m-Y H:i', strtotime($p['update_at'])).'</td>';
						if($_LEVEL == 1){
							echo '<td>'.$p['nama_barang'].'<br/>Diskon : '.$diskon.'<br/>Harga : '.number_format($p['harga'],0,',','.').'</td>';
						}
						if($_LEVEL == 2){
							echo '<td>'.$p['nama_barang'].'<br/>Diskon : '.$diskon.'<br/>Harga : '.number_format($p['harga'],0,',','.').'</td>';
						}
						
						// echo '<td align="right">'.number_format($p['qty'],0,',','.').'</td>'; 
						echo '<td>'.$p['ket'].'</td>';
						echo '<td>'.$p['fullname'].'</td>';
						//$view_sub = site_url('category/subcategory/'.$c['id_kategori']);
						
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
	var url = '<?php echo site_url('product/del');?>';
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
	var nama_produk = $('#nama_produk').val();
	var point = $('#point').val();
	$('.nama_produk_error').text('');
	if(nama_produk <= 0 || nama_produk == '') {
		$('.nama_produk_error').text('Nama produk harus diisi');
		return false;
	}
	
	if(point <= 0 || point == '') {
		$('.point_error').text('Point harus diisi');
		return false;
	}
	
	var url = '<?php echo site_url('redeem/simpan');?>';
	$('#frm_cat').attr('action', url);
	$('#frm_cat').submit();
});


$(function() {               
    $('#example88').dataTable({responsive:true});
});

$("#userfile").change(function(){
	$('#blah').attr('src', '');
	readURL(this);
});
function readURL(input) {
   if (input.files && input.files[0]) {
        var reader = new FileReader();            
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }            
        reader.readAsDataURL(input.files[0]);
    }
}
$('.btn_import').click(function(){	
	$('#import_dialog').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#import_dialog').modal('show');
});
$('.btn_export').click(function(){	
	var url = '<?php echo site_url('product/export_r');?>';
	window.location.href = url;
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
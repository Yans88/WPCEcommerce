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
	.custom-file-input::-webkit-file-upload-button {
		visibility: hidden;
	}
	.custom-file-input::before {
	  content: 'Select Photo';
	  display: inline-block;
	  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
	  border: 1px solid #999;
	  border-radius: 3px;
	  padding: 1px 4px;
	  outline: none;
	  white-space: nowrap;
	  -webkit-user-select: none;
	  cursor: pointer;
	  text-shadow: 1px 1px #fff;
	  font-weight: 700;  
	}
	.custom-file-input:hover::before {	 
	  color: #d3394c;
	}

	.custom-file-input:active::before {
	  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
	  color: #d3394c;
	}

</style>
<?php
$tanggal = date('Y-m');
$start_date = !empty($product->start_date) ? date('d/m/Y', strtotime($product->start_date)) : '';
$end_date = !empty($product->end_date) ? date('d/m/Y', strtotime($product->end_date)) : '';
$start_date = !empty($start_date) ? $start_date.' - '.$end_date : '';
?>

<div class="box box-success">

<div class="box-body">	
	<table  class="table table-bordered table-reponsive">
	<form name="frm_cat" id="frm_cat" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
		<tr class="header_kolom">
			
			<th style="vertical-align: middle; text-align:center"> Informasi Paket</th>
		</tr>
		<tr>
			
			<td> 
			<table class="table table-responsive">
			<tr style="vertical-align:middle;">
			<td width="13%"><b>Nama Paket </b> </td>
			<td width="2%">:</td>
			<td>
            <input type="hidden" name="id_product" id="id_product" value="<?php echo !empty($product) ? $product->id_product : '';?>"  />
			<span class="label label-danger pull-right nama_produk_error"></span>
			<input class="form-control" name="nama_produk" id="nama_produk" placeholder="Nama Paket" style="width:97%; height:18px;" type="text" value="<?php echo !empty($product->nama_barang) ? ucwords($product->nama_barang) : '';?>">
			</td>
            
            
			
			</tr>
            
            <tr style="vertical-align:middle;">
			<td><b>Harga </b></td>
			<td>:</td>
            <td>
			<span class="label label-danger pull-right harga_error"></span>
			<input class="form-control" name="harga" id="harga" placeholder="Harga" style="width:97%; height:18px;" type="text" value="<?php echo !empty($product->harga) ? number_format($product->harga,0,',','.') : '';?>"> 
			</td>		
			</tr>		
            
			<tr class="hide">
			<td><b>Kategori</b> </td><td width="2%">:</td>
			<td>
            	<select class="form-control" name="kategori" id="kategori" >
                	<option value="">- Pilih Kategori -</option>
                    <?php 
						if(!empty($kat)){
							foreach($kat as $k){
								if($k['id_kategori'] == $product->id_kategori){
									echo '<option selected="selected" value="'.$k['id_kategori'].'">'.$k['nama_kategori'].'</option>';
								}else{
									echo '<option value="'.$k['id_kategori'].'">'.$k['nama_kategori'].'</option>';
								}
							}
						}
					?>
                </select>
			 </td>		
			</tr>
			
			<tr style="vertical-align:middle;">
			<td><b>Stok </b></td>
			<td>:</td>
            <td>
			<input class="form-control" name="stok" id="stok" placeholder="Stok" style="width:97%; height:24px;" type="text" value="<?php echo !empty($product->qty) ? $product->qty : '';?>">
			</td>		
			</tr>
			
			<tr style="vertical-align:middle;">
			<td><b>Date </b></td>
			<td>:</td>
            <td>
			<input class="form-control" name="start_date" id="start_date" placeholder="Start Date" style="width:97%; height:24px;" type="text" value="<?php echo $start_date;?>">
			</td>		
			</tr>
			<tr style="vertical-align:middle;">
			<td><b>Potongan Tier </b></td>
			<td>:</td>
            <td>
				<?php if(!empty($product->pot_tier) && (int)$product->pot_tier > 0 ){
					echo '<input type="checkbox" name="pot_tier" checked id="pot_tier" style="height:15px; width:8%;" />';
				}else{
					echo '<input type="checkbox" name="pot_tier"  id="pot_tier" style="height:15px; width:8%;" />';
				}?>
				
			</td>		
			</tr>
			<tr><td><b>Deskripsi</b></td><td width="2%">:</td><td>
				<textarea name="deskripsi" id="deskripsi" class="form-control" style="width:97%;" rows="5"><?php echo !empty($product->deskripsi) ? $product->deskripsi : '';?></textarea>
			</td></tr>
			<tr><td><b>Image</b></td><td width="2%">:</td><td>
				<input type="file" class="form-control custom-file-input" style="width:97%; height:24px;" name="userfile" id="userfile" accept="image/*" />
			</td></tr>	
			<tr><td></td><td width="2%"></td><td>
				<div class="fileupload-new thumbnail" style="width: 200px; height: 150px; margin-bottom:5px;">
				<img id="blah" style="width: 200px; height: 150px;" src="" alt="">
			</td></tr>	
			
			</table>
			</td>

		</tr>
	</table>
	
	</form>
	

</div>
<div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
    	<a href="<?php echo site_url('product');?>" > <button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancel</button></a>	
		
		<button type="button" class="btn btn-success btn_save"><i class="glyphicon glyphicon-ok"></i> Save</button>		
	</div>
</div>
</div>

<link href="<?php echo base_url(); ?>assets/daterangepicker-master/daterangepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/daterangepicker-master/moment.min.js"></script>

<script src="<?php echo base_url(); ?>assets/daterangepicker-master/daterangepicker.js"></script>
	
<script type="text/javascript">
var img = '<?php echo !empty($product->img) ? base_url('uploads/products/'.$product->img) : '';?>';
$(function() {
  $('input[name="start_date"]').daterangepicker({
    opens: 'left',
	autoUpdateInput: false,
	minDate: moment().format('D/MM/Y'),
	locale: {
      format: 'D/MM/Y'
    }
  });
});
$('input[name="start_date"]').on('apply.daterangepicker', function(ev, picker) {
	
    $(this).val(picker.startDate.format('D/MM/Y') + ' - ' + picker.endDate.format('D/MM/Y'));
	
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
if(img != ''){
	$('#blah').attr('src', img); 
}

$('.btn_save').click(function(){
	var nama_produk = $('#nama_produk').val();
	var harga = $('#harga').val();
	$('.nama_produk_error').text('');
	$('.harga_error').text('');
	if(nama_produk <= 0 || nama_produk == '') {
		$('.nama_produk_error').text('Nama produk harus diisi');
		return false;
	}
	
	if(harga <= 0 || harga == '') {
		$('.harga_error').text('Harga harus diisi');
		return false;
	}
	
	var url = '<?php echo site_url('paket/simpan');?>';
	$('#frm_cat').attr('action', url);
	$('#frm_cat').submit();
 });
 $('#harga').keyup(function(event) {
  
  // format number
	$(this).val(function(index, value) {
		return value
		.replace(/\D/g, "")
		.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	});
});
 $('#stok').keyup(function(event) {
  
  // format number
	$(this).val(function(index, value) {
		return value
		.replace(/\D/g, "")
		.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	});
});
</script>

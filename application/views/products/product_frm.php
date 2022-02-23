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
			
			<th style="vertical-align: middle; text-align:center"> Informasi Product  </th>
		</tr>
		<tr>
			
			<td> 
			<table class="table table-responsive">
			<tr style="vertical-align:middle;">
			<td width="12%"><b>Product Name </b> </td>
			<td width="2%">:</td>
			<td>
            <input type="hidden" name="id_product" id="id_product" value="<?php echo !empty($product) ? $product->id_product : '';?>"  />
			<span class="label label-danger pull-right nama_produk_error"></span>
			<input class="form-control" name="nama_produk" id="nama_produk" placeholder="Product Name" style="width:92%; height:18px;" type="text" value="<?php echo !empty($product->nama_barang) ? ucwords($product->nama_barang) : '';?>">
			</td>
            <td width="12%" align="right"><b>Price </b></td>
			<td width="2%">:</td>
            <td>
			<span class="label label-danger pull-right harga_error"></span>
			<input class="form-control" name="harga" id="harga" placeholder="Price" style="width:93%; height:18px;" type="text" value="<?php echo !empty($product->harga) ? number_format($product->harga,2,'.',',') : '';?>"> 
			</td>	
            
			
			</tr>
            
            <tr style="vertical-align:middle;">
				<td><b>Category</b> </td><td width="2%">:</td>
				<td>
					<select class="form-control" name="kategori" id="kategori" >
						<option value="">- Select Category -</option>
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
				<td align="right"><b>Discount Product(%) </b></td>
				<td>:</td>
				<td>
				<input class="form-control" name="diskon" id="diskon" placeholder="Discount Product(%)" style="width:93%; height:18px;" type="text" value="<?php echo $product->diskon > 0 ? $product->diskon : '';?>">
				</td>
			</tr>		
            
			<tr>
			
			</tr>
			
			
			<tr style="vertical-align:middle;">
			<td ><b>Brand </b></td>
			<td>:</td>
           <td>
					<select class="form-control" name="brand" id="brand" >
						<option value="">- Select Brand -</option>
						<?php 
							if(!empty($brand)){
								foreach($brand as $b){
									if($b['id_brand'] == $product->id_brand){
										echo '<option selected="selected" value="'.$b['id_brand'].'">'.$b['nama_brand'].'</option>';
									}else{
										echo '<option value="'.$b['id_brand'].'">'.$b['nama_brand'].'</option>';
									}
								}
							}
						?>
					</select>
				 </td>		
			<td align="right"><b>Area </b></td>
			<td>:</td>
            <td>
					<select class="form-control" name="area" id="area" >
						<option value="">- Select Area -</option>
						<?php 
							if(!empty($area)){
								foreach($area as $a){
									if($a['id_area'] == $product->id_area){
										echo '<option selected="selected" value="'.$a['id_area'].'">'.$a['nama_area'].'</option>';
									}else{
										echo '<option value="'.$a['id_area'].'">'.$a['nama_area'].'</option>';
									}
								}
							}
						?>
					</select>
				 </td>	
			</tr>
			<?php if($_LEVEL == 1) { ?>
			<tr><td><b>Principal</b></td><td width="2%">:</td><td colspan=4>
				<select class="form-control" name="principal" id="principal" >
					<option value="">- Select Principal -</option>
					<?php 
						if(!empty($merchants)){
							foreach($merchants as $m){
								if($m['id_merchants'] == $product->id_merchant){
									echo '<option selected="selected" value="'.$m['id_merchants'].'">'.$m['nama_merchants'].'</option>';
								}else{
									echo '<option value="'.$m['id_merchants'].'">'.$m['nama_merchants'].'</option>';
								}
							}
						}
					?>
				</select>
			</td></tr>
			<?php } ?>
			
			<tr><td><b>Description</b></td><td width="2%">:</td><td colspan=4>
				<textarea name="deskripsi" id="deskripsi" class="form-control" style="width:97%;" rows="5"><?php echo !empty($product->deskripsi) ? $product->deskripsi : '';?></textarea>
			</td></tr>
			<tr><td><b>Image</b></td><td width="2%">:</td><td colspan=4>
				<input type="file" class="form-control custom-file-input" style="width:97%; height:24px;" name="userfile" id="userfile" accept="image/*" />
			</td></tr>	
			<tr><td></td><td width="2%"></td><td colspan=4>
				<div class="fileupload-new thumbnail" style="width: 200px; height: 150px; margin-bottom:5px;">
				<img id="blah" style="width: 200px; height: 150px;" src="" alt="">
				</div>
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
	
	var url = '<?php echo site_url('product/simpan');?>';
	$('#frm_cat').attr('action', url);
	$('#frm_cat').submit();
 });
 
$('#harga').keyup(function(event) {
  
  // format number
	$(this).val(function(index, value) {
		return value
		.replace(/[^.\d]/g, "")
		.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
$('#diskon').keyup(function(event) {
  
  // format number
	if($(this).val() > 100) $(this).val(100);
	$(this).val(function(index, value) {
		return value
		.replace(/[^.\d]/g, "")
		.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	});
	
});
</script>

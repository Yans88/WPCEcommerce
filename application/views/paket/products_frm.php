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


?>

<div class="box box-success">

<div class="box-body">	
	<table  class="table table-bordered table-reponsive">
	<form name="frm_edit" id="frm_edit">
		<tr class="header_kolom">
			
			<th style="vertical-align: middle; text-align:center"> Product Information  </th>
		</tr>
		<tr>
			
			<td> 
			<table class="table table-responsive">
			<tr style="vertical-align:middle;">
			<td width="12%"><b>Nama Product </b></td>
			<td width="2%">:</td>
			<td>
            <input type="hidden" name="id_merchants" id="id_merchants" value="<?php echo !empty($product) ? $product->id_product : '';?>"  />
			<input class="form-control" name="nama_merchant" id="nama_merchant" placeholder="Nama Product" style="width:90%; height:18px;" type="text" value="<?php echo !empty($product) ? $product->nama_barang : '';?>"
			</td>
            
             <td width="8%"><b>Kategori</b> </td><td width="2%">:</td><td>
				<select class="form-control" name="kategori" id="kategori" style="width:96%;">
                	<option value="">- Pilih Kategori -</option>
					<?php if(!empty($category)){
						foreach($category as $_c){
							echo '<option value='.$_c['id_kategori'].'>'.$_c['nama_kategori'].'</option>';
						}
					}
					?>
                </select>
			 </td>
			
			</tr>
            
            <tr style="vertical-align:middle;">
			<td><b>Harga</b> </td><td width="2%">:</td>
			<td>
			<input class="form-control" name="harga" id="harga" placeholder="Harga" style="width:90%; height:18px;" type="text" value="<?php echo !empty($product->harga) ? $product->harga : '';?>">
			</td>
            <td><b>Stok</b><span class="label label-danger pull-right password_error"></span></td><td width="2%">:</td><td>
			<input class="form-control" name="stok" id="stok" placeholder="Stok" style="width:90%; height:18px;" type="text" value="<?php echo !empty($product->qty) ? $product->qty : '';?>">
			 </td>       
			
			</tr>
            
		
			<tr><td><b>Deskripsi</b></td><td width="2%">:</td><td colspan=7>
				<textarea name="alamat" id="alamat" class="form-control" style="width:96%;" rows="5"><?php echo !empty($merchants->address) ? $merchants->address : '';?></textarea>
			</td></tr>
			
			<tr><td><b>Image</b></td><td width="2%">:</td><td colspan=7>
				<input type="file" class="form-control custom-file-input" style="width:96%; height:24px;" name="userfile" id="userfile" accept="image/*">
			</td></tr>
			
			<tr><td></td><td width="2%"></td><td>
				<div class="fileupload-new thumbnail" style="width: 200px; height: 150px; margin-bottom:5px;">
				<img id="blah" style="width: 200px; height: 150px;" src="" alt="">
			</div></td></tr>
			</table>
			</td>
		</tr>
	</table>
	
	</form>
	

</div>
<div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
    	<a href="<?php echo site_url('merchants');?>" > <button type="button" class="btn btn-danger back"><i class="glyphicon glyphicon-remove"></i> Cancel</button></a>	
		
		<button type="button" class="btn btn-success btn_save"><i class="glyphicon glyphicon-ok"></i> Save</button>		
	</div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
 
$('.btn_save').click(function(){
	 
	 var email = $('#email').val();
	 var id_merchants = $('#id_merchants').val();
	 var urls = '<?php echo site_url('merchants/chk_email');?>';
	 $.ajax({
		url : urls,
		data : {email : email},
		type : 'POST',
		success:function(res){
			if(res != 0){
				var _res = res.split('_');
				if(_res[1] != id_merchants){
					alert(_res[0]+' sudah terdaftar');
					return false;
				}else{
					simpan_merchant();
				}
			}else{
				simpan_merchant();
			}
		}
	 });
 });
 
 function simpan_merchant(){
	var dt = $('#frm_edit').serialize();
	var url = '<?php echo site_url('merchants/simpan_merchant');?>';
	$.ajax({
		url : url,
		type : 'POST',
		data : dt,
		success:function(result){
			if(result > 0){
				alert('Success, Data sudah disimpan');
				window.location = '<?php echo site_url('merchants');?>';
			}
		}
	});
 }
 $('#fee').keyup(function(event) {
  
  // format number
	$(this).val(function(index, value) {
		return value
		.replace(/[^\d,]/g,'');		
	});
});
</script>

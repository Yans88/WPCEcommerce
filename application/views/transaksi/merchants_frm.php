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
			
			<th style="vertical-align: middle; text-align:center"> Merchant Information  </th>
		</tr>
		<tr>
			
			<td> 
			<table class="table table-responsive">
			<tr style="vertical-align:middle;">
			<td width="13%"><b>Nama Merchant </b></td>
			<td width="2%">:</td>
			<td>
            <input type="hidden" name="id_merchants" id="id_merchants" value="<?php echo $merchants->id_merchants > 0 ? $merchants->id_merchants : '';?>"  />
			<input class="form-control" name="nama_merchant" id="nama_merchant" placeholder="Nama Merchant" style="width:93%; height:18px;" type="text" value="<?php echo !empty($merchants->nama_merchants) ? ucwords($merchants->nama_merchants) : '';?>">
			</td>
            
            <td><b>Point per Pax </b></td>
			<td>:</td>
            <td>
			<input class="form-control" name="point_per_pax" id="point_per_pax" placeholder="Point per Pax" style="width:95%; height:18px;" type="text" value="<?php echo !empty($merchants->point_perpax) ? $merchants->point_perpax : '';?>">
			</td>
			
			</tr>
			<tr>
			<td><b>Kategori</b> </td><td width="2%">:</td>
			<td>
            	<select class="form-control" name="kategori" id="kategori" onchange="get_sub(this.value,0)">
                	<option value="">- Pilih Kategori -</option>
                    <?php 
						if(!empty($kat)){
							foreach($kat as $k){
								if($k['id_kategori'] == $merchants->id_kategori){
									echo '<option selected="selected" value="'.$k['id_kategori'].'">'.$k['nama_kategori'].'</option>';
								}else{
									echo '<option value="'.$k['id_kategori'].'">'.$k['nama_kategori'].'</option>';
								}
							}
						}
					?>
                </select>
			 </td>
			<td width="10%"><b>Latitude</b> </td><td width="2%">:</td><td>
			<input class="form-control" name="latitude" id="latitude" placeholder="Latitude" style="width:95%; height:18px;" type="text" value="<?php echo !empty($merchants->latitude) ? $merchants->latitude : '';?>">
			 </td>
			
			</tr>
			<tr></tr>
			<tr>
			<td><b>Sub Kategori</b></td><td width="2%">:</td>
			<td>
            	<select class="form-control" name="sub_kategori" id="sub_kategori">
                	<option value="">- Pilih Sub Kategori -</option>
                </select>
			
			</td>
			<td><b>Longitude</b><span class="label label-danger pull-right email_error"></span></td><td width="2%">:</td><td colspan=4>
			<input class="form-control" name="longitude" id="longitude" placeholder="Longitude" style="width:95%; height:18px;" type="text" value="<?php echo !empty($merchants->longitude) ? $merchants->longitude : '';?>">
			</td>
			</tr>
			<tr><td><b>Alamat</b></td><td width="2%">:</td><td colspan=7>
				<textarea name="alamat" id="alamat" class="form-control" style="width:98%;" rows="5"><?php echo !empty($merchants->address) ? $merchants->address : '';?></textarea>
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
		<button type="button" class="btn btn-danger canc"><i class="glyphicon glyphicon-remove"></i> Cancel</button>	
		<button type="button" class="btn btn-success btn_save"><i class="glyphicon glyphicon-ok"></i> Save</button>		
	</div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
var id_kategori = '<?php echo !empty($merchants) ? $merchants->id_kategori : 0 ;?>';
var selected = '<?php echo !empty($merchants) ? $merchants->id_sub : 0 ;?>';
if(id_kategori > 0){
	get_sub(id_kategori, selected);
}
function get_sub(id_kategori, selected){
	var url = '<?php echo site_url('merchants/get_sub');?>';
	var html = '';
	$.ajax({
		url : url,
		type:"POST",
		data : {id_kategori : id_kategori, selected:selected},
		beforeSend: function(){
			var wait = '<option value="">Waiting ...</option>';
					$('#sub_kategori').html(wait);
			},
		success: function(data){
			html +=data;
			$('#sub_kategori').html(html);
		}
	});

}
 
 $('.btn_save').click(function(){
	 var dt = $('#frm_edit').serialize();
	 var url = '<?php echo site_url('merchants/simpan_merchant');?>';
	 $.ajax({
		url : url,
		type : 'POST',
		data : dt,
		success:function(res){
			if(res > 0){
				window.location = '<?php echo site_url('merchants');?>';
			}
		}
	});
 })
</script>

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
	<form name="frm_edit" id="frm_edit" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
		<tr class="header_kolom">
			
			<th style="vertical-align: middle; text-align:center"> Informasi Alamat  </th>
		</tr>
		<tr>
			
			<td> 
			<table class="table table-responsive">
			<tr style="vertical-align:middle;">
			<td width="13%"><b>Nama Alamat </b></td>
			<td width="2%">:</td>
			<td width="35%">
            <input type="hidden" name="id_address" id="id_address" value="<?php echo !empty($_alamat) ? $_alamat->id_address : '';?>" />
            <input type="hidden" name="id_member" id="id_member" value="<?php echo $id_member;?>" />
			<input class="form-control" name="nama_alamat" id="nama_alamat" placeholder="Nama Alamat" style="width:90%; height:18px;" type="text" value="<?php echo !empty($_alamat->nama_alamat) ? ucwords($_alamat->nama_alamat) : '';?>" />
			</td>
            
            
            
            <td width="17%"  align="right"><b>Provinsi</b> </td><td width="1%">:</td><td>
			<select class="form-control" name="id_provinsi" id="id_provinsi" >
            	<option value="">- Provinsi -</option>
                <?php
					if(!empty($provinsi)){
						foreach($provinsi as $k){
							if($_alamat->id_provinsi == $k['id_provinsi']){
								echo '<option selected="selected" value="'.$k['id_provinsi'].'">'.$k['nama_provinsi'].'</option>';
							}else{
								echo '<option value="'.$k['id_provinsi'].'">'.$k['nama_provinsi'].'</option>';
							}
						}
					}
				?>
            </select>
			 </td>
            
			</tr>
            
			<tr>
            
            <td><b>Nama Penerima</b><span class="label label-danger pull-right"></span></td><td width="2%">:</td>
            <td>
			<input class="form-control" name="nama_penerima" id="nama_penerima" placeholder="Nama Penerima" style="width:90%; height:18px;" type="text" value="<?php echo !empty($_alamat->nama_penerima) ? $_alamat->nama_penerima : '';?>">
			</td>
			
			
            <td align="right"><b>Kota</b> </td><td width="2%">:</td>
            <td>
			<select class="form-control" name="id_city" id="id_city" >
            	<option value="">- Kota -</option>
                <?php
					if(!empty($city)){
						foreach($city as $sk){
							if($_alamat->id_city == $sk['id_city']){
								echo '<option selected="selected" value="'.$sk['id_city'].'">'.$sk['nama_city'].'</option>';
							}else{
								echo '<option value="'.$sk['id_city'].'">'.$sk['nama_city'].'</option>';
							}
						}
					}
				?>
            </select>
			 </td>
			
			</tr>
            
           <tr>
				
            	<td><b>Phone</b></td>
                <td>:</td>
                <td>
				<input class="form-control" name="phone" id="phone" placeholder="Phone" style="width:90%; height:18px;" type="text" value="<?php echo !empty($_alamat->phone) ? $_alamat->phone : '';?>">
				</td>
				<td  align="right"><b>Kode Pos</b></td>
                <td>:</td>
                <td>
				<input class="form-control" name="kode_pos" id="kode_pos" placeholder="Kode Pos" style="width:90%; height:18px;" type="text" value="<?php echo !empty($_alamat->kode_pos) ? $_alamat->kode_pos : '';?>">
				</td>
            </tr>	
			
			
            
            <tr><td><b>Alamat</b></td><td width="2%">:</td><td colspan=4>
				<textarea name="alamat" id="alamat" class="form-control" style="width:97%;" rows="5"><?php echo !empty($_alamat->alamat) ? $_alamat->alamat : '';?></textarea>
			</td>
			
			</tr>	
			
            
          
           
			</table>
			</td>
		
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

	
<script type="text/javascript">
$("#success-alert").hide();
var id_member = '<?php echo $id_member;?>';


$('.canc').click(function(){
	window.location = '<?php echo site_url('members/alamat');?>/'+id_member;
});

 $('.btn_save').click(function(){
	 var url = '<?php echo site_url('members/simpan_alamat');?>';
	 $('#frm_edit').attr('action', url);
	 $('#frm_edit').submit();
	 //window.location = '<?php echo site_url('merchants');?>';
 });


$('#kode_pos').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "");
  });
});

$('#phone').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "");
  });
});



$('#id_provinsi').on('change', function() {
	var _val = this.value;
	var opt = '';
	opt += '<option value="">- Kota -</option>';			
	var url = '<?php echo site_url('members/get_city');?>';
	if(_val > 0){
		$.ajax({
			data : {id_provinsi : _val},
			url : url,
			dataType  : 'json',
			type : "POST",
			success:function(response){					
				if(response.length != ''){					
					for (var i = 0; i < response.length; i++) {																
						opt += '<option value="'+response[i].id_city+'">'+response[i].nama_city+'</option>';											
					}									
				}
				$("#id_city").html(opt);
			}
		});
	}else{
		$("#id_city").html(opt);
	}			
			
});


</script>

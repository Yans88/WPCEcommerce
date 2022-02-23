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
	
	.direct-chat-msg:before, .direct-chat-msg:after {
		content: " ";
		display: table;
	}
	:after, :before {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	
	.direct-chat-msg:before, .direct-chat-msg:after {
		content: " ";
		display: table;
	}
	:after, :before {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	
	.direct-chat-messages, .direct-chat-contacts {
		-webkit-transition: -webkit-transform .5s ease-in-out;
		-moz-transition: -moz-transform .5s ease-in-out;
		-o-transition: -o-transform .5s ease-in-out;
		transition: transform .5s ease-in-out;
	}
	.direct-chat-messages {
		-webkit-transform: translate(0, 0);
		-ms-transform: translate(0, 0);
		-o-transform: translate(0, 0);
		transform: translate(0, 0);
		padding: 10px;
		height: 300px;
		overflow: auto;
	}
	
	.direct-chat-msg, .direct-chat-text {
		display: block;
	}	
	.direct-chat-info {
		display: block;
		margin-bottom: 2px;
		font-size: 12px;
	}
	
	.direct-chat-text:before {
		border-width: 8px !important;
		margin-top: 3px;
	}
	.direct-chat-text:before {
		position: absolute;
		right: 100%;		
		
		border-right-color: #d2d6de;
		content: ' ';
		height: 0;
		width: 0;
		pointer-events: none;
	}
	
	.direct-chat-text {
		display: block;
	}
	.direct-chat-text {
		border-radius: 5px;
		position: relative;
		padding: 5px 10px;
		background: #ecf4f3;
		border: 1px solid #ecf4f3;
		margin: 5px 0 0 5px;
		color: #444;
	}
	.direct-chat-warning .right>.direct-chat-text{
		background: #ddd;
		border-color: #ddd;
		color: #000;
	}
	
	
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

<div class="modal fade" role="dialog" id="confirm_tier">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Change/Set Tier</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4><b>Choose Tier</b></h4>
				<div class="form-group">
                  
                  <select class="form-control" name="tier" id="tier">
					  <option value="">- Choose Tier -</option>
					  <?php 
					  	if(!empty($tier)){
							foreach($tier as $l){
								echo '<option value="'.$l['id_tier'].'">'.$l['nama_tier'].', Diskon '.$l['diskon'].'%</option>';
							}
						}
					  ?>
				  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success set_tier">Set Tier</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<?php 
$id_member = !empty($member->id_member) ? $member->id_member : 0;
$nama = !empty($member->nama) ? $member->nama : '';
$nama_toko = !empty($member->nama_toko) ? $member->nama_toko : '';
$dob = !empty($member->dob) ? date('d-m-Y', strtotime($member->dob)) : '';
$email = !empty($member->email) ? $member->email : '';
$limit_credit = $member->limit_credit > 0 ? number_format($member->limit_credit,2,',','.') : '0.00'; 
$use_credit = $member->use_credit > 0 ? number_format($member->use_credit,2,',','.') : '0.00'; 
$sisa_credit = $member->sisa_credit > 0 ? number_format($member->sisa_credit,2,',','.') : '0.00'; 
$phone = !empty($member->phone) ? $member->phone : '';
$referensi = !empty($member->referensi) ? $member->referensi : '-';
$photo_ktp = !empty($member->photo_ktp) ? base_url('uploads/members/'.$member->photo_ktp) : base_url('uploads/no_photo.jpg');
$photo_npwp = !empty($member->photo_npwp) ? base_url('uploads/members/'.$member->photo_npwp) : base_url('uploads/no_photo.jpg');
$status = '';
if($member->status == 2){
	$status = '<small class="label label-info">Approved</small>';
}
if($member->status == 3){
	$status = '<small class="label label-danger">Rejected</small>';
}
if($member->status == 4){
	$status = '<small class="label label-success">Active</small>';
}
if($member->status == 5){
	$status = '<small class="label label-warning">Inactive</small>';
}
$tier = (int)$member->id_tier > 0 ? $member->nama_tier : '-';
$diskon = (int)$member->id_tier > 0 ? $member->diskon.'%' : '-';
$alamat = !empty($member->address) ? $member->address : '';
$img = !empty($member->photo) ? base_url('uploads/members/'.$login->photo) : base_url('uploads/no_photo.jpg');
?>

<div class="box box-success">

<div class="box-body">	
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>

	<table class="table table-bordered table-reponsive">
		<tbody><tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center">Image</th>
			<th style="vertical-align: middle; text-align:center">Nama Toko : <?php echo ucwords($nama_toko);?></th>
			
		</tr>
		<tr>
			<td class="h_tengah" style="vertical-align:middle; width:15%">
				
			<img height="150" width="150" src="<?php echo $img;?>"/> 			
			
			</td>
			
			<td class="h_tengah" style="vertical-align:middle; width:85%">
			<table class="table table-responsive">
				<tbody>
					<tr style="vertical-align:middle; text-align:left">
						<td style="width:2%;"><b>Nama</b></td>						
						<td style="width:1%;">:</td>						
						<td>
							<?php echo ucwords($nama);?>
							
						</td>	
						<td style="width:2%;"><b>Status</b></td>
						<td style="width:1%;">:</td>
						<td>
							<?php echo $status;?>
						</td>		
					</tr>	
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Email</b></td>
						<td style="width:1%;">:</td>	
						<td style="width:20%;">
							<?php echo $email;?>
						</td>	
						<td><b>Referensi</b></td>
						<td style="width:1%;">:</td>
						<td style="width:20%;">
							<?php echo $referensi;?>
						</td>
					</tr>
					
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Phone</b></td>
						<td style="width:1%;">:</td>	
						<td style="width:20%;">
							<?php echo $phone;?>  
						</td>	
						<td><b>Tier</b></td>
						<td style="width:1%;">:</td>
						<td style="width:20%;">
							<?php echo $tier.'('.$diskon.')';?>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-warning btn_tier"> Set/Change Tier</button>
						</td>
					</tr>

					<tr style="vertical-align:middle; text-align:left">
						<td><b>Alamat</b></td>
						<td style="width:1%;">:</td>
						<td colspan=4>
							<?php echo $alamat;?>
						</td>											
					</tr>
					
				</tbody>
			</table>
			</td>
			
			
			
		</tr>
		
	</tbody></table>
	<table class="table table-bordered table-reponsive">
		<tbody>
        <tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center;" >Daftar Alamat Pengiriman
				 <a title="Add Alamat" href="<?php echo site_url('members/add_alamat/'.$id_member);?>"><button type="button" id="print" class="btn btn-xs btn-success" style="height:27px; float:right;"><i class="fa fa-plus"></i> Add Alamat</button></a>
			</th>
			
            
		</tr>
		
		<tr style="vertical-align:middle; text-align:left">
			
			<td>
				<table id="example88" class="table table-bordered table-striped">
				<thead><tr>
					<th style="text-align:center; width:4%">No.</th>
					<th style="text-align:center; width:13%">Nama Alamat</th>			
					<th style="text-align:center; width:15%">Penerima</th>		
					<th style="text-align:center; width:25%">Alamat</th>
						
					<th style="text-align:center; width:5%">Action</th>
				</tr>
				</thead>
				<tbody>
					<?php 
						$i =1;
						if(!empty($_alamat)){
							foreach($_alamat as $_a){
								$address = '';
								$address = $_a['alamat'].','.$_a['nama_city'].','.$_a['nama_provinsi'].','.$_a['kode_pos'].'.';
								$edit_alamat = '';
								$edit_alamat = site_url('members/add_alamat/'.$_a['id_member'].'/'.$_a['id_address']);
								echo '<tr>';
								echo '<td align="center">'.$i++.'.</td>';
								echo '<td>'.$_a['nama_alamat'].'</td>';
								echo '<td>'.$_a['nama_penerima'].'<br/>Phone : '.$_a['phone'].'</td>';
								echo '<td>'.$address.'</td>';
								echo '<td align="center">';
								echo '<a href="'.$edit_alamat.'"><button class="btn btn-xs btn-success" style=width:55px;"><i class="fa fa-edit"></i> Edit</button></a><br/><button id="'.$_a['id_address'].'" style="margin-top:3px;" class="btn btn-xs btn-danger del_user"><i class="fa fa-trash-o"></i> Delete</button>';
								echo '</td>';
								echo '</tr>';
							}
						}
					?>
				</tbody>

			</table>
			</td>
			
		</tr>
	</tbody>
	</table>
	
	
	
		

</div>
<div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
		<button type="button" class="btn btn-danger back"><i class="glyphicon glyphicon-arrow-left"></i> Back</button>	
			
	</div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>	

<script>
$("#success-alert").hide();
var id_member = '<?php echo $id_member;?>';
$('.del_user').click(function(){
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
	var url = '<?php echo site_url('members/del_alamat');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data user telah dihapus');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});
$('.btn_tier').click(function(){	
	$('#confirm_tier').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#confirm_tier').modal('show');
});
$('.set_tier').click(function(){
	var id_tier = $('#tier').val();
	var url = '<?php echo site_url('members/set_tier');?>';
	$.ajax({
		data : {id_member : id_member,id_tier:id_tier},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_tier').modal('hide');
			$("#id_text").html('<b>Success,</b> Data tier telah diupdate');
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
</script>
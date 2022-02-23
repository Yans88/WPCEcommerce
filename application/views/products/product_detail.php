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
			<th style="vertical-align: middle; text-align:center; width:50%;" >Photo KTP</th>
			<th style="vertical-align: middle; text-align:center; width:50%;" >Photo NPWP</th>
            
		</tr>
		
		<tr style="vertical-align:middle; text-align:left">
			
			<td class="first h_tengah" align="center">
				<a class="" href="<?php echo $photo_ktp;?>" title="Photo KTP">	
				<img height="200" width="400" src="<?php echo $photo_ktp;?>"/></a> 	
			</td>
			<td class="first h_tengah" align="center">
				<a class="" href="<?php echo $photo_npwp;?>" title="Photo NPWP">	
				<img height="200" width="400" src="<?php echo $photo_npwp;?>"/></a> 	
			</td>	
		</tr>
	</tbody>
	</table>
	<table class="table table-bordered table-reponsive">
		<tbody><tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center; width:33%;" >Transaksi History</th>
			<th style="vertical-align: middle; text-align:center; width:33%;" >History Tagihan</th>
			<th style="vertical-align: middle; text-align:center; width:34%;" >Chat</th>
		</tr>
		
		<tr style="vertical-align:middle; text-align:left">
			
			<?php
				if(count($transaksi) > 0){
			?>
			
			<td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					
					<?php 
					$date_point = '';
					$i=0;
					foreach($transaksi as $ph){
						$date_point = '';
						$info = '';
						$tempo = '';
						if($ph['payment'] == 2){
							$tempo = $ph['tempo'].'x';
						}
						$info = $this->converter->encode($ph['id_transaksi']);
						$date_point = date("d-M-y", strtotime($ph['create_at']));
						
						echo '<div class="direct-chat-info clearfix">';
						if($i%2){
							echo '<span class="direct-chat-text" style="font-size:12px; background:#F9F9F9; border:1px solid #F9F9F9;"><b><a href="'.site_url('members/transaksi_detail/'.$info).'"> No.Transaksi #'.$ph['id_transaksi'].'</a></b><br/>Total : '.number_format($ph['ttl_all'],2,',','.').'<br/>Payment : '.$ph['payment_name'].' '.$tempo.'<span style="float:right;">'.$date_point.'</span></span>';
						}else{
							echo '<span class="direct-chat-text"><b><a href="'.site_url('members/transaksi_detail/'.$info).'"> No.Transaksi #'.$ph['id_transaksi'].'</a></b><br/>Total : '.number_format($ph['ttl_all'],2,',','.').'<br/>Payment : '.$ph['payment_name'].' '.$tempo.'<span style="float:right;">'.$date_point.'</span></span>';
						}
						echo '</div>';
						$i++;
					}
					?>
					

                  </div>
                 
                </div>
              
               
              </div>
			</td>
			
			<?php } else {
					echo '<td align="center"><h3><b>Not Found ... !</b></h3></td>';
				}
			?>
			
			<?php
				if(count($tagihan) > 0){
			?>
			<td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					<?php 
					$date_ewallet = '';
					$nilai = '0.00';
					foreach($tagihan as $eh){
						if($eh['payment'] == 2 && $eh['status'] == 3){
							$date_ewallet = '';
							$_span = '';
							$info = '';
							$info = $this->converter->encode($eh['id_transaksi']);
							if($eh['status_tempo'] == 1){
								$_span = '<span style="float:right;" class="label label-success pull-right">Lunas</span>';
							}
							$date_ewallet = date("d-M-y H:i", strtotime($eh['created_at']));
							echo '<div class="direct-chat-info clearfix">';
							if($i%2){
								echo '<span class="direct-chat-text" style="font-size:12px; background:#F9F9F9; border:1px solid #F9F9F9;"><b><a href="'.site_url('members/transaksi_detail/'.$info).'">No.Tagihan : '.$eh['kode_payment'].'</a></b><br/>Tgl.Tempo : '.date('d', strtotime($eh['tgl_jth_tempo'])).'<br/>Tempo : '.$eh['tempo'].' x '.number_format($ph['angs'],2,',','.').'<br/>Sudah bayar : '.$eh['sdh_byr'].'x '.$_span.'</span>';
							}else{
								echo '<span class="direct-chat-text"><b><a href="'.site_url('members/transaksi_detail/'.$info).'">No.Tagihan : '.$eh['kode_payment'].'</a></b><br/>Tgl.Tempo : '.date('d', strtotime($eh['tgl_jth_tempo'])).'<br/>Tempo : '.$eh['tempo'].' x '.number_format($ph['angs'],2,',','.').'<br/>Sudah bayar : '.$eh['sdh_byr'].'x '.$_span.'</span>';
							}
							
							echo '</div>';
						}
					}
					?>
					
					

                  </div>
                 
                </div>
              
               
              </div>
			</td>	
			<?php } else {
					echo '<td align="center"><h3><b>Not Found ... !</b></h3></td>';
				}
			?>
			
			<?php
				if(count($chat_admin) > 0){
			?>
			<td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					<?php 
					$i = 0;
					foreach($chat_admin as $ch){						
						$date_ewallet = date("d-M-y H:i", strtotime($ch['created_at']));
						echo '<div class="direct-chat-info clearfix">'; 
						if($i%2){
							
							echo '<span class="direct-chat-text" style="font-size:12px; background:#F9F9F9; border:1px solid #F9F9F9; text-align: justify;"><span style="float:right;"><strong>'.$date_ewallet.'</strong></span><br/>'.$ch['pesan'].'</span>';
						}else{
							echo '<span class="direct-chat-text" style="font-size:12px; text-align: justify;"><span style="float:right;"><strong>'.$date_ewallet.'</strong></span><br/>'.$ch['pesan'].'</span>';
						}
						echo '</div>';
						$i++;
					}
					?>
					
					

                  </div>
                 
                </div>
              
               
              </div>
			</td>	
			<?php } else {
					echo '<td align="center"><h3><b>Not Found ... !</b></h3></td>';
				}
			?>
				
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

<link href="<?php echo base_url(); ?>assets/magnific/magnific-popup.css" rel="stylesheet" type="text/css" />	

	<!-- jQuery 2.0.2 -->
<script src="<?php echo base_url(); ?>assets/magnific/jquery.magnific-popup.js"></script>		

<script>
$("#success-alert").hide();
var id_member = '<?php echo $id_member;?>';
$('.back').click(function(){
	history.back();
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
$('.btn_tier').click(function(){	
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#confirm_del').modal('show');
});
$('.set_tier').click(function(){
	var id_tier = $('#tier').val();
	var url = '<?php echo site_url('members/set_tier');?>';
	$.ajax({
		data : {id_member : id_member,id_tier:id_tier},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data tier telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});
</script>
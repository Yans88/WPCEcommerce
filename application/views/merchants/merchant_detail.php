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
		background: #d2d6de;
		border: 1px solid #d2d6de;
		margin: 5px 0 0 5px;
		color: #444;
	}
	.direct-chat-warning .right>.direct-chat-text{
		background: #ddd;
		border-color: #ddd;
		color: #000;
	}
	
	
</style>



<?php 
$nama_merchant = !empty($merchants->nama_merchants) ? $merchants->nama_merchants : '';
$nama_type = !empty($merchants->nama_type) ? $merchants->nama_type : '';
$nama_kategori = !empty($merchants->nama_kategori) ? $merchants->nama_kategori : '';
$nama_sub = !empty($merchants->nama_sub) ? $merchants->nama_sub : '';
$address = !empty($merchants->address) ? $merchants->address : '';
$description = !empty($merchants->description) ? $merchants->description : '';
$disc_term = !empty($merchants->disc_term) ? $merchants->disc_term : '';
// $point_perpax = !empty($merchants->point_perpax) ? $merchants->point_perpax : 0;
$saldo = $merchants->saldo > 0 ? number_format($merchants->saldo,2,',','.') : '0.00'; 
$latitude = !empty($merchants->latitude) ? $merchants->latitude : '';
$longitude = !empty($merchants->longitude) ? $merchants->longitude : '';
$photo = !empty($merchants->photo) ? $merchants->photo : base_url('uploads/no_photo.jpg');
$facility = !empty($merchants->facility) ? $merchants->facility : '';
$disc_term = !empty($merchants->disc_term) ? $merchants->disc_term : '';
$price_range = !empty($merchants->price_range) ? $merchants->price_range : '';
$contact_us = !empty($merchants->contact_us) ? $merchants->contact_us : '';
$opening_hours =  '-';
$tipe_card =  !empty($merchants->tipe_card) ? (int)$merchants->tipe_card : '';
$no_card =  !empty($merchants->no_card) ? $merchants->no_card : '';
$nama_card =  !empty($merchants->nama_card) ? $merchants->nama_card : '';
$alamat_card =  !empty($merchants->alamat_card) ? $merchants->alamat_card : '';
$_tipe_card = '-';
$open_start = !empty($merchants->open_start) ? date('H.i', strtotime($merchants->open_start)) : '';
$open_end = !empty($merchants->open_end) ? date('H.i', strtotime($merchants->open_end)) : '';
if($tipe_card == 1){
	$_tipe_card = 'KTP';
}
if($tipe_card == 2){
	$_tipe_card = 'NPWP';
}
if(!empty($open_start) || !empty($open_end)){
	$opening_hours = $open_start .' - '. $open_end;
}
?>

<div class="modal fade" role="dialog" id="opt_addon">
          <div class="modal-dialog" style="width:600px">
            <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span></button>
					<h4 class="modal-title"><strong></strong></h4>
				</div>

				<div class="modal-body">				
					<div class="load_optaddon"></div>
				
				</div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="box box-success">

<div class="box-body">	


	<table class="table table-bordered table-reponsive">
		<tbody><tr class="header_kolom">
			
			<th colspan=2 style="vertical-align: middle; text-align:center">Information</th>
			
		</tr>
		<tr>
        	
			<td class="h_tengah" style="vertical-align:middle;">
			<table class="table table-responsive">
				<tbody>
					<tr style="vertical-align:middle; text-align:left">
						<td style="width:16%;"><b>Nama Station</b></td>						
						<td style="width:1%;">:</td>						
						<td style="width:34%;"><?php echo $nama_merchant;?></td>
                        <td style="width:10%;"><b>Latitude</b></td>		
						<td style="width:1%;">:</td>							
						<td><?php echo $latitude;?>
						</td>						
					</tr>
                    	
					
					
					<tr style="vertical-align:middle; text-align:left">
                    	<td><b>Saldo</b></td>
						<td style="width:1%;">:</td>
						<td><?php echo $saldo;?></td>		
						<td><b>Longitude</b></td>
						<td style="width:1%;">:</td>
						<td><?php echo $longitude;?>
						</td>
												
					</tr>
                    
                    <tr style="vertical-align:middle; text-align:left">
                    	<td><b>Email</b></td>
						<td style="width:1%;">:</td>
						<td><?php echo $price_range;?></td>		
						<td><b>Contact us</b></td>
						<td style="width:1%;">:</td>
						<td><?php echo $contact_us;?>
						</td>
												
					</tr>
					
					
					
                    <tr style="vertical-align:middle; text-align:left">
						<td><b>Alamat</b></td>
						<td style="width:1%;">:</td>
						<td colspan="4"><?php echo $address;?>
										
					</tr>
					
				</tbody>
			</table>
			</td>									
		</tr>
		
	</tbody></table>
	
	<table class="table table-bordered table-reponsive">
		<tbody><tr class="header_kolom">
			
			<th style="vertical-align: middle; text-align:center;" >History Saldo</th>
			
		</tr>
		
		<tr style="vertical-align:middle; text-align:left">
			
			<?php
				if(count($ewallet_history) > 0){
			?>
			
			<td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					
					<?php 
					$date_ewallet = '';
					$nilai = '0.00';
					foreach($ewallet_history as $eh){
						if($eh['type'] == 1){
							$nilai = '+ '.number_format($eh['nilai'],2,',','.');
						}
						if($eh['type'] == 3){
							$nilai = '- '.number_format($eh['nilai'],2,',','.');
						}
						$date_ewallet = '';
						$date_ewallet = date("d-M-y H:i", strtotime($eh['created_at']));
						echo '<div class="direct-chat-info clearfix">';
						echo '<span class="direct-chat-text"><b>'.ucwords($eh['ket']).'</b><br/>'.$nilai.' ('.number_format($eh['total'],2,',','.').')<span style="float:right;">'.$date_ewallet.'</span></span>';
						echo '</div>';
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
    
	<table class="table table-bordered table-reponsive">
		<tbody><tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center">History Transaksi</th>
			
		</tr>
		<tr>
			<td class="h_tengah" style="vertical-align:middle; border:none; padding-top:10px; padding-left:5px; padding-right:0px; padding-bottom:5px;">
			
			<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:17%">Tanggal</th>			
			<th style="text-align:center; width:18%">Member</th>		
			<th style="text-align:center; width:25%">Address</th>
			<th style="text-align:center; width:10%">Status</th>
			<th style="text-align:center; width:7%">Action</th>
		</tr>
		</thead>
		<tbody>
			
		</tbody>

	</table>
			
			
			
			</td>
			
		</tr>
	</tbody></table>

	<?php if(!empty($kat_menu)){
		foreach($kat_menu as $km){ ?>
			 <table class="table table-bordered table-reponsive">
				<tbody><tr class="header_kolom">
					<th style="vertical-align: middle; text-align:center;" ><?php echo $km['nama_kategori'];?></th>
				</tr>
				<tr>
			<td class="h_tengah" style="vertical-align:middle; border:none; padding-top:10px; padding-left:5px; padding-right:0px; padding-bottom:5px;">
			
			<?php 
			$title = '';
			$img = '';
			$i = 1;
			if(!empty($menu2)){ ?>
				<div class="row" style="text-align:center;">
					<div class="row first">
				<?php 
				foreach ($menu2 as $m){
					// echo $m['id_kat'];
					if($m['id_kat'] == $km['id_kategori']){
						$title = !empty($m['nama_menu']) ? $m['nama_menu'] : 'Menu '.$i;
						$img = base_url('uploads/menu/'.$m['menu']);
						
						echo '<div class="thumbnail pull-left">
						<a class="" href="'.$img.'" title="'.ucwords($title).'">	
								<div class="text">'.ucwords($title).'</div>
								<img src="'.$img.'" class="" style="width:200px; height:200px; margin-bottom:5px;">						
							 </a> 
							 <button type="button" id="opt'.$m['id_menu'].'" class="btn btn-success view_opt">View Option</button>
							 <button type="button" id="add'.$m['id_menu'].'" class="btn btn-success view_addon">View Add on</button>
							 </div>';
							 
							 $i++;
					}
				}?>           
					</div>
				</div>
			<?php }else{
					echo '<h3 class="text-center">Data not found...!</h3>';
			} ?>
			
			
			</td>
			
		</tr>
				
			</tbody>
			</table>
	<?php }} ?>
   

</div>
<div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
		<a href="<?php echo site_url('merchants');?>" > <button type="button" class="btn btn-danger back"><i class="glyphicon glyphicon-arrow-left"></i> Back</button></a>	
			
	</div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/bootstrap-toggle/js/bootstrap-toggle.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(function() {               
    $('#example88').dataTable({});
});
});
</script>
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
	.table-bordered {
		border: none;
	}
	.msg_history {
	  height: 415px;
	  overflow-y: auto;
	}
	.tbl_history {
	  height: 340px;
	  overflow-y: auto;
	}
	.products-list {
    list-style: none;
		margin: 5px;
		padding: 0;
	}
	.products-list>.item {
		
		padding: 10px 0;
		background: #fff;
	}
	.product-list-in-box>.item {
		-webkit-box-shadow: none;
		box-shadow: none;
		border-radius: 0;
		border-bottom: 1px solid #ddd;
	}
</style>

<?php 
$disabled = '';

if($_id_merchant != $transaksi->id_principle){
	// $disabled = ' disabled';
}

$status_name = array(
		'0'=> '<small class="label label-warning"><strong>Waiting payment</strong></small>', 
		'1'=> '', 
		'2'=> '<small class="label label-danger"><strong>Rejected</strong></small>',
		'3'=> '<small class="label label-warning"><strong>Waiting payment</strong></small>', 
		'4'=> '<small class="label label-success"><strong>Dikirim</strong></small>',
		'5'=> '<small class="label label-default"><strong>Sampai tujuan</strong></small>',
		'6'=> '<small class="label label-default"><strong>Pesanan selesai</strong></small>',
		'7'=> 'Complain'
	);
$tgl = '';
$month = '';
$tgl = date('Y-m-d');
$month = date('Y-m');
$payment = $transaksi->payment_name.' <b>'.$transaksi->nama_bank.'</b>';
if($transaksi->payment == 2){
	$payment = $transaksi->payment_name.' '.$transaksi->tempo.' x '.number_format($transaksi->angs,2,',','.');
	if($transaksi->status > 2){
		echo '<div class="row">
		<div class="col-md-8">';
	}
	$status_name = array(
		'0'=> '<small class="label label-warning"><strong>Waiting approval</strong></small>', 
		'1'=> '', 
		'2'=> '<small class="label label-danger"><strong>Rejected</strong></small>',
		'3'=> '<small class="label label-info"><strong>Approved</strong></small>', 
		'4'=> '<small class="label label-success"><strong>Dikirim</strong></small>',
		'5'=> '<small class="label label-default"><strong>Sampai tujuan</strong></small>',
		'6'=> '<small class="label label-default"><strong>Pesanan selesai</strong></small>',
		'7'=> 'Complain'
	);
}

?>
<div class="modal fade" role="dialog" id="confirm_del">
          <div class="modal-dialog" style="width:300px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center text_warning">Apakah anda yakin ? </h4>
				<input type="hidden" id="del_id" nama="del_id" value="">
                <input type="hidden" id="nilai" nama="nilai" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-success yes_app">Ya</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_ang">
          <div class="modal-dialog" style="width:300px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			  
			  <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_cat" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				<div class="row">
				<div class="form-group">
                  <label>Jumlah Angsuran</label><span class="label label-danger pull-right category_error"></span>
                  <select class="form-control" name="jml_angs" id="jml_angs" >
				  <option value="">- Jumlah Angsuran -</option>
				  <?php 
						$i=1;
						$n=0;
						if(!empty($tagihan)){
							foreach($tagihan as $tagi){
								if($tagi['status'] < 1){
									echo '<option value='.$i.'>'.$i.'</option>';
									$i++;
								}
								$tgl_tempo = '';									
								$tgl_tempo = date('Y-m-d', strtotime($tagi['tgl_tempo']));
								if($tagi['status'] < 1 && $tgl_tempo < $tgl){									
									$n++;
								}
							}
						}
						if($n == 0){
							$n = '-';
						}
				  ?>
				  </select>
                  <input type="hidden" id="del_angs" nama="del_angs" value="">
                </div>
                <div class="form-group">
                  <label>Angsuran</label><span class="label label-danger pull-right category_error"></span>
                  <input style="text-align:right;" type="text" class="form-control" readonly value="<?php echo number_format($transaksi->angs,2,',','.');?>" />
                 
                </div>
				
				 <div class="form-group">
                  <label>Total Bayar</label><span class="label label-danger pull-right category_error"></span>
                  <input style="text-align:right;" type="text" id="total" class="form-control" readonly value="0,00" />
                 
                </div>
                
				</div>
                
              </form>

              </div>
			 
             
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success yes_byr" disabled>Bayar</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="box box-success">
<div class="box-header with-border hide">
              <h3 class="box-title">No.Transaksi #<?php echo $transaksi->id_transaksi;?></h3>

		<form action="" method="post" autocomplete="off" class="pull-right" id="search_report" style="margin-top:5px; margin-right:5px;">
       
        <input type="hidden" name="id_transaksi" value="<?php echo $transaksi->id_transaksi;?>">        
        
        <button type="button" id="print" class="btn btn-xs btn-primary" style="height:27px;"><i class="glyphicon glyphicon-print"></i> Export</button>               
    </form>             
            </div>
<div class="box-body">
<?php 
if($transaksi->payment == 2 && $transaksi->status > 2){
	
	echo '<div class="tbl_history">';	
}
?>	


	<table class="table table-bordered table-reponsive">
		<tbody>
		<tr>
        	
			<td class="h_tengah" style="vertical-align:middle;">
			<table class="table table-responsive">
				<tbody>
					<tr style="vertical-align:middle; text-align:left">
						<td style="width:13%;"><b>Tanggal</b></td>						
						<td style="width:1%;">:</td>						
						<td style="width:35%;"><?php echo date('d M Y', strtotime($transaksi->create_at)).' '.$status_name[$transaksi->status];?></td>
                        <td style="width:10%;"><b>Payment</b></td>		
						<td style="width:1%;">:</td>							
						<td><?php echo $payment;?></td>		
						</td>
						
					</tr>
                    	
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Principal</b></td>		
						<td style="width:1%;">:</td>							
						<td><?php echo $transaksi->nama_principal;?></td>
						
						<td style="width:10%;">
						<?php if($transaksi->payment == 2){ ?>
						<b>No.Tagihan</b></td>		
						<td style="width:1%;">:</td>						
							<td><?php echo $transaksi->kode_payment != '' ? $transaksi->kode_payment : '-';?></td>	
						<?php } else if($transaksi->payment == 3) { ?>
							<b>No.Rekening</b></td>		
							<td style="width:1%;">:</td>						
							<td><?php echo $transaksi->no_rek != '' ? $transaksi->no_rek.' a.n <b>'.$transaksi->holder_name.'</b>' : '-';?></td>
						<?php }else{ ?>	
							<td> </td>
							<td> </td>
						<?php } ?>	
						</td>	
						
						
						
					</tr>
					
					<tr style="vertical-align:middle; text-align:left">
                    	<td><b>Member</b></td>
						<td style="width:1%;">:</td>
						<td><?php echo $transaksi->nama_member.' - '.$transaksi->phone_member;?>
						<td style="width:10%;">
						<?php if($transaksi->payment == 2){ ?>
						<b>Tgl. Tempo</b></td>		
						<td style="width:1%;">:</td>						
							<td><?php echo $transaksi->tgl_jth_tempo != null ? date('d', strtotime($transaksi->tgl_jth_tempo)) : '-';?>
						<?php } else { ?>
							<td> </td>
							<td> </td>
						<?php } ?>
						
						</td>	
												
					</tr>
					
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Email Member</b></td>
						<td style="width:1%;">:</td>
						<td><?php echo $transaksi->email_member;?>
							
						</td>	
						<td style="width:10%;">
						<?php if($transaksi->payment == 2){ ?>
						<b>Tunggakan</b></td>		
						<td style="width:1%;">:</td>						
							<td><?php echo $n;?>
						<?php } else { ?>
							<td> </td>
							<td> </td>
						<?php } ?>
						
						</td>	
					</tr>
					
					
					<tr style="vertical-align:middle; text-align:left"> 
						<td><b>Pengiriman</b></td>
						<td style="width:1%;">:</td>
						<td colspan=4><?php echo $transaksi->nama_penerima.', '.$transaksi->alamat_penerima.'-'.$transaksi->nama_city.', '.$transaksi->nama_provinsi.', '.$transaksi->kode_pos.', '.$transaksi->phone_penerima;?></td>		
														
					</tr>
					<tr style="vertical-align:middle; text-align:left"> 
						<td><b>Remark</b></td>
						<td style="width:1%;">:</td>
						<td colspan=4><?php echo $transaksi->remark;?></td>		
														
					</tr>
				</tbody>
			</table>
			</td>									
		</tr>
		
	</tbody></table>
    
	<table class="table table-bordered table-reponsive">
		<tbody><tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center; width:50%;" >Daftar Produk</th>
			
		</tr>
		
		<tr style="vertical-align:middle; text-align:left">
			<table class="table table-bordered table-reponsive">
				<thead>
					<tr>
						<td style="text-align:center; width:4%"><b>No.</b></td>
						<td style="text-align:center; width:20%"><b>Nama Produk</b></td>
									
							
						<td style="text-align:center; width:10%"><b>Harga</b></td>		
						<td style="text-align:center; width:7%"><b>Qty</b></td>		
						<td style="text-align:center; width:23%"><b>Note</b></td>		
							
						<td style="text-align:center; width:13%"><b>Subtotal</b></td>
				   
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$cnt_addon = 0;
						$ttl_disc = 0;
						$nama_option = '';
						$note_menu = '';
						$sub_ttl = '0.00';
						$addon = array();
						if(!empty($transaksi_detail)){
							foreach($transaksi_detail as $_td){								
								echo '<tr>';
								echo '<td align="center">'.$i.'.</td>';
								if((int)$_td['paket'] > 0){
									if(!empty($paket_detail)){
										echo '<td>'.$_td['nama_barang'];
										foreach($paket_detail as $pd){
											if($pd['id_paket'] == $_td['id_product']){
												echo '<br/>- '.$pd['jml'].' '.$pd['nama_barang'];
											}
										}
										echo '</td>';
									}else{
										echo '<td>'.$_td['nama_barang'].'</td>';
									}									
								}else{
									echo '<td>'.$_td['nama_barang'].'</td>';
								}				
															
								echo '<td align="right">'.number_format($_td['harga'],2,',','.').'</td>';								
								echo '<td align="center">'.$_td['jml'].'</td>';
								echo '<td align="center">'.$_td['note'].'</td>';
																
								echo '<td align="right">'.number_format($_td['total'],2,',','.').'</td>';
								echo '</tr>';
								
								$i++;
							}
													
							if($transaksi->diskon_payment > 0){						
								echo '<tr style="border:none;">';							
								echo '<td style="border:none;"></td>';
								echo '<td style="border:none;"></td>';
								echo '<td style="border:none;"></td>';
								echo '<td style="border:none;"></td>';
								echo '<td align="right" style="border:none;"><b>Diskon Payment</b></td>';							
								echo '<td align="right"><b>-'.number_format($transaksi->diskon_payment,2,',','.').'</b></td>';
								echo '</tr>';
							}
							
							
							echo '<tr style="border:none;">';
							
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td align="right" style="border:none;"><b>Total</b></td>';							
							echo '<td align="right"><b>'.number_format($transaksi->ttl_all,2,',','.').'</b></td>';
							echo '</tr>';
							
						}
					?>
				</tbody>
			</table>
		
	
			
		
		</tr>
	</tbody>
	</table>
<?php 
if($transaksi->payment == 2 && $transaksi->status != 2){	
	echo '</div>';
?>
<div class="box-footer clearfix" style="height:55px;">
	<div class="clearfix"></div>
	<div class="pull-right">
	<?php
		if($transaksi->status == 1){
			echo '<button type="button" class="btn btn-success appr" '.$disabled.'><i class="fa fa-check"></i> Approve</button>	
		<button type="button" class="btn btn-danger reject" '.$disabled.'><i class="glyphicon glyphicon-remove"></i> Reject</button>	';
		}
		if($transaksi->status > 2 && $transaksi->status_tempo < 1 && $transaksi->payment == 2){
			echo '<button type="button" class="btn btn-small btn-info byr_angs" '.$disabled.'><i class="glyphicon glyphicon-usd"></i> Bayar Tagihan</button>';
		}
	?>
			
	</div>
</div>
<?php } ?>

</div>

<?php 
if($transaksi->payment == 2 && $transaksi->status > 2){
$_span = '';
if($transaksi->status_tempo == 1){
	$_span = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-warning pull-right">Lunas</span>';
}
	echo '</div>
</div>';
echo'

<div class="col-md-4">
         
          <!-- /.box -->

          <!-- PRODUCT LIST -->
          <div class="box box-primary ">
            <div class="box-header with-border">
              <h3 class="box-title">Info Pembayaran '.$_span.'</h3>

             
            </div>
            <!-- /.box-header -->
            <div class="box-body msg_history">
              <ul class="products-list product-list-in-box">';
			 
			  if(!empty($tagihan)){
				foreach($tagihan as $_tag){
					echo '<li class="item" >
                  <div class="product-img">
                    <strong>Tagihan ke '.$_tag['angs_ke'].'</strong>
                  </div>
                  <div class="product-info">
                    Jatuh Tempo : '.date('d M Y', strtotime($_tag['tgl_tempo']));
					$span = '';
					if($_tag['status'] == 1){
						$span = '<span class="label label-success pull-right">Lunas</span>';
						echo '<br/><span class="product-description">
                        Tgl. Bayar : '.$_tag['status_date'].' 
                    </span>';
					}
					$tgl_tempo = '';
					$month_tempo = '';
					$tgl_tempo = date('Y-m-d', strtotime($_tag['tgl_tempo']));
					$month_tempo = date('Y-m', strtotime($_tag['tgl_tempo']));
					if($_tag['status'] < 1 && $month_tempo == $month){						
						$span = '<span class="label label-info pull-right">On process</span>';
					}
					if($_tag['status'] < 1 && $tgl_tempo < $tgl){						
						$span = '<span class="label label-danger pull-right">Tunggakan</span>';
					}
					
					echo $span;
                      
                  echo '</div>
                </li>';
				}
			  }
                
                
              echo '</ul>
            </div>
            <!-- /.box-body -->
            
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>

</div>';
} ?>

<script>
$('.btn_back').click(function(){
	window.location = '<?php echo $url;?>';
});
var id_transaksi = '<?php echo $this->converter->encode($transaksi->id_transaksi);?>';
$("#print").click(function(){	
	var url = '<?php echo site_url('transaksi/export_r2');?>';
	$('#search_report').attr('action', url);
	$('#search_report').submit();
});
$('.appr').click(function(){
	var val = id_transaksi;
	$('#del_id').val(val);
	$('#nilai').val(3);
	$('.text_warning').html('Apakah anda yakin ?');	
	$('.text_warning').html('Apakah anda yakin untuk <br><strong> memproses</strong> transaksi ini ? ');
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});

$('.reject').click(function(){
	var val = id_transaksi;
	$('#del_id').val(val);
	$('#nilai').val(2);
	$('.text_warning').html('Apakah anda yakin ?');	
	$('.text_warning').html('Apakah anda yakin untuk <strong> menolak</strong> transaksi ini ? ');
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});

$('.yes_app').click(function(){
	var id = $('#del_id').val();
	var nilai = $('#nilai').val();
	var url = '<?php echo site_url('transaksi/upd_status');?>';
	var status = '';
	$.ajax({
		data : {id : id, nilai : nilai},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			if(nilai == 3){
				status = 'approve';
			}
			if(nilai == 2){
				status = 'reject';
			}
			location.reload();		
		}
	});
	
});

$('.byr_angs').click(function(){
	$('#total').val('0,00');
	$('#jml_angs').val('');
	$('.yes_byr').prop('disabled', true);
	var val = id_transaksi;
	$('#del_angs').val(val);	
	$('.text_warning').html('Apakah anda yakin ?');	
	$('.text_warning').html('Apakah anda yakin untuk <strong> menolak</strong> transaksi ini ? ');
	$('#confirm_ang').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_ang").modal('show');
});
$('#jml_angs').change(function(){
	$('#total').val('0,00');
	var val = $(this).val();
	var angs = '<?php echo $transaksi->angs;?>';
	var ttl = Number(val) * Number(angs);
	$('.yes_byr').prop('disabled', true);
	if(val > 0){
		$('.yes_byr').prop('disabled', false);
		$('#total').val(numberWithCommas(ttl)+',00');
	}	
});
$('.yes_byr').click(function(){
	$('.yes_byr').prop('disabled', true);
	var id = $('#del_angs').val();
	var nilai = $('#jml_angs').val();
	var url = '<?php echo site_url('transaksi/byr_angs');?>';
	var status = '';
	$.ajax({
		data : {id : id, nilai : nilai},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');			
			location.reload();		
			$('.yes_byr').prop('disabled', false);
		}
	});
});
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
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
$_disabled = '';
if($_LEVEL == 1){
	// $_disabled = ' hide';
}
?>

<div class="modal fade" role="dialog" id="confirm_del">
          <div class="modal-dialog" style="width:370px">
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



 <div class="box box-success">
 
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">

    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
<form action="" method="post" autocomplete="off" class="pull-right" id="search_report">
        <label>Search From</label>
        <input type="text" name="froms" value="<?php echo $froms;?>" class="datepicker" required id="froms">
        <label>To</label>
        <input type="text" name="to" value="<?php echo $to;?>" class="datepicker" required id="to">
        <input type="hidden" name="status" value="<?php echo $status;?>">
        <input type="hidden" name="payment" value="<?php echo $payment;?>">
        <button type="submit" class="btn btn-xs btn-success" style="height:27px;"><i class="glyphicon glyphicon-search"></i> Search</button>
		<button type="button" class="btn btn-xs btn-danger res" style="height:27px;"><i class="glyphicon glyphicon-refresh"></i> Reset</button>
        <button type="button" id="print" class="btn btn-xs btn-primary" style="height:27px;"><i class="glyphicon glyphicon-print"></i> Export</button>               
    </form>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:9%">Date</th>
                       
            <th style="text-align:center; width:17%">Principal</th>	
            <th style="text-align:center; width:20%">Member</th>		
            <th style="text-align:center; width:23%">Transaction</th>		
			<th style="text-align:center; width:8%">Action</th> 
           
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;				
				$info = '';			
				$payment = '';			
				$_status = '-';			
				$_action = '-';	
				$_ttl = 0;
				if(!empty($transaksi)){		
					foreach($transaksi as $t){						
						$payment = '';
						$_action = '';
						$_status = '-';
						$_ttl += $t['ttl_all'];
						$payment = '<strong>'.$t['payment_name'].' '.$t['nama_bank'].'</strong>';
						if($t['payment'] == 2){
							$payment = '<strong>'.$t['payment_name'].' '.$t['tempo'].' x '.number_format($t['angs'],2,',','.').'</strong>';
						}
						
						$info = $this->converter->encode($t['id_transaksi']);
						// if($t['status'] == 0){
							// $_status = '<small class="label label-info"><strong>Order</strong></small>';
						// }
						if($t['status'] == 0 && ($t['payment'] == 2 || $t['payment'] == 3)){
							$_status = '<small class="label label-warning"><strong>Waiting approval</strong></small>';							
						}
						if($t['status'] == 0 && $t['payment'] == 1){
							$_status = '<small class="label label-warning"><strong>Waiting payment</strong></small>';							
						}
						if($t['status'] == 3 && ($t['payment'] == 2 || $t['payment'] == 3)){
							$_status = '<small class="label label-info"><strong>Approved</strong></small>';							
						}
						if($t['status'] == 3 && $t['payment'] == 1){
							$_status = '<small class="label label-info"><strong>Payment complete</strong></small>';							
						}
						if($t['status'] == 4){
							$_status = '<small class="label label-success"><strong>Dikirim</strong></small>';							
						}
						if($t['status'] == 5){
							$_status = '<small class="label label-default"><strong>Sampai tujuan</strong></small>';							
						}
						if($t['status'] == 6){
							$_status = '<small class="label label-default"><strong>Pesanan selesai</strong></small>';							
						}
						if($t['status'] == 2){
							$_status = '<small class="label label-danger"><strong>Rejected</strong></small>';
						}
						$_action .= '<a href="'.site_url('transaksi/detail/'.$info).'"><button style="margin-top : 5px; width:69px;" title="View" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> View</button></a>';
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';						
						echo '<td>'.date("d M Y H:i", strtotime($t['create_at'])).'<br/>'.$_status.'</td>';
						echo '<td>'.$t['nama_principal'].'<br/> Email : '.$t['email_principle'].'</td>';						
						echo '<td>'.$t['nama_member'].' - '.$t['phone_member'].'<br/> Email : '.$t['email_member'].'</td>';	
						if($t['status'] == 3 && $t['payment'] == 2){
							echo '<td>No.Tagihan : '.$t['kode_payment'].'<br/>Payment : '.$payment.'<br/> Tgl.Tempo : '.date("d", strtotime($t['tgl_jth_tempo'])).'<br/>Total : '.number_format($t['ttl_all'],2,',','.').'</td>';
						}else{
							echo '<td>Payment : '.$payment.'<br/>Total : '.number_format($t['ttl_all'],2,',','.').'</td>';
						}
						
						echo '<td align="center">'.$_action.'</td>';						
						echo '</tr>';
					}
				}
			?>
		</tbody>
		<tfoot align="right">
		<tr><th colspan=6 style="font-size:15px"> Total : <?php echo number_format($_ttl,2,',','.');?></th></tr>
	</tfoot>
	</table>
</div>

</div>
<link href="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>


<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 
var date_now = '<?php echo date('d/m/Y');?>';

$('.res').click(function(){
	window.location.href = '<?php echo $url_report;?>';
});
$("#print").click(function(){	
	var url = '<?php echo site_url('reporting/export_r');?>';
	$('#search_report').attr('action', url);
	$('#search_report').submit();
	$('#search_report').attr('action', '');
	// setTimeout (submit2, 2000);
});
// function submit2(){
	// var url = '<?php echo site_url('transaksi/export_r2');?>';
	// $('#search_report').attr('action', url);
	// $('#search_report').submit();
	
// }
$('.btn_send').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#nilai').val(4);
	$('.text_warning').html('Apakah anda yakin ?');	
	$('.text_warning').html('Apakah anda yakin untuk <br><strong> mengirirm</strong> paket pada transaksi ini ? ');
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});

$('#froms').datetimepicker({
	dayOfWeekStart : 1,
	changeYear: false,
	timepicker:false,
	scrollInput:false,
	format:'d-m-Y',
	lang:'en',
		
	onChangeDateTime: function (fom) {
		$("#to").datetimepicker({
            minDate: fom
		});       
	}
});
$('#to').datetimepicker({
	dayOfWeekStart : 1,
	changeYear: false,
	timepicker:false,
	scrollInput:false,
	format:'d-m-Y',
	lang:'en',
	
	maxDate:date_now,	
	onChangeDateTime: function (to) {
		$("#forms").datetimepicker({
            maxDate: to
		});
       
	}
       
});

$(function() {               
    $('#example88').dataTable({bFilter : false});
});


</script>
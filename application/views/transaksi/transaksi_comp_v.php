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

?>

<div class="modal fade" role="dialog" id="confirm_del">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
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
<form action="" method="post" autocomplete="off" class="pull-right" id="search_report">
        <label>Search From</label>
        <input type="text" name="froms" value="<?php echo $froms;?>" class="datepicker" required id="froms">
        <label>To</label>
        <input type="text" name="to" value="<?php echo $to;?>" class="datepicker" required id="to">
        <input type="hidden" name="status" value="<?php echo $status;?>">
        <button type="submit" class="btn btn-xs btn-success" style="height:27px;"><i class="glyphicon glyphicon-search"></i> Search</button>
		<button type="button" class="btn btn-xs btn-danger res" style="height:27px;"><i class="glyphicon glyphicon-refresh"></i> Reset</button>
        <button type="button" id="print" class="btn btn-xs btn-primary" style="height:27px;"><i class="glyphicon glyphicon-print"></i> Print</button>               
    </form>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:15%">No. Reservasi</th>
            <th style="text-align:center; width:15%">Date & Time</th>            
            <th style="text-align:center; width:20%">Nama Merchant</th>	
            <th style="text-align:center; width:15%">Nama Member</th>		
            <th style="text-align:center; width:10%">Total</th>		
            <th style="text-align:center; width:10%">Action</th>		
			
           
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$info = '';			
				if(!empty($transaksi)){		
					foreach($transaksi as $t){	
						$view_sub = '';
						$info = $t['id_transaksi'];
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';						
						echo '<td><a href="'.site_url('transaksi/detail/'.$t['id_transaksi']).'">'.$t['kode_booking'].'</a></td>';
						echo '<td>'.date("d M Y", strtotime($t['tanggal'])).', '.date('H:i', strtotime($t['jam'])).'</td>';						
						echo '<td>'.$t['nama_merchants'].'</td>';
						echo '<td>'.$t['nama'].'</td>';
						echo '<td align="right">'.number_format($t['total'],2,',','.').'</td>';		
						echo '<td align="center" style="vertical-align: middle;">		
			
			<a href="'.site_url('transaksi/complain_detail/'.$info).'" title="View Complain" class="edit_news"><button class="btn btn-xs btn-warning"><i class="fa fa-eye"></i> View Complain</button></a>
				
						</td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
</div>

</div>
<link href="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap-toggle/js/bootstrap-toggle.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>


<script type="text/javascript">
//$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 
var date_now = '<?php echo date('d/m/Y');?>';
$('.res').click(function(){
	window.location.href = '<?php echo $url_report;?>';
});
$("#print").click(function(){	
	var url = '<?php echo site_url('transaksi/export_r2');?>';
	$('#search_report').attr('action', url);
	$('#search_report').submit();
});

$('.appr').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#nilai').val(2);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});

$('.reject').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#nilai').val(3);
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
			if(nilai == 2){
				status = 'approve';
			}
			if(nilai == 3){
				status = 'reject';
			}
			$("#id_text").html('<b>Success,</b> Data telah di '+status);
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
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
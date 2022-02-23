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
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
            <th style="text-align:center; width:15%">Date & Time</th>
           
            <th style="text-align:center; width:15%">Nama Member</th>			
			<th style="text-align:center; width:15%">Jumlah Orang (Point)</th>	
            <th style="text-align:center; width:15%">Promo Code</th>
           	<th style="text-align:center; width:10%">Status</th>	
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$status = '';
				$info = '';			
				if(!empty($transaksi)){		
					foreach($transaksi as $t){	
						$status = '';
						$info = $t['id_transaksi'];
						if($t['status'] == 1){
							$status = '<span class="label label-primary">Request</span>';
						}
						if($t['status'] == 2){
							$status = '<span class="label label-success">Approve</span>';
						}
						if($t['status'] == 3){
							$status = '<span class="label label-danger">Reject</span>';
						}
						if($t['status'] == 3){
							$status = '<span class="label label-info">Complete</span>';
						}
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.date("d M Y", strtotime($t['tanggal'])).', '.date('H:i', strtotime($t['jam'])).'</td>';
						echo '<td>'.$t['nama'].'</td>';
						
						echo '<td align="center">'.$t['jml_org'].' Orang ('.$t['jml_org'] * $t['point'].' pts)</td>';
						echo '<td>'.$t['promo_code'].'</td>';
						//$view_sub = site_url('category/subcategory/'.$c['id_kategori']);
						echo '<td align="center">'.$status.'</td>';				
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
</div>

</div>
<script src="<?php echo base_url(); ?>assets/bootstrap-toggle/js/bootstrap-toggle.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>


<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 

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


$(function() {               
    $('#example88').dataTable({});
});


</script>
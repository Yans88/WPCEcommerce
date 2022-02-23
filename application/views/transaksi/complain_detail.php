<style type="text/css">
	.container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 35%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:30%;}
.srch_bar {
  display: inline-block;
  
  width: 90%; padding:
}
.headind_srch{ padding:10px 0px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:100%; padding:2px 0 4px 6px;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
  height: 20%;
  
  border: 1px solid #c4c4c4;
}
.chat_ib {
  float: left;
  padding: 0 0 0 0px;
  width: 100%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
  cursor: pointer;
}
.inbox_chat { height: 380px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 30px 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 53%;}
.mesgs {
  float: left;
  padding: 35px 15px 0 33px;
  width: 60%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 40%;
  margin-right:25px;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding-left: 4px;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 0px 0;}
.msg_history {
  height: 390px;
  overflow-y: auto;
}
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
				<h4 class="text-center" id="msg_comp"></h4>
				<input type="hidden" id="del_id" value="">
				<input type="hidden" id="status" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del">Yes</button>               
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
	<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
			
            <div class="srch_bar">
              <div class="stylish-input-group">
                <h4><strong>Kode Booking : <a href="<?php echo site_url('transaksi/detail/'.$transaksi->id_transaksi);?>"><?php echo $transaksi->kode_booking;?></a></strong></h4>
				<p><h6>Tanggal Transaksi : <?php echo date('l, d/m/Y', strtotime($transaksi->tanggal)).' '.date('H:i', strtotime($transaksi->jam));?></h6></p>
				<p><h6>Tanggal Komplain : <?php echo date('l, d/m/Y H:i', strtotime($transaksi->created_at));?></h6></p>
				
                </div>
            </div>
            
          </div>
          <div class="inbox_chat">
            <div class="chat_list active_chat">
              <div class="chat_people">
                
                <div class="chat_ib">
                  <h5>Merchant : <?php echo $transaksi->nama_merchants;?></h5>
                  <p>Contact : <?php echo $transaksi->contact_us;?> </p>
                  
                </div>
				
              </div>
			  
            </div>
			
			<div class="chat_list">
              <div class="chat_people">
                
                <div class="chat_ib">
                  <h5>Member : <?php echo $transaksi->nama_member;?> </h5>
                  <p>Contact : <?php echo $transaksi->no_telp;?> </p>
                  
                </div>
				
              </div>
			  
            </div>
			
			<div class="chat_list active_chat">
              <div class="chat_people">
                
                <div class="chat_ib">
                  <h5>Total : <?php echo number_format($transaksi->total,2,',','.');?> </h5>
                  <p>Jumlah Pax : <?php echo $transaksi->jml_org;?>  </p>
                </div>
				
              </div>
			  
            </div>
			
			
			
			
			
			<div class="chat_list">
              <div class="chat_people">
                
                <div class="chat_ib">
                  <h5>Reason : <?php echo $transaksi->reason;?> </h5>
                  <p>Note : <?php echo $transaksi->note_complain;?> </p>
                </div>
				
              </div>
			  
            </div>
			<?php if($transaksi->status_comp == 1) { ?>
			<div class="chat_list active_chat">
              <div class="chat_people">
                
                <div class="chat_ib">
					<h5><strong>Pilih Solusi : </strong></h5>
					<h5><input type="radio" name="solusi" value=1> Dana di kembalikan ke pelanggan </h5>
					<h5><input type="radio" name="solusi" value=2> Dana di teruskan ke merchant </h5>
					<button type="button" class="btn btn-danger" id="close_comp"><i class="glyphicon glyphicon-exclamation-sign"></i> Close Complain </button>
                </div>
				
              </div>
			  
            </div>
            <?php } ?>
			
			<?php 
			$disabled = '';
			if($transaksi->status_comp == 2) { 
				$disabled = 'disabled';
			?>
			<div class="chat_list active_chat">
              <div class="chat_people">
                
                <div class="chat_ib">
					<h5><strong>Solusi : <?php echo $transaksi->solusi;?></strong></h5>
					<p>Date : <?php echo date('l, d/m/Y H:i', strtotime($transaksi->status_date));?> </p>
                </div>
				
              </div>
			  
            </div>
            <?php } ?>
            
          </div>
		  
        </div>
        <div class="mesgs">
          <div class="msg_history">
           
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" id="message" class="write_msg" placeholder="Type a message" <?php echo $disabled;?>  />
              <button id="send_msg" class="msg_send_btn" type="button" <?php echo $disabled;?> ><i class="glyphicon glyphicon-send" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>
      
      
      
      
    </div></div>
</div>

</div>


<script type="text/javascript">

$("#success-alert").hide();
$('#close_comp').click(function(){
	var id_transaksi = '<?php echo $id_transaksi;?>';
	var msg =  '';
	$('#msg_comp').text('');
	if ($("input[name='solusi']").is(":checked")) {
		var total = '<?php echo number_format($transaksi->total,0,',','.');?> ';
		var status_comp = $("input[name='solusi']:checked").val();
		if(status_comp == 1){
			msg = 'Apakah anda yakin menutup complain ini dengan pengembalian dana sebesar Rp.'+total+'ke Member';
		}
		if(status_comp == 2){
			msg = 'Apakah anda yakin menutup complain ini dengan meneruskan dana sebesar Rp.'+total+'ke Merchant';
		}
		
		$('#del_id').val(id_transaksi);
		$('#status').val(status_comp);
		$('#msg_comp').text(msg);
		$('#confirm_del').modal({
			backdrop: 'static',
			keyboard: false
		});
		$("#confirm_del").modal('show');
	}else{
		alert('Silahkan pilih solusi komplain');
		return false;
	}
});
$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var status = $('#status').val();
	var url = '<?php echo site_url('transaksi/close_comp');?>';
	$.ajax({
		data : {id : id,status:status},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Complain sudah ditutup');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});
load_chat();
function load_chat(){
	var id_transaksi = '<?php echo $id_transaksi;?>';
	
	if(id_transaksi > 0){
		var url = '<?php echo site_url('transaksi/get_chat');?>';
		$.ajax({
			data : {id_transaksi : id_transaksi},
			url : url,
			type : "POST",
			// beforeSend  : function(){ $('#container-loader-list').show(); },
			success:function(response){			    
				if(response != ''){					
					var obj = jQuery.parseJSON(response);
					var obj_length = obj.length;
					var chat_length = $('#chat_length').val();
					if(obj_length != chat_length){
						$('.msg_history').text('');
						for(var i in obj){							
							$(".msg_history").append(obj[i]);
						}
						$('#chat_length').val(obj_length);
					}
									
				}						
			}
		});	
	}	
  
}


$('#send_msg').click(function(){
	
	var message = $('#message').val();
	
	if(message == '' || message <= 0){
		alert('Silahkan isi pesan yang mau dikirim');
		return false;
	}
	var url = '<?php echo site_url('transaksi/chat_komplain');?>';
	$.ajax({
		data : {id_transaksi : '<?php echo $id_transaksi;?>', content:message},
		url : url,
		type : "POST",
		// beforeSend  : function(){ $('#container-loader-list').show(); },
		success:function(response){
			if(response > 0){
				$('#message').val('');
				load_chat();
			}				
		}
	});			
});


// setInterval(function(){load_data(1)}, 2000);
setInterval(function(){load_chat()}, 2000);
</script>
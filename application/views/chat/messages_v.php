<style type="text/css">
	.container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 30%; border-right:1px solid #c4c4c4;
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
  text-align: right;
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
.chat_ibs h5{ font-size:15px; color:#464646; margin:0 0 8px 0; font-weight:bold;}
.chat_ibs h5 span{ font-size:13px; float:right;}
.chat_ibs p{ font-size:14px; color:#464646; margin:auto; font-weight:bold;}
.chat_img {
  float: left;
  width: 11%;
  height: 20%;
  
  border: 1px solid #c4c4c4;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 92%;
}

.chat_ibs {
  float: left;
  padding: 0 0 0 15px;
  width: 92%;
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
  padding: 0 0 0 10px;
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
  padding: 30px 15px 0 33px;
  width: 65%;
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
  height: 370px;
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
                <input type="text" class="form-control" id="search_member"  placeholder="Cari Member" >
				<input type="hidden" id="id_member" value=0 />
				<input type="hidden" id="chat_length" value=0 />
                 </div>
            </div>
            
          </div>
          <div class="inbox_chat">
            <!--<div class="chat_list active_chat">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div> -->
            
            
          </div>
        </div>
        <div class="mesgs">
          <div class="msg_history">
           
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" id="message" class="write_msg" placeholder="Type a message" />
              <button id="send_msg" class="msg_send_btn" type="button"><i class="glyphicon glyphicon-send" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>
      
      
      
      
    </div></div>
</div>

</div>


<script type="text/javascript">

$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 

$('#search_member').keyup(function(){
	var val = $(this).val();
	load_data(0, val);
});
load_data(0);
function load_data(cnt,search=''){		
	var html = '';	
	
	var url = '<?php echo site_url('chat/get_list_chat');?>';
	$.ajax({
		data : {search_member : search},
		url : url,
		type : "POST",
		// beforeSend  : function(){ $('#container-loader-list').show(); },
		success:function(response){
			
			if(response != '' && cnt == 0){
				$(".inbox_chat").html('');	
				var obj = jQuery.parseJSON(response);
				for(var i in obj){
					$(".inbox_chat").append(obj[i]);
				}				
			}						
		}
	});	
}

$(document).on('click', '.chat_list', function(e){
	e.preventDefault();
	$('#id_member').val($(this).get(0).id);
	var id_member = $('#id_member').val();
	$('.box-title').text('');		
	$('.chat_list').removeClass("active_chat");
	$('#'+id_member).addClass("active_chat");
	$('#chat_ibs_'+id_member).removeClass("chat_ibs");
	$('#chat_ibs_'+id_member).addClass("chat_ib");
	if(id_member > 0){
		load_chat();
		$('#message').val('');
		var name = $(this).text();
		$('.box-title').text(name);	
	}
		
})
function load_chat(){
	var id_member = $('#id_member').val();
	
	if(id_member > 0){
		var url = '<?php echo site_url('chat/get_chat');?>';
		$.ajax({
			data : {id_member : id_member},
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
	var id_member = $('#id_member').val();
	var message = $('#message').val();
	if(id_member == '' || id_member <= 0){
		alert('Silahkan pilih member yang mau dichat');
		return false;
	}
	if(message == '' || message <= 0){
		alert('Silahkan isi pesan yang mau dikirim');
		return false;
	}
	var url = '<?php echo site_url('chat/send_chat');?>';
	$.ajax({
		data : {id_member : id_member, message:message},
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


setInterval(function(){load_data(0)}, 2000);
setInterval(function(){load_chat()}, 2000);
</script>
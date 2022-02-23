<!-- search form -->
<a href="<?php echo site_url();?>" class="logo">
			<!-- Add the class icon to your logo image or logo icon to add the margining -->
			 <div style="text-align:center; color:#01DF3A; font-weight:600;">Selamat Datang Dihalaman Administrator GTS</div>
		</a>
<!-- /.search form -->

<ul class="sidebar-menu">
<li class="<?php 
	 $menu_home_arr= array('home', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>home">
			<img height="20" src="<?php echo base_url().'assets/theme_admin/img/home.png'; ?>"> <span>Beranda</span>
		</a>
</li>

<?php if($_PRINCIPAL == 1){ ?>

<li class="<?php 
	 $menu_home_arr= array('merchants', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr) && $this->uri->segment(2) != 'list_machine') {echo "active";}?>">
		<a href="<?php echo base_url(); ?>merchants">
			<i class="glyphicon glyphicon-stats"></i> <span>Principal</span>
		</a>
</li>
<?php } if($_CATEGORY == 1) { ?>
<li class="<?php 
	 $menu_home_arr= array('category', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>category">
			<i class="glyphicon glyphicon-stats"></i> <span>Category</span>
		</a>
</li>
<?php } if($_PRODUCT == 1) { ?>
<li class="<?php 
	 $menu_home_arr= array('product', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>product">
			<i class="glyphicon glyphicon-stats"></i> <span>Product</span>
		</a>
</li>
<?php } if($_PACKET == 1) { ?>
<li class="<?php 
	 $menu_home_arr= array('paket', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>paket">
			<i class="glyphicon glyphicon-stats"></i> <span>Packet</span>
		</a>
</li>
<?php } if($_MEMBERS == 1) { ?>
<li class="<?php 
	 $menu_home_arr= array('members', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>members">
			<i class="glyphicon glyphicon-stats"></i> <span>Members</span>
		</a>
</li>
<?php } if($_CHAT == 1) { ?>
<li class="<?php 
	 $menu_home_arr= array('chat', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>chat">
			<i class="glyphicon glyphicon-stats"></i> <span>Chat</span>
			<span class="pull-right-container">
              <small class="label pull-right label-danger menu_msg" style="font-weight:700; font-size:90%;">12</small>
              
            </span>
		</a>
</li>
<li class="<?php 
	 $menu_home_arr= array('blast_notif', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>blast_notif">
			<i class="glyphicon glyphicon-stats"></i> <span>Blast Notification</span>
		</a>
</li>
<?php } if($_WP == 1 || $_PC == 1 || $_DIKIRIM == 1 || $_ST == 1 || $_COMPLETE == 1 || $_REJECT == 1) {?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('transaksi','');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Transaction</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	
	  
	<li class="hide <?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'cash'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/cash"><i class="fa fa-folder-open-o"></i> Cash</a></li>    
	<li class="hide <?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'tempo'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/tempo"><i class="fa fa-folder-open-o"></i> Tempo</a></li>    
	<?php if($_WP == 1) { ?>    
	<li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'payment'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/payment"><i class="fa fa-folder-open-o"></i> Waiting Payment/Approve</a></li>    
	<?php } if($_PC == 1) { ?>
    <li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'appr'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/appr"><i class="fa fa-folder-open-o"></i> Payment Complete/Approve</a></li> 
	<?php } if($_DIKIRIM == 1) { ?>
    <li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'in_progress'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/in_progress"><i class="fa fa-folder-open-o"></i> Dikirim </a></li>
	<?php } if($_ST == 1) { ?>
    <li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'sampai'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/sampai"><i class="fa fa-folder-open-o"></i> Sampai tujuan </a></li>    
   <?php } if($_COMPLETE == 1) { ?>
	<li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'complete'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/complete"><i class="fa fa-folder-open-o"></i> Complete </a></li>
	<?php } if($_REJECT == 1) { ?>
	 <li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'reject'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/reject"><i class="fa fa-folder-open-o"></i> Reject </a></li>
	 <?php } ?>
	<li class="hide <?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'complain'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/complain"><i class="fa fa-folder-open-o"></i> Complain </a></li>
	
    
	</ul>
</li>
<?php } if($_TAGIHAN == 1 || $_ANGS == 1) { ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('tagihan','');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Tempo Payment</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	
	<?php if($_TAGIHAN == 1) { ?>     
	<li class="<?php if ($this->uri->segment(1) == 'tagihan' && $this->uri->segment(2) == ''){ echo 'active'; } ?>"><a href="<?php echo base_url();?>tagihan"><i class="fa fa-folder-open-o"></i> Tagihan</a></li>    
	<?php } if($_ANGS == 1) { ?>     
	<li class="<?php if ($this->uri->segment(1) == 'tagihan' && $this->uri->segment(2) == 'angs'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>tagihan/angs"><i class="fa fa-folder-open-o"></i> Angsuran</a></li>    
	<?php } ?>
	    
	</ul>
</li>
<?php } if($_REPORTING == 1) {?>
<li class="<?php 
	 $menu_home_arr= array('reporting', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>reporting">
			<i class="glyphicon glyphicon-stats"></i> <span>Reporting</span>
		</a>
</li>
<?php } if($_MB == 1 || $_TP == 1 || $_BANNER == 1 || $_AREA == 1 || $_BRAND == 1 || $_TIER == 1 || $_PROVINCE == 1 || $_LR == 1 || $_USERS == 1 || $_SETTING == 1){ ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('setting','user','role','faq','banner','role','payment_tempo','province','brand','area','master_bank','tier','warehouse','sales');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/data.png'; ?>">
		<span>Master Data</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	<?php if($_MB == 1) {?>
	<li class="<?php if ($this->uri->segment(1) == 'master_bank'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>master_bank"><i class="fa fa-folder-open-o"></i> Master Bank </a></li>
	<?php } if($_TP == 1) {?>
	<li class="<?php if ($this->uri->segment(1) == 'payment_tempo'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>payment_tempo"><i class="fa fa-folder-open-o"></i> Tempo Payment </a></li>
	<?php } if($_BANNER == 1) {?>
	<li class="<?php if ($this->uri->segment(1) == 'banner'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>banner"><i class="fa fa-folder-open-o"></i> Banner </a></li>
	<?php } if($_AREA == 1) {?>
	<li class="<?php if ($this->uri->segment(1) == 'sales'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>sales"><i class="fa fa-folder-open-o"></i> Sales </a></li>
	<li class="<?php if ($this->uri->segment(1) == 'warehouse'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>warehouse"><i class="fa fa-folder-open-o"></i> Warehouse </a></li>
	<li class="<?php if ($this->uri->segment(1) == 'area'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>area"><i class="fa fa-folder-open-o"></i> Area </a></li>
	<?php } if($_BRAND == 1) {?>
	<li class="<?php if ($this->uri->segment(1) == 'brand'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>brand"><i class="fa fa-folder-open-o"></i> Brand </a></li>
	<?php } if($_TIER == 1) {?>
	<li class="<?php if ($this->uri->segment(1) == 'tier'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>tier"><i class="fa fa-folder-open-o"></i> Tier </a></li>
	<?php } if($_PROVINCE == 1) {?>
	<li class="<?php if ($this->uri->segment(1) == 'province'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>province"><i class="fa fa-folder-open-o"></i> Province </a></li>	
	<?php } if($_LR == 1) {?>	
	<li class="<?php if ($this->uri->segment(1) == 'role'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>role"><i class="fa fa-folder-open-o"></i> Level & Role </a></li>
	<?php } if($_USERS == 1) {?>	
	<li class="<?php if ($this->uri->segment(1) == 'user'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>user"><i class="fa fa-folder-open-o"></i> Users </a></li>
	<?php } if($_SETTING == 1) {?>	
	<li class="<?php if ($this->uri->segment(1) == 'setting'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>setting"><i class="fa fa-folder-open-o"></i> Setting </a></li>
	<?php } ?>	
	</ul>
</li>
<?php } ?>

</ul>
<input type="hidden" value="" id="cnt_menu_chat" />
<script>
$('.menu_msg').text('');
$('#cnt_menu_chat').val(0);
load_cnt_chat();
function load_cnt_chat(){		
	var cnt_menu_chat =$('#cnt_menu_chat').val();	
	var url = '<?php echo site_url('chat/count_chat');?>';
	$.ajax({
		data : '',
		url : url,
		type : "POST",
		// beforeSend  : function(){ $('#container-loader-list').show(); },
		success:function(response){
			
			if(cnt_menu_chat != response){
				$('.menu_msg').text(response);
				$('#cnt_menu_chat').val(response);
				if(response <= 0){
					$('.menu_msg').text('');
				}
			}				
		}
	});	
}
setInterval(function(){load_cnt_chat()}, 2000);
</script>
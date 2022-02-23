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
	.custom-file-input::-webkit-file-upload-button {
		visibility: hidden;
	}
	.custom-file-input::before {
	  content: 'Select Photo';
	  display: inline-block;
	  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
	  border: 1px solid #999;
	  border-radius: 3px;
	  padding: 1px 4px;
	  outline: none;
	  white-space: nowrap;
	  -webkit-user-select: none;
	  cursor: pointer;
	  text-shadow: 1px 1px #fff;
	  font-weight: 700;  
	}
	.custom-file-input:hover::before {	 
	  color: #d3394c;
	}

	.custom-file-input:active::before {
	  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
	  color: #d3394c;
	}

</style>
<?php
$tanggal = date('Y-m');

	
$id_level = isset($level->id) ? $level->id : '';
$level_name = isset($level->level_name) ? $level->level_name : '';
$principal = isset($level->principal) && $level->principal > 0 ? 'checked' : '';
$category	 = isset($level->category	) && $level->category	 > 0 ? 'checked' : '';
$product = isset($level->product) && $level->product > 0 ? 'checked' : '';
$paket = isset($level->paket) && $level->paket > 0 ? 'checked' : '';
$members = isset($level->members) && $level->members > 0 ? 'checked' : '';
$chat = isset($level->chat) && $level->chat > 0 ? 'checked' : '';
$waiting_payment = isset($level->waiting_payment) && $level->waiting_payment > 0 ? 'checked' : '';
$payment_complete = isset($level->payment_complete) && $level->payment_complete > 0 ? 'checked' : '';
$dikirim = isset($level->dikirim) && $level->dikirim > 0 ? 'checked' : '';
$sampai_tujuan = isset($level->sampai_tujuan) && $level->sampai_tujuan > 0 ? 'checked' : '';
$complete = isset($level->complete) && $level->complete > 0 ? 'checked' : '';
$reject = isset($level->reject) && $level->reject > 0 ? 'checked' : '';
$tagihan = isset($level->tagihan) && $level->tagihan > 0 ? 'checked' : '';
$angsuran = isset($level->angsuran) && $level->angsuran > 0 ? 'checked' : '';
$reporting = isset($level->reporting) && $level->reporting > 0 ? 'checked' : '';
$master_bank = isset($level->master_bank) && $level->master_bank > 0 ? 'checked' : '';
$tempo_payment = isset($level->tempo_payment) && $level->tempo_payment > 0 ? 'checked' : '';
$banner = isset($level->banner) && $level->banner > 0 ? 'checked' : '';
$area = isset($level->area) && $level->area > 0 ? 'checked' : '';
$brand = isset($level->brand) && $level->brand > 0 ? 'checked' : '';
$tier = isset($level->tier) && $level->tier > 0 ? 'checked' : '';
$province = isset($level->province) && $level->province > 0 ? 'checked' : '';
$level_role = isset($level->level_role) && $level->level_role > 0 ? 'checked' : '';
$users = isset($level->users) && $level->users > 0 ? 'checked' : '';
$setting = isset($level->setting) && $level->setting > 0 ? 'checked' : '';

?>

<div class="box box-success">

<div class="box-body">	
<form name="frm_editrole" id="frm_editrole"  method="post">
	<table  class="table table-bordered table-reponsive">	
		<tr class="header_kolom">
			<th style="vertical-align: middle; text-align:left">Level</th>			
		</tr>
		<tr style="border:none;">			
			<td class="h_tengah" style="vertical-align:middle; border:none;">		
				<table class="table table-responsive">
					<tr style="vertical-align:middle; border:none;">
						<td style="border:none;" width="10%"><b> Level Name </td>
						<td style="border:none;" width="2%">:</td>
						<td style="border:none;">
						<input name="level_name" value="<?php echo $level_name;?>" type="text" style="width:100%; height:24px; padding-left: 5px;"/>
						</td>
						<input name="id_level" value="<?php echo $id_level;?>" type="hidden" style="width:100%; height:24px;"/>
					</tr>
				</table>
			</td>			
		</tr>	
	</table>
	
	<table  class="table table-bordered table-reponsive">	
		<tr class="header_kolom">
			<th style="vertical-align: middle; text-align:left" colspan=2>Role(Hak akses management)</th>			
		</tr>
		<tr style="border-top:none;">			
			<td class="h_tengah" style="vertical-align:middle; border-top:none; width:50%;">		
				<table class="table table-responsive">
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;" width="40%"><b>Principal</b></td>					
						<td style="border-top:none;">
							<input name="principal" <?php echo $principal;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Category</b></td>				
						<td style="border-top:none;">
							<input name="category" <?php echo $category;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Product</b></td>				
						<td style="border-top:none;">
							<input name="product" <?php echo $product;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Packet</b></td>				
						<td style="border-top:none;">
							<input name="paket" <?php echo $paket;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Members</b></td>				
						<td style="border-top:none;">
							<input name="members" <?php echo $members;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Chat</b></td>				
						<td style="border-top:none;">
							<input name="chat" <?php echo $chat;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Master Bank</b></td>				
						<td style="border-top:none;">
							<input name="master_bank" <?php echo $master_bank;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Tempo Payment</b></td>				
						<td style="border-top:none;">
							<input name="tempo_payment" <?php echo $tempo_payment;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Banner</b></td>				
						<td style="border-top:none;">
							<input name="banner" <?php echo $banner;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Area</b></td>				
						<td style="border-top:none;">
							<input name="area" <?php echo $area;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Brand</b></td>				
						<td style="border-top:none;">
							<input name="brand" <?php echo $brand;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Tier</b></td>				
						<td style="border-top:none;">
							<input name="tier" <?php echo $tier;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Province</b></td>				
						<td style="border-top:none;">
							<input name="province" <?php echo $province;?> type="checkbox" value=1 />
						</td>
					</tr>
				</table>
			</td>			
			<td class="h_tengah" style="width:50%; border-top:none;">		
				<table class="table table-responsive">
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;" width="40%"><b>Waiting Payment/Approve</b></td>		
						<td style="border-top:none;">
							<input name="waiting_payment" <?php echo $waiting_payment;?> type="checkbox" value=1 />
						</td>
					</tr>
				
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Payment Complete/Approve</b></td>		
						<td style="border-top:none;">
							<input name="payment_complete" <?php echo $payment_complete;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Dikirim</b></td>		
						<td style="border-top:none;">
							<input name="dikirim" <?php echo $dikirim;?> type="checkbox" value=1 />
						</td>
					</tr>
					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Sampai tujuan</b></td>		
						<td style="border-top:none;">
							<input name="sampai_tujuan" <?php echo $sampai_tujuan;?> type="checkbox" value=1 />
						</td>
					</tr>
				
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Complete</b></td>				
						<td style="border-top:none;">
							<input name="complete" <?php echo $complete;?> type="checkbox" value=1 />
						</td>
					</tr>					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Reject</b></td>				
						<td style="border-top:none;">
							<input name="reject" <?php echo $reject;?> type="checkbox" value=1 />
						</td>
					</tr>
					
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Tagihan</b></td>				
						<td style="border-top:none;">
							<input name="tagihan" <?php echo $tagihan;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Angsuran</b></td>				
						<td style="border-top:none;">
							<input name="angsuran" <?php echo $angsuran;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Reporting</b></td>				
						<td style="border-top:none;">
							<input name="reporting" <?php echo $reporting;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Level & Role</b></td>				
						<td style="border-top:none;">
							<input name="level_role" <?php echo $level_role;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Users</b></td>				
						<td style="border-top:none;">
							<input name="users" <?php echo $users;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>Setting</b></td>				
						<td style="border-top:none;">
							<input name="setting" <?php echo $setting;?> type="checkbox" value=1 />
						</td>
					</tr>
					<tr style="border-bottom:1px solid #ddd;">
						<td style="border-top:none; text-align:left;"><b>-</b></td>				
						<td style="border-top:none;">
							
						</td>
					</tr>
				</table>
			</td>			
		</tr>	
	</table>
	
</form>
	

</div>
<div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
		<button type="button" class="btn btn-danger canc"><i class="glyphicon glyphicon-remove"></i> Cancel</button>	
		<button type="button" class="btn btn-success save"><i class="glyphicon glyphicon-ok"></i> Save</button>		
	</div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$(".canc").click(function(){
	window.location = '<?php echo site_url('role');?>';
});
$('.save').click(function(){
	var data = $("#frm_editrole").serialize();
	console.log(data);
	var url = '<?php echo site_url('role/save');?>';
	$.ajax({
		url : url,
		type : 'POST',
		data : data,
		success:function(res){
			console.log(res);
			if(res > 0){
				window.location = '<?php echo site_url('role');?>';
			}
		}
	});
});

 
</script>

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
<div class="modal fade" role="dialog" id="frm_category">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Edit Stock</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_cat" method="post" autocomplete="off">
                <!-- text input -->
				<div class="row">
				<div class="form-group">
                  <label>WHS Code</label>
                  <input type="text" class="form-control" id="whs_code" value="" placeholder="WHS Code" autocomplete="off" disabled readonly />
                </div>
				<div class="form-group">
                  <label>Warehouse</label>
                  <input type="text" class="form-control" id="nama_warehouse" value="" placeholder="Warehouse" autocomplete="off" disabled readonly />
                </div>
				<div class="form-group">
                  <label>Stock</label><span class="label label-danger pull-right qty_error"></span>
                  <input type="text" class="form-control" name="qty" id="qty" value="" placeholder="Stock" autocomplete="off" />
                  <input type="hidden" value="" name="id_whs" id="id_whs">
                  <input type="hidden" value="" name="id_product" id="id_product">
                </div>
                
                
				</div>
                
              </form>

              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_save">Save</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class='alert alert-info alert-dismissable' id="success-alert">
  
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
<div class="box box-success">


<div class="box-body">	
	<table  class="table table-bordered table-reponsive">
	
		<tr class="header_kolom">
			
			<th style="vertical-align: middle; text-align:center"> <?php echo $product->nama_barang;?>  </th>
		</tr>
		<tr>
			
			<td> 
			<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
            <th style="text-align:center; width:14%">WHS Code</th>
            <th style="text-align:center; width:34%">Warehouse</th>
            	
			<th style="text-align:center; width:15%">Stock</th>			
			<th style="text-align:center; width:10%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i=1;
				if(!empty($warehouse)){		
					foreach($warehouse as $c){	
						$info = '';
						
						$info = $c['id_whs'].'Þ'.$c['whs_code'].'Þ'.$c['nama_whs'].'Þ'.number_format($stok[$c['id_whs']],0,',','.');
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';
						echo '<td>'.$c['whs_code'].'</td>';
						echo '<td>'.ucwords($c['nama_whs']).'</td>';					
						echo '<td align="right">'.number_format($stok[$c['id_whs']],0,',','.').'</td>';					
						echo '<td align="center" style="vertical-align: middle;">		
			
			
			<button id="'.$info.'" class="btn btn-xs btn-success edit_stok"><i class="fa fa-edit"></i> Edit Stock</button>
				
						</td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
			</td>

		</tr>
	</table>
	
	
	

</div>

</div>


	
<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 
var id_product = '<?php echo $product->id_product;?>';
$('.edit_stok').click(function(){
	$('#frm_cat').find("input[type=text], select").val("");
	$('#whs_code').val('');
	$('#nama_warehouse').val('');
	$('#id_whs').val('');
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_whs').val(dt[0]);
	$('#qty').val(dt[3]);
	$('#whs_code').val(dt[1]);
	$('#nama_warehouse').val(dt[2]);
	$('#id_product').val(id_product);
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});

$('.yes_save').click(function(){
	var dt = $('#frm_cat').serialize();
	var url = '<?php echo site_url('product/simpan_stock');?>';
	$.ajax({
		data : dt,
		url : url,
		type : "POST",
		success:function(response){
			$('#frm_category').modal('hide');
			$("#id_text").html('<b>Success,</b> Data stok telah diupdate');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});
 

$('#qty').keyup(function(event) {
  
  // format number
	$(this).val(function(index, value) {
		return value
		.replace(/\D/g, "")
		.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	});
});

</script>

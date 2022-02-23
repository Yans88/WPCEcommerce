<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
			$this->no_akses();
			return false;
		}		
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
		$this->data['judul_sub'] = 'List';
		$select = array('product.*','kategori.nama_kategori','merchants.nama_merchants');
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$where = array();
		$where = array('product.deleted_at'=>null,'product.paket <= '=> 0);
		$_level = $this->session->userdata('level');
		
		if($_level == 2){
			$where += array('product.id_merchant'=>$id_merchant);
		}
		$this->data['product'] = $this->access->readtable('product',$select,$where,array('kategori'=> 'kategori.id_kategori = product.id_kategori','merchants'=>'merchants.id_merchants = product.id_merchant'),'','','LEFT')->result_array();
		$this->data['isi'] = $this->load->view('products/product_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_product' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		$dt_product = '';
		$dt_product = $this->access->readtable('product', '', array('id_product' => $_POST['id']))->row();
		$simpan = array(			
				'nama_barang'		=> $dt_product->nama_barang,
				'id_kategori'		=> $dt_product->id_kategori,	
				'deskripsi'			=> $dt_product->deskripsi,	
				'harga'				=> $dt_product->harga,
				'paket'				=> $dt_product->paket,
				'qty'				=> $dt_product->qty,
				'diskon'			=> $dt_product->diskon,
				'id_area'			=> $dt_product->id_area,
				'id_brand'			=> $dt_product->id_brand,
				'id_merchant'		=> $dt_product->id_merchant
			);
		$simpan += array('id_product'=>$_POST['id'],'ket'=>'Delete Product','deleted_at'=>$tgl,'update_by'=>$this->session->userdata('operator_id'));
		$this->access->inserttable('history_product', $simpan); 
		echo $this->access->updatetable('product', $data, $where);
	}
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;		
		$id_kategori = isset($_POST['kategori']) ? (int)$_POST['kategori'] : 0;		
		$nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';
		$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
		$harga = isset($_POST['harga']) ? str_replace(',','',$_POST['harga']) : '';
		$stok = isset($_POST['stok']) ? str_replace('.','',$_POST['stok']) : '';
		$diskon = isset($_POST['diskon']) ? str_replace(',','',$_POST['diskon']) : 0;
		$id_brand = isset($_POST['brand']) ? (int)$_POST['brand'] : '';
		$id_area = isset($_POST['area']) ? (int)$_POST['area'] : '';
		$principla = isset($_POST['principal']) ? (int)$_POST['principal'] : '';
		$config['upload_path']   = FCPATH.'/uploads/products/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$_level = $this->session->userdata('level');
		$id_merchant = '';
		if($_level == 1){
			$id_merchant = $principla;
		}
		if($_level == 2){
			$id_merchant = $this->session->userdata('id_merchant');
		}
		
		$simpan = array(			
			'nama_barang'		=> $nama_produk,
			'pot_tier'			=> 1,
			'id_kategori'		=> $id_kategori,	
			'deskripsi'			=> $deskripsi,	
			'harga'				=> $harga,
			'paket'				=> 0,
			'qty'				=> 0,
			'diskon'			=> $diskon,
			'id_area'			=> $id_area,
			'id_brand'			=> $id_brand,
			'id_merchant'		=> $id_merchant
		);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }
		
		$where = array();
		$save = 0;		
		if($id_product > 0){
			$where = array('id_product'=>$id_product);
			$this->access->updatetable('product', $simpan, $where); 
			
			$save = $id_product; 
			$simpan += array('id_product'=>$save,'ket'=>'Update Product','update_by'=>$this->session->userdata('operator_id'));
			$this->access->inserttable('history_product', $simpan);   
		}else{
			$simpan += array('create_at'	=> $tgl);
			$save = $this->access->inserttable('product', $simpan);
			$simpan += array('id_product'=>$save,'ket'=>'Create Product','update_by'=>$this->session->userdata('operator_id'));
			$this->access->inserttable('history_product', $simpan);   
		}  
	    //error_log(PHP_EOL.''.$save.' '.$this->db->last_query(),3,'err');
		if($save > 0){
			redirect(site_url('product'));
		}	 
	}
	
	function add($id_product =''){
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
		$this->data['judul_sub'] = 'Add';
		$merchants = '';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 1;
		$_level = $this->session->userdata('level');
		$where = array();
		$this->data['area'] = $this->access->readtable('area','',array('deleted_at'=>null))->result_array();
		$this->data['brand'] = $this->access->readtable('brand','',array('deleted_at'=>null))->result_array();
		if($_level == 1){
			$merchants = $this->access->readtable('merchants','',array('deleted_at'=>null))->result_array();
		}
		$this->data['merchants'] = $merchants;
		$this->data['kat'] = $this->access->readtable('kategori','',array('deleted_at'=>null, 'nama_kategori !='=>'Banner','id_merchant' => $id_merchant))->result_array();
		$id_product = $this->converter->decode($id_product);
		if($id_product > 0){
			$this->data['judul_sub'] = 'Edit';
			$product = $this->access->readtable('product','',array('id_product'=>$id_product))->row();
		}
		
		$this->data['product'] = $product;
		$this->data['isi'] = $this->load->view('products/product_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function view_stock($id_product =''){
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
			
		$id_product = $this->converter->decode($id_product);
		$this->data['judul_sub'] = 'Stock';
		$product = $this->access->readtable('product','',array('id_product'=>$id_product))->row();
		$stok = $this->access->readtable('stok','',array('stok.deleted_at'=>null,'stok.id_product'=>$id_product))->result_array();
		$_stok = array();
		if(!empty($stok)){
			foreach($stok as $_s){
				$_stok[$_s['id_wh']] = $_s['stok'];
			}
		}
		$warehouse = $this->access->readtable('warehouse','',array('warehouse.deleted_at'=>null))->result_array();
		$this->data['warehouse'] = $warehouse;
		$this->data['stok'] = $_stok;
		$this->data['product'] = $product;
		$this->data['isi'] = $this->load->view('products/product_stock', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function list_diskon($id_product =''){
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
			
		$id_product = $this->converter->decode($id_product);
		$this->data['judul_sub'] = 'Diskon';
		$product = $this->access->readtable('product','',array('id_product'=>$id_product))->row();
		$list_diskon = $this->access->readtable('list_diskon','',array('deleted_at'=>null,'id_product'=>$id_product))->result_array();
				
		$this->data['list_diskon'] = $list_diskon;		
		$this->data['product'] = $product;
		$this->data['isi'] = $this->load->view('products/product_diskon', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function simpan_stock(){
		$tgl = date('Y-m-d H:i:s');
		$id_whs = isset($_POST['id_whs']) ? (int)$_POST['id_whs'] : 0;	
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;	
		$qty = isset($_POST['qty']) ? (int)(str_replace('.','',$_POST['qty'])) : 0;
		$where = array('id_product'=>$id_product,'id_wh'=>$id_whs,'deleted_at'=>null);
		$product = $this->access->readtable('stok','',$where)->row();
		$save = 0;
		$simpan = array('stok'=>$qty,'id_product'=>$id_product,'id_wh'=>$id_whs);
		if(!empty($product)){
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$this->access->updatetable('stok', $simpan, $where);
			$save = $id_product;
		}else{
			$simpan += array('created_at'=>$tgl,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('stok', $simpan);
		}
		echo $save;
	}
	
	function simpan_diskon(){
		$tgl = date('Y-m-d H:i:s');
		$id_diskon = isset($_POST['id_diskon']) ? (int)$_POST['id_diskon'] : 0;	
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;	
		$diskon = isset($_POST['diskon']) ? (int)(str_replace('.','',$_POST['diskon'])) : 0;
		$list_diskon = $this->access->readtable('list_diskon','',array('deleted_at'=>null,'id_product'=>$id_product,'diskon'=>$diskon))->row();
		$_id_diskon = !empty($list_diskon) ? $list_diskon->id_diskon : 0;
		if($_id_diskon > 0 && $id_diskon != $_id_diskon){
			echo 'exist';
			return false;
		}
		$save = 0;
		$simpan = array('diskon'=>$diskon,'id_product'=>$id_product);
		if($id_diskon > 0){
			$where = array('id_product'=>$id_product,'id_diskon'=>$id_diskon,'deleted_at'=>null);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$this->access->updatetable('list_diskon', $simpan, $where);
			$save = $id_product;
		}else{
			$simpan += array('created_at'=>$tgl,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('list_diskon', $simpan);
		}
		echo $save;
	}
	
	function get_members(){
		$id_diskon = isset($_POST['id_diskon']) ? (int)$_POST['id_diskon'] : 0;	
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;	
		$search_member = isset($_POST['search_member']) ? strtolower($_POST['search_member']) : '';	
		$selects = array('id','nama','email','kd_cust','members.id_member','phone','list_member_diskon.id_diskon');
		$list_members = $this->access->readtable('list_diskon',$selects,array('list_diskon.deleted_at'=>null,'list_member_diskon.deleted_at'=>null,'list_diskon.id_product'=>$id_product),array('list_member_diskon'=> 'list_member_diskon.id_diskon = list_diskon.id_diskon','members'=> 'members.id_member = list_member_diskon.id_member'),'','','LEFT')->result_array();
		
		// $list_members = $this->access->readtable('list_member_diskon',$selects,array('list_member_diskon.deleted_at'=>null,'id_diskon'=>$id_diskon),array('members'=> 'members.id_member = list_member_diskon.id_member'),'','','LEFT')->result_array();
		$html = '';
		$id_member = array();
		$_id_member = '';
		$sql_member = '';
		$option = array();
		$sql_member = 'SELECT nama,email,id_member,phone, kd_cust, ocrcode_c FROM members WHERE 1=1';
		if(!empty($list_members)){
			$html = '<ul class="todo-list ui-sortable">';
			foreach($list_members as $lm){
				$id_member[] = '"'.$lm['id_member'].'"';
				$_id_member = implode(',',$id_member);	
				if($lm['id_diskon'] == $id_diskon){								
					$html .= ' <li id='.$lm['id_member'].'>                  
					  <span class="text">'.$lm['nama'].'('.$lm['kd_cust'].'-'.$lm['email'].')</span>
					  <!-- Emphasis label -->
					  <small class="label label-danger"></small>
					  <!-- General tools such as edit or delete-->
					  <div class="tools">
						
						<i class="fa fa-trash-o" onclick="return unassign('.$lm['id_member'].');"></i>
					  </div>
					</li>';
				}
				
			}
			$html .= '</ul>';
			$sql_member .=' and id_member NOT IN ('.$_id_member.')';
		}else{
			$html .='<h4 class="text-center" style="color:#EF3D24; font-weight:600;">Member not found</h4>';
		}
		
		if(!empty($search_member)){
			$sql_member .=' and (LOWER(kd_cust) LIKE "%'.$search_member.'%" or LOWER(nama) LIKE "%'.$search_member.'%" or email LIKE "%'.$search_member.'%" or phone LIKE "%'.$search_member.'%")';
		}
		$_dt_member = $this->db->query($sql_member)->result_array();
		$html_available = '';
		if(!empty($_dt_member)){
			foreach($_dt_member as $dm){
				$html_available .='<div class="col-md-3" id='.$dm['id_member'].'>
					<div class="thumbnail" style="background-color: #f7f7f9";>	 
					  <div class="caption" style="padding:5px; padding-bottom:2px;">
						<p><strong>'.$dm['nama'].'-'.$dm['kd_cust'].'</strong>  <br/>  
						'.$dm['email'].'<br/>'.$dm['phone'].' <button onclick="return assign('.$dm['id_member'].');" class="btn btn-success btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Add</button></p>  
					
					  </div>	  
					</div>
				  </div>';
				 $option[$dm['ocrcode_c']] = $dm['ocrcode_c'];
			}			
		}else{
			$html_available .='<h4 class="text-center" style="color:#EF3D24; font-weight:600;">Member not found</h4>';
		}
		$opt = '<option value="">- Pilih Ocrcode C -</option>';
		if(!empty($option)){
			foreach($option as $key=>$val){
				if(!empty($key)){
					$opt .='<option value="'.$key.'">'.$key.'</option>';
				}
			}
		}
		
		$res = array(
			'list_members'	=> $html,
			'option'		=> $opt,
			'list_members_available'	=> $html_available
		);
        
		echo json_encode($res);
	}
	
	public function del_diskon(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_diskon' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'=>$this->session->userdata('operator_id')
		);
		
		echo $this->access->updatetable('list_diskon', $data, $where);
	}
	
	function assign_members(){
		$tgl = date('Y-m-d H:i:s');
		$id_diskon = isset($_POST['id_diskon']) ? (int)$_POST['id_diskon'] : 0;	
		$id_member = isset($_POST['id_member']) ? (int)$_POST['id_member'] : 0;	
		$simpan = array(
			'id_diskon'		=> $id_diskon,
			'id_member'		=> $id_member,
			'created_at'	=> $tgl,
			'created_by'	=>$this->session->userdata('operator_id')
		);
		$save = $this->access->inserttable('list_member_diskon', $simpan);
		$selects = array('id','nama','email','kd_cust','members.id_member','phone');
		$list_members = $this->access->readtable('list_member_diskon',$selects,array('list_member_diskon.deleted_at'=>null,'id_diskon'=>$id_diskon),array('members'=> 'members.id_member = list_member_diskon.id_member'),'','','LEFT')->result_array();
		$html = '';		
		if(!empty($list_members)){
			$html = '<ul class="todo-list ui-sortable">';
			foreach($list_members as $lm){
				$html .= ' <li id='.$lm['id_member'].'>                  
                  <span class="text">'.$lm['nama'].'('.$lm['kd_cust'].'-'.$lm['email'].')</span>
                  <!-- Emphasis label -->
                  <small class="label label-danger"></small>
                  <!-- General tools such as edit or delete-->
                  <div class="tools">
                    
                    <i class="fa fa-trash-o" onclick="return unassign('.$lm['id_member'].');"></i>
                  </div>
                </li>';
			}
			$html .= '</ul>';
			
		}else{
			$html .='<h4 class="text-center" style="color:#EF3D24; font-weight:600;">Member not found</h4>';
		}		
		$res = array(
			'list_members'	=> $html,
			'list_members_available' => ''
		);
        
		echo json_encode($res);
	}
	
	function unassign_members(){
		$tgl = date('Y-m-d H:i:s');
		$id_diskon = isset($_POST['id_diskon']) ? (int)$_POST['id_diskon'] : 0;	
		$id_member = isset($_POST['id_member']) ? (int)$_POST['id_member'] : 0;	
		$where = array(
			'id_diskon'		=> $id_diskon,
			'id_member'		=> $id_member,
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'=>$this->session->userdata('operator_id')
		);		
		echo $this->access->updatetable('list_member_diskon', $data, $where);
		
	}
	
	function apply_ocrcode_c(){
		$tgl = date('Y-m-d H:i:s');
		$id_diskon = isset($_POST['id_diskon']) ? (int)$_POST['id_diskon'] : 0;	
		$ocrcode_c = isset($_POST['ocrcode_c']) ? $_POST['ocrcode_c'] : '';	
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;	
		$selects = array('id','list_member_diskon.id_member','list_member_diskon.id_diskon');
		$list_members = $this->access->readtable('list_diskon',$selects,array('list_diskon.deleted_at'=>null,'list_member_diskon.deleted_at'=>null,'list_diskon.id_product'=>$id_product),array('list_member_diskon'=> 'list_member_diskon.id_diskon = list_diskon.id_diskon'),'','','LEFT')->result_array();
		$id_member = array();
		$_id_member = '';
		$sql_member = 'SELECT nama,email,id_member,phone, kd_cust, ocrcode_c FROM members WHERE ocrcode_c= "'.$ocrcode_c.'"';
		if(!empty($list_members)){			
			foreach($list_members as $lm){
				if($lm['id_member'] > 0){
					$id_member[] = '"'.$lm['id_member'].'"';
					$_id_member = implode(',',$id_member);
				}					
			}
			if(!empty($id_member)) $sql_member .=' and id_member NOT IN ('.$_id_member.')';
		}
		
		$_dt_member = $this->db->query($sql_member)->result_array();
		if(!empty($_dt_member)){
			foreach($_dt_member as $dm){
				$simpan[] = array(
					'id_diskon'		=> $id_diskon,
					'id_member'		=> $dm['id_member'],
					'created_at'	=> $tgl,
					'created_by'	=>$this->session->userdata('operator_id')
				);
			}
			
			$this->db->insert_batch('list_member_diskon', $simpan);
		}
		
		$selects = array('id','nama','email','kd_cust','members.id_member','phone','members.ocrcode_c');
		$list_members = $this->access->readtable('list_member_diskon',$selects,array('list_member_diskon.deleted_at'=>null,'id_diskon'=>$id_diskon),array('members'=> 'members.id_member = list_member_diskon.id_member'),'','','LEFT')->result_array();
		$html = '';		
		$option = array();
		$id_member = array();
		$_id_member = '';
		$sql_member = 'SELECT nama,email,id_member,phone, kd_cust, ocrcode_c FROM members WHERE 1=1';
		if(!empty($list_members)){
			
			$html = '<ul class="todo-list ui-sortable">';
			foreach($list_members as $lm){
				$id_member[] = '"'.$lm['id_member'].'"';
				$_id_member = implode(',',$id_member);
				$html .= ' <li id='.$lm['id_member'].'>                  
                  <span class="text">'.$lm['nama'].'('.$lm['kd_cust'].'-'.$lm['email'].')</span>
                  <!-- Emphasis label -->
                  <small class="label label-danger"></small>
                  <!-- General tools such as edit or delete-->
                  <div class="tools">
                    
                    <i class="fa fa-trash-o" onclick="return unassign('.$lm['id_member'].');"></i>
                  </div>
                </li>';				
			}
			$html .= '</ul>';
			$sql_member .=' and id_member NOT IN ('.$_id_member.')';
		}else{
			$html .='<h4 class="text-center" style="color:#EF3D24; font-weight:600;">Member not found</h4>';
		}		
		error_log($sql_member);
		$_dt_member = $this->db->query($sql_member)->result_array();
		$html_available = '';
		if(!empty($_dt_member)){
			foreach($_dt_member as $dm){
				$html_available .='<div class="col-md-3" id='.$dm['id_member'].'>
					<div class="thumbnail" style="background-color: #f7f7f9";>	 
					  <div class="caption" style="padding:5px; padding-bottom:2px;">
						<p><strong>'.$dm['nama'].'-'.$dm['kd_cust'].'</strong>  <br/>  
						'.$dm['email'].'<br/>'.$dm['phone'].' <button onclick="return assign('.$dm['id_member'].');" class="btn btn-success btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Add</button></p>  
					
					  </div>	  
					</div>
				  </div>';
				 $option[$dm['ocrcode_c']] = $dm['ocrcode_c'];
			}			
		}else{
			$html_available .='<h4 class="text-center" style="color:#EF3D24; font-weight:600;">Member not found</h4>';
		}
		$opt = '<option value="">- Pilih Ocrcode C -</option>';
		if(!empty($option)){
			foreach($option as $key=>$val){
				if(!empty($key)){
					$opt .='<option value="'.$key.'">'.$key.'</option>';
				}
			}
		}
		
		$res = array(
			'list_members'	=> $html,
			'option'		=> $opt,
			'list_members_available' => $html_available
		);
		echo json_encode($res);
	}
	
	public function import_stock(){
		// $this->load->model('Access', 'access', true);
		$config['upload_path']   = FCPATH.'/uploads/products/';
        $config['allowed_types'] = "xls|xlsx|csv";
        $config['remove_spaces'] = true;
        $config['overwrite'] = true;
        $config['max_size'] = '2048';
		
		$this->load->library('upload',$config);
		$this->load->library('excel');
		$barcode = '';
		$point = '';
		$all_data = 0;
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');
		if (!$this->upload->do_upload('user_import_stock')) {
            $data['error'] = $error = $this->upload->display_errors();
            
        }else {
            $file_data = $this->upload->data('user_import_stock');
            $file_path = './uploads/products/'.$_FILES['user_import_stock']['name'];
			$data['size_file'] = $file_data['file_size'];
			$data['file_name'] = $file_data['file_name'];
			$file_type	= PHPExcel_IOFactory::identify($file_path);
    		$objReader	= PHPExcel_IOFactory::createReader($file_type);
    		$objPHPExcel = $objReader->load($file_path);
    		$sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$where = array();			
			$i=0;
			$tgl = date('Y-m-d H:i:s');
			foreach($sheet_data as $data){
				if($i>0){					
					$nama_produk = '';			
					$id_whs = '';
					$whs_code = '';					
					$whs = '';	
					$stok = '';							
					$nama_produk = trim($data['A']);						
					$whs_code = trim($data['B']);						
					$stok = str_replace('.','',$data['C']);					
					$stok = str_replace(',','',$stok);
					$simpan = array();	
					$where = array();
					$where = array('lower(nama_barang)'=> strtolower($nama_produk),'deleted_at'=>null,'id_merchant' => $id_merchant);
					if($_level == 1){
						$where = array();
						$where = array('lower(nama_barang)'=> strtolower($nama_produk),'deleted_at'=>null);
					}
					$product = $this->access->readtable('product','',$where)->row();
					
					$where = array();
					$where = array('lower(whs_code)'=> strtolower($whs_code),'deleted_at'=>null);
					$whs = $this->access->readtable('warehouse','',$where)->row();
					
					$id_product = (int)$product->id_product > 0 ? (int)$product->id_product : 0;
					$id_whs = (int)$whs->id_whs > 0 ? (int)$whs->id_whs : 0;
					$simpan = array(			
						'id_product'		=> $id_product,						
						'stok'				=> $stok,	
						'id_wh'				=> $id_whs
						
					);
					$dt_stock = '';
					if($id_product > 0 && $id_whs > 0){
						$where = array();
						$where = array('id_product'=>$id_product,'id_wh'=>$id_whs,'deleted_at'=>null);
						$dt_stock = $this->access->readtable('stok','',$where)->row();
						if(!empty($dt_stock)){
							$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
							$this->access->updatetable('stok', $simpan, $where);
							$save = $id_product;
						}else{
							$simpan += array('created_at'=>$tgl,'created_by'=>$this->session->userdata('operator_id'));
							$save = $this->access->inserttable('stok', $simpan);
						}						
					}
					
				}
				
				$i++;
			}
		}
		
		redirect('/product');
	}
	
	public function import(){
		// $this->load->model('Access', 'access', true);
		$config['upload_path']   = FCPATH.'/uploads/products/';
        $config['allowed_types'] = "xls|xlsx|csv";
        $config['remove_spaces'] = true;
        $config['overwrite'] = true;
        $config['max_size'] = '2048';
		
		$this->load->library('upload',$config);
		$this->load->library('excel');
		$barcode = '';
		$point = '';
		$all_data = 0;
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		if (!$this->upload->do_upload('user_import')) {
            $data['error'] = $error = $this->upload->display_errors();
            
        }else {
            $file_data = $this->upload->data('user_import');
            $file_path = './uploads/products/'.$_FILES['user_import']['name'];
			$data['size_file'] = $file_data['file_size'];
			$data['file_name'] = $file_data['file_name'];
			$file_type	= PHPExcel_IOFactory::identify($file_path);
    		$objReader	= PHPExcel_IOFactory::createReader($file_type);
    		$objPHPExcel = $objReader->load($file_path);
    		$sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$varData = array();
			$dt_duplicate = array();
			$i=0;
			$tgl = date('Y-m-d H:i:s');
			foreach($sheet_data as $data){
				if($i>0){					
					$nama_produk = '';			
					$id_kategori = '';
					$deskripsi = '';
					$harga = '';
					$diskon = '';
					$id_area = '';
					$id_brand = '';			
					$nama_produk = $data['A'];
					$harga = str_replace(',','',$data['B']);	
					$id_kategori = $data['C'];
					$diskon = str_replace('.','',$data['D']);
					$id_brand = $data['E'];	
					$id_area = $data['F'];
					$deskripsi = $data['G'];						
					$id_product = (int)$data['H'];						
					$harga = str_replace(',','',$harga);
					$diskon = str_replace(',','',$diskon);
					$simpan = array();			
					$simpan = array(			
						'nama_barang'		=> $nama_produk,						
						'id_kategori'		=> $id_kategori,	
						'deskripsi'			=> $deskripsi,	
						'harga'				=> $harga,
						'paket'				=> 0,
						'qty'				=> 0,
						'diskon'            => $diskon,
						'id_area'			=> $id_area,
						'id_brand'			=> $id_brand
					);
					if($id_product > 0){
						$where = array('id_product'=>$id_product,'id_merchant' => $id_merchant);
						$this->access->updatetable('product', $simpan, $where); 
						$save = $id_product; 
						$simpan += array('id_product'=>$save,'ket'=>'Update Product(Import)','update_by'=>$this->session->userdata('operator_id'));
						$this->access->inserttable('history_product', $simpan); 
					}else{
						$simpan += array('create_at'	=> $tgl, 'id_merchant' => $id_merchant);
						$save = $this->access->inserttable('product', $simpan);	
						$simpan += array('id_product'=>$save,'ket'=>'Create Product(Import)','update_by'=>$this->session->userdata('operator_id'));
						$this->access->inserttable('history_product', $simpan);
					}
					
				}
				
				$i++;
			}
		}
		error_log($this->db->last_query());
		redirect('/product');
	}
	
	function export_r(){
		$this->load->library('excel');
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$where = array();
		$where = array('product.deleted_at'=>null,'product.paket <= '=> 0);
		$_level = $this->session->userdata('level');
		
		if($_level == 2){
			$where += array('product.id_merchant'=>$id_merchant);
		}
		
		$product = $this->access->readtable('product','',$where)->result_array();			
		$this->excel->setActiveSheetIndex(0);		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		
		
		
		$this->excel->getActiveSheet()->getStyle('A1:H1')->getFont()->setSize(12);				
		$this->excel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
		
		$styleArray = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		$this->excel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray);			
		
		$this->excel->getActiveSheet()->setCellValue('A1', 'Product Name');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Price');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Id Category');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Diskon');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Id Brand');
		$this->excel->getActiveSheet()->setCellValue('F1', 'Id Area');
        $this->excel->getActiveSheet()->setCellValue('G1', 'Description');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Id Product');
        
		$this->excel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$i=2;
		$no = 1;
		$data_addon = '';
		$sub_ttl = 0;
		$id_trans = array();
		if(!empty($product)){
			foreach($product as $t){
				$this->excel->getActiveSheet()->setCellValue('A'.$i, $t['nama_barang']);
				$this->excel->getActiveSheet()->setCellValue('B'.$i, $t['harga']);
				$this->excel->getActiveSheet()->setCellValue('C'.$i, $t['id_kategori']);
				$this->excel->getActiveSheet()->setCellValue('D'.$i, $t['diskon']);
				$this->excel->getActiveSheet()->setCellValue('E'.$i, $t['id_brand']);		
				$this->excel->getActiveSheet()->setCellValue('F'.$i, $t['id_area']);
				$this->excel->getActiveSheet()->setCellValue('G'.$i, $t['deskripsi']);				
				$this->excel->getActiveSheet()->setCellValue('H'.$i, $t['id_product']);				
				
							
				$this->excel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->applyFromArray($styleArray);
				$this->excel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getAlignment()->setWrapText(true);				
					
				
				
				$i++;
			}
			unset($styleArray);	
		}
		
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		
		$filename ='data_product.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0'); 					 
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  		
		$objWriter->save('php://output');
		
	}
	
	public function history($id_product='') {
		if(!$this->session->userdata('login') || !$this->session->userdata('product')){
			$this->no_akses();
			return false;
		}		
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
		$this->data['judul_sub'] = 'History';
		$select = array('history_product.*','kategori.nama_kategori','merchants.nama_merchants','admin.fullname');
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$where = array();
		$sort = array('id','DESC');
		$id_product = $this->converter->decode($id_product);
		$where = array('history_product.deleted_at'=>null,'history_product.paket <= '=> 0, 'history_product.id_product'=>$id_product);
		$_level = $this->session->userdata('level');
		
		if($_level == 2){
			$where += array('history_product.id_merchant'=>$id_merchant);
		}
		$this->data['product'] = $this->access->readtable('history_product',$select,$where,array('kategori'=> 'kategori.id_kategori = history_product.id_kategori','merchants'=>'merchants.id_merchants = history_product.id_merchant','admin'=>'admin.operator_id = history_product.update_by'),'',$sort,'LEFT')->result_array();
		error_log(PHP_EOL.''.$save.' '.$this->db->last_query(),3,'err');
		$this->data['isi'] = $this->load->view('products/product_log', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div><div class="error-page">
        <h3 class="text-red"><i class="fa fa-warning text-yellow"></i> Oops! No Akses.</h3></div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}


}

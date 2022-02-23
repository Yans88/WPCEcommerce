<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paket extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {	
		if(!$this->session->userdata('login') || !$this->session->userdata('paket')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Paket';
		$this->data['judul_utama'] = 'Paket';
		$this->data['judul_sub'] = 'List';
		$select = array('product.*','kategori.nama_kategori','merchants.nama_merchants');
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$where = array();
		$where = array('product.deleted_at'=>null,'product.paket > '=> 0);
		$_level = $this->session->userdata('level');
		
		if($_level == 2){
			$where += array('product.id_merchant'=>$id_merchant);
		}
		$this->data['product'] = $this->access->readtable('product',$select,$where,array('kategori'=> 'kategori.id_kategori = product.id_kategori','merchants'=>'merchants.id_merchants = product.id_merchant'),'','','LEFT')->result_array();
		$this->data['isi'] = $this->load->view('paket/product_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;		
		$id_kategori = isset($_POST['kategori']) ? (int)$_POST['kategori'] : 0;		
		$pot_tier = isset($_POST['pot_tier']) ? 1 : 0;			
		$nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';
		$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
		$harga = isset($_POST['harga']) ? str_replace('.','',$_POST['harga']) : '';
		$stok = isset($_POST['stok']) ? str_replace('.','',$_POST['stok']) : '';
		$tgll = isset($_POST['start_date']) && !empty($_POST['start_date']) ? $_POST['start_date'] : '';		
		$_tgl = !empty($tgll) ? explode('-', $tgll) : '';
		$start_date = !empty($tgll) ? str_replace('/','-',$_tgl[0]) : '';
		$end_date = !empty($tgll) ? str_replace('/','-',$_tgl[1]) : '';
		
		$config['upload_path']   = FCPATH.'/uploads/products/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array(			
			'nama_barang'		=> $nama_produk,
			'id_kategori'		=> $id_kategori,	
			'pot_tier'			=> $pot_tier,	
			'deskripsi'			=> $deskripsi,	
			'harga'				=> $harga,
			'paket'				=> 1,
			'qty'				=> $stok,
			'start_date'		=> !empty($start_date) ? date('Y-m-d', strtotime($start_date)) : $start_date,
			'end_date'			=> !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : $end_date
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
			$save = $this->access->updatetable('product', $simpan, $where);   
		}else{
			$simpan += array('create_at'	=> $tgl,'id_merchant' => $this->session->userdata('id_merchant'));
			$save = $this->access->inserttable('product', $simpan);   
		}  
		error_log($this->db->last_query());
		if($save > 0){
			redirect(site_url('paket'));
		}	 
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
	
	function add($id_product =''){
		$this->data['judul_browser'] = 'Paket';
		$this->data['judul_utama'] = 'Paket';
		$this->data['judul_sub'] = 'Add';
		$merchants = '';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 1;
		$where = array();
		$this->data['kat'] = $this->access->readtable('kategori','',array('deleted_at'=>null, 'nama_kategori !='=>'Banner','id_merchant' => $id_merchant))->result_array();
		$id_product = $this->converter->decode($id_product);
		if($id_product > 0){
			$this->data['judul_sub'] = 'Edit';
			$product = $this->access->readtable('product','',array('id_product'=>$id_product))->row();
		}
		
		$this->data['product'] = $product;
		$this->data['isi'] = $this->load->view('paket/product_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function view_product($id_paket =''){
		if(!$this->session->userdata('login') || !$this->session->userdata('paket')){
			$this->no_akses();
			return false;
		}
		$id_paket = $this->converter->decode($id_paket);
		$select = array('paket_detail.*','product.nama_barang','product.img');
		$paket = $this->access->readtable('product','',array('id_product'=>$id_paket))->row();
		$product = $this->access->readtable('paket_detail',$select,array('paket_detail.id_paket'=>$id_paket,'paket_detail.deleted_at'=>null),array('product'=> 'product.id_product = paket_detail.id_product'),'','','LEFT')->result_array();		
		$this->data['judul_sub'] = 'List Product';
		$this->data['judul_browser'] = 'Paket';
		$this->data['judul_utama'] = $paket->nama_barang;
		$this->data['product'] = $product;
		$this->data['id_paket'] = $id_paket;
		$this->data['isi'] = $this->load->view('paket/list_product_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function simpan_prod(){
		$tgl = date('Y-m-d H:i:s');
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;		
		$id_paket = isset($_POST['id_paket']) ? (int)$_POST['id_paket'] : 0;	
		$qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 0;	
		$where = array(
			'id_product' 	=> $id_product,
			'id_paket' 		=> $id_paket
		);
		$product = $this->access->readtable('paket_detail','',array('id_paket'=>$id_paket,'id_product'=>$id_product,'deleted_at'=>null))->row();
		
		$data = array(
			'qty'	=> $qty
		);
		
		
		if(count($product) > 0){
			$where = array();
			$where = array(
				'id_paket_detail' 	=> $product->id_paket_detail
			);
			$this->access->updatetable('paket_detail', $data, $where);
			$save = $product->id_paket_detail;
		} else {
			$data += array('create_at'	=> $tgl,'id_product' => $id_product,'id_paket'=>$id_paket);
			$save = $this->access->inserttable('paket_detail', $data);  	
		}
		
		echo $save;
		
	}
	
	public function add_prod($id_paket='') {
		$id_paket = $this->converter->decode($id_paket);		
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
		$this->data['judul_sub'] = 'List';
		$select = array('product.*','kategori.nama_kategori','merchants.nama_merchants');
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$where = array();
		$where = array('product.deleted_at'=>null,'product.paket <= '=> 0);
		$_level = $this->session->userdata('level');
		$this->data['id_paket'] = $id_paket;
		if($_level == 2){
			$where += array('product.id_merchant'=>$id_merchant);
		}
		$this->data['product'] = $this->access->readtable('product',$select,$where,array('kategori'=> 'kategori.id_kategori = product.id_kategori','merchants'=>'merchants.id_merchants = product.id_merchant'),'','','LEFT')->result_array();
		$this->data['isi'] = $this->load->view('paket/add_prod_f', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_paket_detail' 	=> $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('paket_detail', $data, $where);
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

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {	
		if(!$this->session->userdata('login') || !$this->session->userdata('brand')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Brand';
		$this->data['judul_utama'] = 'Brand';
		$this->data['judul_sub'] = 'List';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$where = array();
		$this->data['brand'] = $this->access->readtable('brand','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('brand/brand_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_brand' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('brand', $data, $where);
	}	
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		$id_brand = isset($_POST['id_brand']) ? (int)$_POST['id_brand'] : 0;		
		$nama_brand = isset($_POST['nama_brand']) ? $_POST['nama_brand'] : '';
		$ocrcode_b = isset($_POST['ocrcode_b']) ? $_POST['ocrcode_b'] : '';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 1;
		
		$simpan = array(			
			'nama_brand'	=> $nama_brand,			
			'ocrcode_b'		=> $ocrcode_b			
		);
		
		$where = array();
		$save = 0;	
		if($id_brand > 0){
			$where = array('id_brand'=>$id_brand);
			$save = $this->access->updatetable('brand', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('brand', $simpan);   
		}  
		redirect(site_url('brand'));
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

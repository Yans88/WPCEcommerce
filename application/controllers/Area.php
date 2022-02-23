<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {		
		if(!$this->session->userdata('login') || !$this->session->userdata('area')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Area';
		$this->data['judul_utama'] = 'Area';
		$this->data['judul_sub'] = 'List';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$where = array();
		$this->data['brand'] = $this->access->readtable('area','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('area/area_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_area' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('area', $data, $where);
	}
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		$id_area = isset($_POST['id_area']) ? (int)$_POST['id_area'] : 0;		
		$nama_area = isset($_POST['nama_area']) ? $_POST['nama_area'] : '';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 1;
		
		$simpan = array(			
			'nama_area'		=> $nama_area			
		);
		
		$where = array();
		$save = 0;	
		if($id_area > 0){
			$where = array('id_area'=>$id_area);
			$save = $this->access->updatetable('area', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('area', $simpan);   
		}  
		redirect(site_url('area'));
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

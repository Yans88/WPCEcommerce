<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Province extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('province')){
			$this->no_akses();
			return false;
		}			
		$this->data['judul_browser'] = 'Province';
		$this->data['judul_utama'] = 'Province';
		$this->data['judul_sub'] = 'List';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$where = array();
		$this->data['provinsi'] = $this->access->readtable('provinsi','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('provinsi/province_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function city($id_provinsi=0) {
		if(!$this->session->userdata('login') || !$this->session->userdata('province')){
			$this->no_akses();
			return false;
		}		
		$this->data['judul_browser'] = 'City';
		$this->data['judul_utama'] = 'All';
		$this->data['judul_sub'] = 'City';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$where = array('deleted_at'=>null);
		if($id_provinsi > 0){
			$where += array('id_provinsi' => $id_provinsi);
			$prov = $this->access->readtable('provinsi','',$where)->row();
			$this->data['judul_utama'] = $prov->nama_provinsi;
		}
		
		$this->data['id_provinsi'] = $id_provinsi;
		$this->data['city'] = $this->access->readtable('city','',$where)->result_array();
		$this->data['isi'] = $this->load->view('provinsi/city_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_provinsi' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('provinsi', $data, $where);
	}

	public function del_city(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_city' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('city', $data, $where);
	}
	
	public function simpan_prov(){
		$tgl = date('Y-m-d H:i:s');
		$id_provinsi = isset($_POST['id_provinsi']) ? (int)$_POST['id_provinsi'] : 0;		
		$nama_provinsi = isset($_POST['provinsi']) ? $_POST['provinsi'] : '';
		$ocrcode_p = isset($_POST['ocrcode_p']) ? $_POST['ocrcode_p'] : '';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 1;
		
		$simpan = array(			
			'nama_provinsi'		=> $nama_provinsi
		);
		
		$where = array();
		$save = 0;	
		if($id_provinsi > 0){
			$where = array('id_provinsi'=>$id_provinsi);
			$save = $this->access->updatetable('provinsi', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('provinsi', $simpan);   
		}  
		redirect(site_url('province'));
	}
	
	public function simpan_city(){
		$tgl = date('Y-m-d H:i:s');
		$id_provinsi = isset($_POST['id_provinsi']) ? (int)$_POST['id_provinsi'] : 0;		
		$id_city = isset($_POST['id_city']) ? (int)$_POST['id_city'] : 0;		
		$nama_city = isset($_POST['city']) ? $_POST['city'] : '';
		$ocrcode_c = isset($_POST['ocrcode_c']) ? $_POST['ocrcode_c'] : '';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 1;
		
		$simpan = array(			
			'id_provinsi'	=> $id_provinsi,			
			'nama_city'		=> $nama_city			
		);
		
		$where = array();
		$save = 0;	
		if($id_city > 0){
			$where = array('id_city'=>$id_city);
			$save = $this->access->updatetable('city', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('city', $simpan);   
		}  
		redirect(site_url('province/city/'.$id_provinsi));
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

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('area')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Warehouse';
		$this->data['judul_utama'] = 'Warehouse';
		$this->data['judul_sub'] = 'List';
		
		$this->data['warehouse'] = $this->access->readtable('warehouse','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('warehouse/warehouse_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	
	public function del(){
		if(!$this->session->userdata('login') || !$this->session->userdata('area')){
			$this->no_akses();
			return false;
		}
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_whs' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('warehouse', $data, $where);
	}

	
	
	
	public function simpan(){
		if(!$this->session->userdata('login') || !$this->session->userdata('area')){
			$this->no_akses();
			return false;
		}
		$tgl = date('Y-m-d H:i:s');
		$id_warehouse = isset($_POST['id_warehouse']) ? (int)$_POST['id_warehouse'] : 0;		
		$whs_code = isset($_POST['whs_code']) ? $_POST['whs_code'] : '';
		$warehouse = isset($_POST['warehouse']) ? $_POST['warehouse'] : '';
		
		$simpan = array(			
			'whs_code'	=> $whs_code,		
			'nama_whs'	=> $warehouse		
		);
		
		$where = array();
		$save = 0;	
		if($id_warehouse > 0){
			$where = array('id_whs'=>$id_warehouse);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->updatetable('warehouse', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('warehouse', $simpan);   
		}  
		error_log($this->db->last_query());
		redirect(site_url('warehouse'));
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

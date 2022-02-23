<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tier extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {	
		if(!$this->session->userdata('login') || !$this->session->userdata('tier')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Tier';
		$this->data['judul_utama'] = 'Tier';
		$this->data['judul_sub'] = 'List';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$where = array();
		$this->data['tier'] = $this->access->readtable('tier','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('tier/tier_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_tier' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		$dt_product = '';
		$dt_product = $this->access->readtable('tier', '', array('id_tier' => $_POST['id']))->row();
		$simpan = array(			
			'nama_tier'		=> $dt_product->nama_tier,			
			'diskon'		=> $dt_product->diskon			
		);
		$simpan += array('id_tier'=>$_POST['id'],'ket'=>'Delete Tier','update_by'=>$this->session->userdata('operator_id'));
		$this->access->inserttable('history_tier', $simpan);
		echo $this->access->updatetable('tier', $data, $where);
	}

	
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		$id_tier = isset($_POST['id_tier']) ? (int)$_POST['id_tier'] : 0;		
		$nama_tier = isset($_POST['nama_tier']) ? $_POST['nama_tier'] : '';
		$diskon = isset($_POST['diskon']) ? $_POST['diskon'] : '';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 1;
		
		$simpan = array(			
			'nama_tier'		=> $nama_tier,			
			'diskon'		=> $diskon			
		);
		
		$where = array();
		$save = 0;	
		if($id_tier > 0){
			$where = array('id_tier'=>$id_tier);
			$this->access->updatetable('tier', $simpan, $where);   
			$save = $id_tier;
			$simpan += array('id_tier'=>$save,'ket'=>'Update Tier','update_by'=>$this->session->userdata('operator_id'));
			$this->access->inserttable('history_tier', $simpan); 
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('tier', $simpan);  
			$simpan += array('id_tier'=>$save,'ket'=>'Create Tier','update_by'=>$this->session->userdata('operator_id'));
			$this->access->inserttable('history_tier', $simpan);  
		}  
		redirect(site_url('tier'));
	}
	
	public function history($id_tier=0) {	
		if(!$this->session->userdata('login') || !$this->session->userdata('tier')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Tier';
		$this->data['judul_utama'] = 'Tier';
		$this->data['judul_sub'] = 'History';
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$where = array();
		$sort = array('id','DESC');
		$select = array('history_tier.*','admin.fullname');
		$this->data['tier'] = $this->access->readtable('history_tier',$select,array('history_tier.deleted_at'=>null,'id_tier'=>$id_tier),array('admin'=>'admin.operator_id = history_tier.update_by'),'',$sort,'LEFT')->result_array();
		$this->data['isi'] = $this->load->view('tier/tier_log', $this->data, TRUE);
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

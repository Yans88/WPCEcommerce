<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_bank extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('master_bank')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Master Bank';
		$this->data['judul_utama'] = 'List';
		$this->data['judul_sub'] = 'Master Bank';
		$this->data['title_box'] = 'List of Master Bank';
		
		$this->data['master_payment'] = $this->access->readtable('master_bank','',array('master_bank.deleted_at'=>null))->result_array();			
		$this->data['isi'] = $this->load->view('bank_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function save(){		
		$save = '';
		$id_bank = isset($_POST['id_bank']) ? $_POST['id_bank'] : '';		
					
		$nama_bank = $_POST['nama_bank'];		
		$holder_name = $_POST['holder_name'];	
		$no_rek = $_POST['no_rek'];	
		
		$master_payment = 0;
		$data = array(			
			'nama_bank'		=> $nama_bank,			
			'holder_name'	=> $holder_name,			
			'no_rek'		=> $no_rek			
		);				
		$where = array();
		if(!empty($id_bank)){			
			$where = array('id_bank' => $id_bank);
			$save = $this->access->updatetable('master_bank', $data, $where);
		}else{
			$data += array('created_at' => date('Y-m-d H:i:s'));
			$save = $this->access->inserttable('master_bank', $data);
		}		
		echo $save;	
		
	}
	
	public function del(){	
		
		$data = array(			
			'deleted_at'	=> date('Y-m-d H:i:s')		
		);
		$where = array('id_bank'=> $_POST['id']);
		echo $this->access->updatetable('master_bank', $data, $where);
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

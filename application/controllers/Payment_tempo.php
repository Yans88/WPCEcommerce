<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_tempo extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('tempo_payment')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Payment Tempo';
		$this->data['judul_utama'] = 'List';
		$this->data['judul_sub'] = 'Payment Tempo';
		$this->data['title_box'] = 'List of Payment Tempo';
		
		$this->data['master_payment'] = $this->access->readtable('master_payment','',array('master_payment.deleted_at'=>null))->result_array();			
		$this->data['isi'] = $this->load->view('payment_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function save(){		
		if($this->session->userdata('level') != 1){
			$this->no_akses();
			return false;
		}
		
		$save = '';
		$id_payment = isset($_POST['id_payment']) ? $_POST['id_payment'] : '';		
					
		$convenience_fee = 0;				
		$payment_name = $_POST['payment_name'];		
		$type = $_POST['type'];	
		if($type == 1){
			$convenience_fee = isset($_POST['convenience_fee']) ? str_replace('.','',$_POST['convenience_fee']) : 0;	
		}
		if($type == 2){
			$convenience_fee = isset($_POST['convenience_fee']) ? str_replace(',','.',$_POST['convenience_fee']) : 0;	
		}
		$master_payment = 0;
		$data = array(			
			'nama_payment'	=> $payment_name,			
			'type'			=> $type,			
			'admin_fee'		=> $convenience_fee			
		);				
		$where = array();
		if(!empty($id_payment)){			
			$where = array('id_payment' => $id_payment);
			$save = $this->access->updatetable('master_payment', $data, $where);
		}else{
			$master_payment = $this->access->readtable('master_payment','',array('nama_payment'=>$payment_name,'deleted_at'=>null))->row();
			if(count($master_payment) > 0){
				$save = 'exist';
			}else{
				$data += array('created_at' => date('Y-m-d H:i:s'));
				$save = $this->access->inserttable('master_payment', $data);
				
			}
		}		
		echo $save;	
		
	}
	
	public function del(){	
		if($this->session->userdata('level') != 1){
			$this->no_akses();
			return false;
		}
		$data = array(			
			'deleted_at'	=> date('Y-m-d')		
		);
		$where = array('id_payment'=> $_POST['id']);
		echo $this->access->updatetable('master_payment', $data, $where);
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

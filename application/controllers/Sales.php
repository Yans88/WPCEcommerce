<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('area')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Sales';
		$this->data['judul_utama'] = 'Sales';
		$this->data['judul_sub'] = 'List';
		
		$this->data['sales'] = $this->access->readtable('sales','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('sales/sales_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	
	public function del(){
		if(!$this->session->userdata('login') || !$this->session->userdata('area')){
			$this->no_akses();
			return false;
		}
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_sales' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);
		
		echo $this->access->updatetable('sales', $data, $where);
	}

	
	
	
	public function simpan(){
		if(!$this->session->userdata('login') || !$this->session->userdata('area')){
			$this->no_akses();
			return false;
		}
		$tgl = date('Y-m-d H:i:s');
		$id_sales = isset($_POST['id_sales']) ? (int)$_POST['id_sales'] : 0;		
		$slp_code = isset($_POST['slp_code']) ? $_POST['slp_code'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		$nama_sales = isset($_POST['nama_sales']) ? $_POST['nama_sales'] : '';
		
		$simpan = array(			
			'slp_code'	    => $slp_code,
			'nama_sales'	=> $nama_sales,	
			'password'	    => $this->converter->encode($password)		
		);
		
		$where = array();
		$save = 0;
		$simpan_admin = array(
			'username'		=> $this->converter->encode($slp_code),
			'password'		=> $this->converter->encode($password),
			'fullname'		=> $slp_code,
			'email'			=> '',					
			'level'			=> 5		
		);	
		if($id_sales > 0){
			$where = array('id_sales'=>$id_sales);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$this->access->updatetable('sales', $simpan, $where);   
			$simpan_admin += array('modified_by' => $this->session->userdata('operator_id'));
			$this->access->updatetable('admin', $simpan_admin, array('id_sls' => $id_sales));
			$save = $id_sales;
		}else{
			$simpan += array('created_at'	=> $tgl,'created_by'=>$this->session->userdata('operator_id'));			
			$save = $this->access->inserttable('sales', $simpan);   
			$simpan_admin += array('id_sls'	=> $save,'create_user'	=> $this->session->userdata('operator_id'),'create_date' => date('Y-m-d'),'status' => 1);
			$this->access->inserttable('admin', $simpan_admin);	
		}  
		
		redirect(site_url('sales'));
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

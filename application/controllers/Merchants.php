<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Merchants extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('principal')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Principal';
		$this->data['judul_utama'] = 'Principal';
		$this->data['judul_sub'] = 'List';
		$this->data['merchants'] = $this->access->readtable('merchants','',array('merchants.deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('merchants/merchants_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_merchants' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('merchants', $data, $where);
	}
	
	public function detail($id_merchant){
		if(!$this->session->userdata('login') || !$this->session->userdata('principal')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Merchant';
		$this->data['judul_utama'] = 'Merchant';
		$this->data['judul_sub'] = 'Detail';
		$sort2 = array('id_saldo','DESC');
		
		$this->data['merchants'] = $this->access->readtable('merchants')->row();
		
		$this->data['isi'] = $this->load->view('merchants/merchant_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	
	public function add($id_merchant = 0){
		if($this->session->userdata('level') != 1){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Principal';
		$this->data['judul_utama'] = 'Principal';
		$this->data['judul_sub'] = 'Add';
		$merchants = '';
		if($id_merchant > 0){
			$this->data['judul_sub'] = 'Edit';
			$merchants = $this->access->readtable('merchants','',array('id_merchants'=>$id_merchant))->row();
		}
		$this->data['employee'] = $employee;
		$this->data['merchants'] = $merchants;
		$this->data['isi'] = $this->load->view('merchants/merchants_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	

	function simpan_merchant(){
		$id_merchants = isset($_POST['id_merchants']) ? (int)$_POST['id_merchants'] : 0;
		$nama_merchant = isset($_POST['nama_merchant']) ? $_POST['nama_merchant'] : '';		
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$username = isset($_POST['username']) ? strtolower($_POST['username']) : '';
		$password = isset($_POST['password']) ? $this->converter->encode(strtolower($_POST['password'])) : ''; 
		$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
		$kd_cust = isset($_POST['kd_cust']) ? $_POST['kd_cust'] : '';
		$config['upload_path']   = FCPATH.'/uploads/principle/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);	
		$simpan = array(			
			'nama_merchants'	=> $nama_merchant,
			'address'			=> $alamat,
			'email'				=> $email,
			'username'			=> $username,
			'password'			=> $password
		);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('photo'	=> $gambar);
        }
		$simpan_admin = array(
			'username'		=> $this->converter->encode($username),
			'password'		=> $password,
			'fullname'		=> $nama_merchant,
			'email'			=> $email,
			'level'			=> 2
			
		);
		
		$save = 0;
		if($id_merchants > 0){			
			$this->access->updatetable('merchants', $simpan, array('id_merchants' => $id_merchants));
			$simpan_admin += array('modified_by' => $this->session->userdata('operator_id'));
			$this->access->updatetable('admin', $simpan_admin, array('id_merchant' => $id_merchants));
			$save = $id_merchants;
		}else{			
			$simpan += array('created_at' => date('Y-m-d H:i:s'),'saldo'=>0,'kd_cust'=>$kd_cust);			
			$save = $this->access->inserttable('merchants', $simpan);
			$simpan_admin += array('id_merchant' => $save,'create_user'	=> $this->session->userdata('operator_id'),'create_date' => date('Y-m-d'),'status' => 1);
			$this->access->inserttable('admin', $simpan_admin);	
		}
		if($save > 0){
			redirect(site_url('merchants'));
		}	
	}
	
	function transaksi($id_merchant = 0){
		if(!$this->session->userdata('login') || !$this->session->userdata('principal')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Detail';
		$this->data['transaksi'] = $this->access->readtable('transaksi', '',array('transaksi.id_merchant'=>$id_merchant), array('merchants'=>'merchants.id_merchants =  transaksi.id_merchant','members'=>'members.id_member = transaksi.id_member'),'','','LEFT')->result_array();
		
		$this->data['isi'] = $this->load->view('merchants/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function chk_email(){
		$email = $this->input->post('email');
		$dt = $this->access->readtable('merchants','',array('email'=>$email,'deleted_at'=>null))->row(); 
		$dt_cnt = count($dt) > 0 ? 'Email_'.$dt->id_merchants : 0;
		echo $dt_cnt;
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

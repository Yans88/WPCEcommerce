<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);					
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Level-Role';
		$this->data['judul_utama'] = 'Level-Role';
		$this->data['judul_sub'] = 'List';
		$this->data['title_box'] = 'List of Level';
		$field_notin = 'id';
		$where_notin = array(5,2);
		$this->data['level'] = $this->access->readtable('level','',array('level.deleted_at'=>null),'','','','','','','','','','','', $field_notin,$where_notin)->result_array();			
		$this->data['isi'] = $this->load->view('level_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function add($id_level=null) {
		if(!$this->session->userdata('login') || !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}
		$this->data['level'] = '';	
		$this->data['judul_browser'] = 'Level-Role';
		$this->data['judul_utama'] = 'Level-Role';
		$this->data['judul_sub'] = 'List';
		$this->data['title_box'] = 'List of Level';
		if(!empty($id_level) && $id_level != 2){
			$this->data['level'] = $this->access->readtable('level','',array('deleted_at'=>null,'id'=>$id_level))->row();
		}
		
		$this->data['isi'] = $this->load->view('level_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function save(){		
		if(!$this->session->userdata('login') || !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}
		$save =0;
		$id_level = isset($_POST['id_level']) ? (int)$_POST['id_level'] : '0';		
		$level_name = isset($_POST['level_name']) ? $_POST['level_name'] : '';				
		$principal = isset($_POST['principal']) ? (int)$_POST['principal'] : '0';
		$category = isset($_POST['category']) ? (int)$_POST['category'] : '0';
		$product = isset($_POST['product']) ? (int) $_POST['product'] : '0';
		$paket = isset($_POST['paket']) ? (int)$_POST['paket'] : '0';
		$members = isset($_POST['members']) ? (int)$_POST['members'] : '0';
		$chat = isset($_POST['chat']) ? (int)$_POST['chat'] : '0';
		$waiting_payment = isset($_POST['waiting_payment']) ? (int)$_POST['waiting_payment'] : '0';
		$payment_complete = isset($_POST['payment_complete']) ? (int)$_POST['payment_complete'] : '0';
		$dikirim = isset($_POST['dikirim']) ? (int)$_POST['dikirim'] : '0';
		$sampai_tujuan = isset($_POST['sampai_tujuan']) ? (int)$_POST['sampai_tujuan'] : '0';
		$complete = isset($_POST['complete']) ? (int)$_POST['complete'] : '0';
		$reject = isset($_POST['reject']) ? (int)$_POST['reject'] : '0';
		$tagihan = isset($_POST['tagihan']) ? (int)$_POST['tagihan'] : '0';		
		$angsuran = isset($_POST['angsuran']) ? (int)$_POST['angsuran'] : '0';
		$reporting = isset($_POST['reporting']) ? (int)$_POST['reporting'] : '0';
		$master_bank = isset($_POST['master_bank']) ? (int)$_POST['master_bank'] : '0';
		$tempo_payment = isset($_POST['tempo_payment']) ? (int)$_POST['tempo_payment'] : '0';
		$banner = isset($_POST['banner']) ? (int)$_POST['banner'] : '0';
		$area = isset($_POST['area']) ? (int)$_POST['area'] : '0';
		$brand = isset($_POST['brand']) ? (int)$_POST['brand'] : '0';
		$tier = isset($_POST['tier']) ? (int)$_POST['tier'] : '0';
		$province = isset($_POST['province']) ? (int)$_POST['province'] : '0';
		$level_role = isset($_POST['level_role']) ? (int)$_POST['level_role'] : '0';
		$users = isset($_POST['users']) ? (int)$_POST['users'] : '0';
		$setting = isset($_POST['setting']) ? (int)$_POST['setting'] : '0';
		$data = array(
			'level_name'		=> $level_name,
			'principal'			=> $principal,
			'category'			=> $category,
			'product'			=> $product,
			'paket'				=> $paket,
			'members'			=> $members,
			'chat'				=> $chat,
			'waiting_payment'	=> $waiting_payment,
			'payment_complete'	=> $payment_complete,
			'dikirim'			=> $dikirim,
			'sampai_tujuan'		=> $sampai_tujuan,
			'complete'			=> $complete,
			'reject'			=> $reject,
			'tagihan'			=> $tagihan,
			'angsuran'			=> $angsuran,
			'reporting'			=> $reporting,
			'master_bank'		=> $master_bank,
			'tempo_payment'		=> $tempo_payment,
			'banner'			=> $banner,
			'area'				=> $area,
			'brand'				=> $brand,
			'tier'				=> $tier,
			'province'			=> $province,
			'level_role'		=> $level_role,
			'users'				=> $users,
			'setting'			=> $setting
		);
		$where = array();
		$tgl = date('Y-m-d H:i:s');
		$operator_id = $this->session->userdata('operator_id');
		if($id_level > 0 && $id_level != 2){
			
			$where = array('id'=>$id_level);
			$this->access->updatetable('level',$data, $where);
			$save = $id_level;
		}else{
			$data += array('created_by' => $operator_id, 'created_at' => $tgl);
			$save = $this->access->inserttable('level', $data);
		}
	
		echo $save;
	}
	
	public function del(){	
		if(!$this->session->userdata('login') || !$this->session->userdata('level_role')){
			$this->no_akses();
			return false;
		}		
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl,
			'deleted_by'	=> $this->session->userdata('operator_id')
		);		
		echo $this->access->updatetable('level', $data, $where);
	}
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}


}

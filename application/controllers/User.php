<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('users')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'User';
		$this->data['judul_utama'] = 'List';
		$this->data['judul_sub'] = 'Users';
		$this->data['title_box'] = 'List of users';
		$field_notin = 'id';
		$where_notin = array(5,2);	
		$this->data['level'] = $this->access->readtable('level','',array('level.deleted_at'=>null),'','','','','','','','','','','', $field_notin,$where_notin)->result_array();
		$field_notin = 'admin.level';	
		$this->data['users'] = $this->access->readtable('admin','',array('admin.deleted_at'=>null),'','','','','','','','','','','', $field_notin,$where_notin)->result_array();		
		$this->data['isi'] = $this->load->view('user_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function save(){		
		if(!$this->session->userdata('login') || !$this->session->userdata('users')){
			$this->no_akses();
			return false;
		}
		
		$save =0;
		$id_user = isset($_POST['id_user']) ? $_POST['id_user'] : '';		
		$fullname = $_POST['fullname'];				
		$email = $_POST['email'];
		$status = $_POST['status'];
		$level = $_POST['level'];
		$username = $this->converter->encode(strtolower($_POST['username']));
		$password = isset($_POST['password']) ? $this->converter->encode($_POST['password']) : '';	
		$te = '';
		$_id_te = '';
		$te = $this->access->readtable('admin','',array('username' => $username,'deleted_at' => null))->row();
		$_id_te = count($te) > 0 ? $te->operator_id : 0;
		if(count($te) > 0 && $id_user != $_id_te){
			$save = 'taken';
			echo $save;
			return false;
		}
		$data = array(			
			'username'		=> $username,
			'fullname'		=> $fullname,
			'email'			=> $email,
			'level'			=> 1,
			'status'		=> $status	
		);
		if(!empty($password)){
			$data += array('password' => $password);
		}		
		$where = array();
		if(!empty($id_user)){
			$data += array('modified_by'	=> $this->session->userdata('operator_id'));			
			$where = array('operator_id'=>$id_user);
			$save = $this->access->updatetable('admin', $data, $where);
		}else{
			$data += array('create_date' => date('Y-m-d'), 'create_user' => $this->session->userdata('operator_id'));
			$save = $this->access->inserttable('admin', $data);
		}		
		echo $save;	
		
	}
	
	public function del(){	
		if(!$this->session->userdata('login') || !$this->session->userdata('users')){
			$this->no_akses();
			return false;
		}
		$data = array(			
			'deleted_at'	=> date('Y-m-d')		
		);
		$where = array('operator_id'=> $_POST['id']);
		echo $this->access->updatetable('admin', $data, $where);
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

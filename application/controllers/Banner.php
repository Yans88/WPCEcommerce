<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('banner')){
			$this->no_akses();
			return false;
		}	
		$this->data['judul_browser'] = 'Banner';
		$this->data['judul_utama'] = 'Banner';
		$this->data['judul_sub'] = 'List';
		$this->data['category'] = $this->access->readtable('banner','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('banner/banner_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
		
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_banner' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('banner', $data, $where);
	}
	
	
	public function simpan_cat(){
		$tgl = date('Y-m-d H:i:s');
		$id_category = isset($_POST['id_category']) ? (int)$_POST['id_category'] : 0;
		$config['upload_path']   = FCPATH.'/uploads/banner/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array();
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }	
		$where = array();
		$save = 0;	
		if($id_category > 0){
			$where = array('id_banner'=>$id_category);
			$save = $this->access->updatetable('banner', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('banner', $simpan);   
		}  
		redirect(site_url('banner'));
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

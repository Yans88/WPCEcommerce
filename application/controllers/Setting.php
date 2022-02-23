<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Setting_m');
		$this->load->helper('form');
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('setting')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'GTS';	
		$out = array ();
		$out['tersimpan'] = '';
		
		if ($this->input->post('submit')) {
			if($this->Setting_m->simpan()) {
				$out['tersimpan'] = 'Y';
			} else {
				$out['tersimpan'] = 'N';
			}
		}
		$opsi_val_arr = $this->Setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}
		
		$this->data['isi'] = $this->load->view('form_setting_v', $out, TRUE);

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

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	public $data = array();

	public function __construct() {

		parent::__construct();
		

		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
		} else {
			// $level = '';
			$this->data['u_name'] = $this->session->userdata('u_name');
			$this->data['_operator_id'] = $this->session->userdata('operator_id');
			$this->data['_LEVEL'] = $this->session->userdata('level');
			$this->data['l_evel'] = $this->session->userdata('level_name');
			$this->data['_PRINCIPAL'] = $this->session->userdata('principal');
			$this->data['_CATEGORY'] = $this->session->userdata('category');
			$this->data['_PRODUCT'] = $this->session->userdata('product');
			$this->data['_PACKET'] = $this->session->userdata('paket');
			$this->data['_MEMBERS'] = $this->session->userdata('members');
			$this->data['_CHAT'] = $this->session->userdata('chat');
			$this->data['_WP'] = $this->session->userdata('waiting_payment');
			$this->data['_PC'] = $this->session->userdata('payment_complete');
			$this->data['_DIKIRIM'] = $this->session->userdata('dikirim');
			$this->data['_ST'] = $this->session->userdata('sampai_tujuan');
			$this->data['_COMPLETE'] = $this->session->userdata('complete');
			$this->data['_REJECT'] = $this->session->userdata('reject');
			$this->data['_TAGIHAN'] = $this->session->userdata('tagihan');
			$this->data['_ANGS'] = $this->session->userdata('angsuran');
			$this->data['_REPORTING'] = $this->session->userdata('reporting');
			$this->data['_MB'] = $this->session->userdata('master_bank');
			$this->data['_TP'] = $this->session->userdata('tempo_payment');
			$this->data['_AREA'] = $this->session->userdata('area');
			$this->data['_BRAND'] = $this->session->userdata('brand');
			$this->data['_TIER'] = $this->session->userdata('tier');
			$this->data['_PROVINCE'] = $this->session->userdata('province');
			$this->data['_LR'] = $this->session->userdata('level_role');
			$this->data['_SETTING'] = $this->session->userdata('setting');
			$this->data['_BANNER'] = $this->session->userdata('banner');
			$this->data['_USERS'] = $this->session->userdata('users');
			$this->data['isi'] = '';
			$this->data['judul_browser'] = '';
			$this->data['judul_utama'] = '';
			$this->data['judul_sub'] = '';
			$this->data['link_aktif'] = '';
			$this->data['css_files'] = array();
			$this->data['js_files'] = array();
			$this->data['js_files2'] = array();

		}
	}
}



<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public $data = array ('pesan' => '');
	
	public function __construct () {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Login_m','login', TRUE);
	}
	
	public function index() {
		// status user login = BENAR, pindah ke halaman home
		
		if ($this->session->userdata('login') == TRUE) {
			redirect('product');
		} else {
			// status login salah, tampilkan form login
			// validasi sukses
			if($this->login->validasi()) {
				// cek di database sukses
				if($this->login->cek_user()) {
					redirect('home');
					// if($this->session->userdata('product') > 0)	redirect('product');
					// if($this->session->userdata('paket') > 0)	redirect('paket');
					// if($this->session->userdata('category') > 0)	redirect('category');
					// if($this->session->userdata('principal') > 0)	redirect('merchants');
					// if($this->session->userdata('members') > 0)	redirect('members');
					// if($this->session->userdata('chat') > 0)	redirect('chat');
					// if($this->session->userdata('waiting_payment') > 0)	redirect('transaksi/waiting_payment');
					// if($this->session->userdata('payment_complete') > 0)	redirect('transaksi/appr');
					// if($this->session->userdata('dikirim') > 0)	redirect('transaksi/in_progress');
					// if($this->session->userdata('sampai_tujuan') > 0)	redirect('transaksi/sampai');
					// if($this->session->userdata('complete') > 0)	redirect('transaksi/complete');
					// if($this->session->userdata('reject') > 0)	redirect('transaksi/reject');
					// if($this->session->userdata('tagihan') > 0)	redirect('tagihan');
					// if($this->session->userdata('angsuran') > 0)	redirect('tagihan/angs');
					// if($this->session->userdata('reporting') > 0)	redirect('reporting');
					// if($this->session->userdata('master_bank') > 0)	redirect('master_bank');
					// if($this->session->userdata('tempo_payment') > 0)	redirect('payment_tempo');
					// if($this->session->userdata('area') > 0)	redirect('area');
					// if($this->session->userdata('brand') > 0)	redirect('brand');
					// if($this->session->userdata('province') > 0)	redirect('province');
					// if($this->session->userdata('level_role') > 0)	redirect('role');
					// if($this->session->userdata('users') > 0)	redirect('users');
					// if($this->session->userdata('setting') > 0)	redirect('setting');
				} else {
					// cek database gagal
					$this->data['pesan'] = 'Username atau Password salah.';
				}
			} else {
				// validasi gagal
         }
        
         $this->load->view('themes/login_form_v', $this->data);
		}
	}
	
	// function test(){
		// redirect('home');
	// }

	public function logout() {
		// $this->login->logout();
		$this->session->sess_destroy();
		$this->session->unset_userdata(array('u_name' => '', 'login' => FALSE));
		
		redirect('/');
	}
}
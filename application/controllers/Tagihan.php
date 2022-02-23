<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tagihan extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);	
	}	
	
	public function index() {
		
		if(!$this->session->userdata('login') || !$this->session->userdata('tagihan')){
			$this->no_akses();
			return false;
		}
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : '';
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : '';
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Tagihan';
		$this->data['judul_utama'] = 'Tagihan';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Tagihan';
		$this->data['status'] = 1;
		$where = array('transaksi.status'=>3, 'transaksi.status_tempo < '=>1, 'transaksi.payment > '=>1);
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d', strtotime($to)));
		}
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where)->result_array();
		// error_log($this->db->last_query());
		$this->data['url_report'] = site_url('transaksi/payment');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function angs(){
		
		if(!$this->session->userdata('login') || !$this->session->userdata('angsuran')){
			$this->no_akses();
			return false;
		}
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : '';
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : '';
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Angsuran';
		$this->data['judul_utama'] = 'Angsuran';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Angsuran';
		$this->data['status'] = 1;
		$_tgl = date('Y-m-d');
		$where = array('tagihan.status < '=>1,'tagihan.tgl_tempo <= '=> date('Y-m-d', strtotime($_tgl)));
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('tagihan.id_principle' => $id_merchant);
		}
		// if(!empty($from) && !empty($to)){
			// $where += array('transaksi.create_at >= ' => date('Y-m-d', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d', strtotime($to)));
		// }
		$this->data['tagihan'] = $this->access->readtable('tagihan', '', $where,array('transaksi'=> 'transaksi.id_transaksi = tagihan.id_transaksi','members'=>'members.id_member = tagihan.id_member'),'','','LEFT')->result_array();
		
		$this->data['url_report'] = site_url('transaksi/payment');
		
		$this->data['isi'] = $this->load->view('transaksi/angsuran_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	
	public function tempo(){
		
		if(!$this->session->userdata('login') && !$this->session->userdata('member')){
			$this->no_akses();
			return false;
		}
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : '';
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : '';
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi Approved';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Transaksi';
		// $this->data['status'] = 2;
		$where = array('transaksi.payment'=>2);
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d', strtotime($to)));
		}
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where)->result_array();
		// error_log($this->db->last_query());
		$this->data['url_report'] = site_url('transaksi/tempo');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	public function reject(){
		
		if(!$this->session->userdata('login') && !$this->session->userdata('member')){
			$this->no_akses();
			return false;
		}
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : '';
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : '';
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi Approved';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Transaksi';
		$this->data['status'] = 2;
		$where = array('transaksi.status'=>2);
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d', strtotime($to)));
		}
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where)->result_array();
		// error_log($this->db->last_query());
		$this->data['url_report'] = site_url('transaksi/reject');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function byr_angs(){
		$tgl = date('Y-m-d H:i:s');		
		$id_transaksi = '';
		$id_transaksi = (int)$this->converter->decode($_POST['id']);
		$nilai = $_POST['nilai'];
		$dt_transaksi = $this->access->readtable('transaksi', '', array('transaksi.id_transaksi' => $id_transaksi))->row();
		$dt_tagihan = $this->access->readtable('tagihan', '', array('tagihan.id_transaksi' => $id_transaksi, 'status >' => 0),'',1,array('angs_ke','DESC'))->row();
		error_log($this->db->last_query());
		$last_angs = 0;
		$angs_ke = 0;
		$save = 0;
		$last_angs = (int)$dt_tagihan->angs_ke > 0 ? (int)$dt_tagihan->angs_ke : 0;
		error_log($last_angs);
		for($i=1;$i<=$nilai;$i++){
			$angs_ke = 0;
			$angs_ke = $last_angs + $i;
			error_log('angs_ke '.$angs_ke);
			$this->access->updatetable('tagihan',array('status'=>1,'status_by' => $this->session->userdata('operator_id'),'status_date'=>$tgl), array('id_transaksi' => $id_transaksi,'angs_ke'=>$angs_ke));
			error_log($this->db->last_query());
			if($angs_ke == (int)$dt_transaksi->tempo){
				$this->access->updatetable('transaksi',array('sdh_byr'=>$angs_ke,'status_tempo'=>1), array('id_transaksi' => $id_transaksi));		
			}else{
				$this->access->updatetable('transaksi',array('sdh_byr'=>$angs_ke), array('id_transaksi' => $id_transaksi));
			}
			$save = $id_transaksi;
		}
		echo $save;
	}
	
	function upd_status(){
		$tgl = date('Y-m-d H:i:s');		
		$id_transaksi = '';
		$id_transaksi = (int)$this->converter->decode($_POST['id']);
		$dt_transaksi = $this->access->readtable('transaksi', '', array('transaksi.id_transaksi' => $id_transaksi))->row();		
		$id_member = $dt_transaksi->id_member;
		$id_principle = $dt_transaksi->id_principle;
		$sisa_credit = 0;
		$use_credit = 0;
		$ttl = 0;
		$simpan = array();
		if($dt_transaksi->payment == 2 && $_POST['nilai'] == 2){
			$ttl = $dt_transaksi->ttl_all;
			$dt_members = $this->access->readtable('members', '', array('id_member' => $id_member))->row();
			$sisa_credit = 0;
			$use_credit = 0;
			$sisa_credit = $dt_members->sisa_credit + $ttl;
			$use_credit = $dt_members->use_credit - $ttl;
			$this->access->updatetable('members',array('sisa_credit'=>$sisa_credit,'use_credit' => $use_credit), array('id_member' => $id_member));	
		}
		$tgl_tempo = '';
		$dt_tempo = array();
		$this->db->trans_begin();
		if($dt_transaksi->payment == 2 && $_POST['nilai'] == 3){
			$kode_payment = '';			
			$angs = $dt_transaksi->angs;
			$tempo = $dt_transaksi->tempo;
			$kode_payment = $id_transaksi.''.date('ymdHi');
			$simpan += array('tgl_jth_tempo' => $tgl,'kode_payment' => $kode_payment);
			for($i=1;$i<=(int)$tempo;$i++){
				$_tgl = date('Y-m-d');
				$_tgl = strtotime(date("Y-m-d", strtotime($_tgl))." +$i month");	
				$tgl_tempo = date('Y-m-d', $_tgl);				
				$dt_tempo[] = array(
					'id_transaksi'	=> $id_transaksi,
					'kode_payment'	=> $kode_payment,
					'id_member'		=> $id_member,
					'id_principle'	=> $id_principle,
					'angs_ke'		=> $i,
					'angsuran'		=> $angs,
					'tgl_tempo'		=> $tgl_tempo,
					'created_at'	=> $tgl
				);
			}
			$this->db->insert_batch('tagihan', $dt_tempo);
		}
		$where = array(
			'id_transaksi' => $id_transaksi
		);
		$simpan += array(
			'status'		=> $_POST['nilai'],
			'appr_rej_date'	=> $tgl,
			'appr_rej_by'	=> $this->session->userdata('operator_id')
		);
		echo $this->access->updatetable('transaksi', $simpan, $where);	
		$this->db->trans_commit();	
	}
	
	
	
	
	function detail($id_transaksi=''){
		$id_transaksi = (int)$this->converter->decode($id_transaksi);
		$this->data['transaksi'] = $this->access->readtable('transaksi','', array('transaksi.id_transaksi' => $id_transaksi))->row();
		$this->data['transaksi_detail'] = $this->access->readtable('transaksi_detail','',array('id_trans'=>$id_transaksi))->result_array();
		$this->data['tagihan'] = $this->access->readtable('tagihan','',array('id_transaksi'=>$id_transaksi))->result_array();
		$this->data['judul_browser'] = 'Transaksi detail';
		$this->data['judul_utama'] = 'Transaksi detail';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'Transaksi detail';
		$this->data['isi'] = $this->load->view('transaksi/transaksi_detail', $this->data, TRUE);
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
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	

}

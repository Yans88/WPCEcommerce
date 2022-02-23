<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);
		$this->load->library('send_notif');		
	}	
	
	public function _index() {
		
		if(!$this->session->userdata('login') && !$this->session->userdata('member')){
			$this->no_akses();
			return false;
		}
		$date_now = date('d-m-Y');
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : $date_now;
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : $date_now;
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi Approved';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Transaksi';
		$this->data['status'] = 'payment';
		// $this->data['payment'] = 0;
		$where = array();
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d', strtotime($to)));
		}
		$sort = array('transaksi.id_transaksi','DESC');
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where,'','',$sort)->result_array();
		
		$this->data['url_report'] = site_url('transaksi/payment');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_vv', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function payment(){
		
		if(!$this->session->userdata('login') || !$this->session->userdata('waiting_payment')){
			$this->no_akses();
			return false;
		}
		$_t = date('Y-m-d H:i');
		$_f = date('Y-m-d').' 00:00';
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : $_f;
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : $_t;
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi Approved';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Transaksi';
		$this->data['status'] = 'payment';
		$this->data['payment'] = 0;
		$where = array('transaksi.status'=>0);
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d H:i', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d H:i', strtotime($to)));
		}
		$sort = array('transaksi.id_transaksi','DESC');
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where,'','',$sort)->result_array();
		
		$this->data['url_report'] = site_url('transaksi/payment');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function appr(){
		
		if(!$this->session->userdata('login') || !$this->session->userdata('payment_complete')){
			$this->no_akses();
			return false;
		}
		$_t = date('Y-m-d H:i');
		$_f = date('Y-m-d').' 00:00';
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : $_f;
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : $_t;
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi Approved';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Transaksi';
		$this->data['status'] = 3;
		$this->data['payment'] = 0;
		$where = array('transaksi.status'=>3);
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d H:i', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d H:i', strtotime($to)));
		}
		$sort = array('transaksi.id_transaksi','DESC');
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where,'','',$sort)->result_array();
		// error_log($this->db->last_query());
		$this->data['url_report'] = site_url('transaksi/appr');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function in_progress(){
		
		if(!$this->session->userdata('login') || !$this->session->userdata('dikirim')){
			$this->no_akses();
			return false;
		}
		$_t = date('Y-m-d H:i');
		$_f = date('Y-m-d').' 00:00';
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : $_f;
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : $_t;
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi Approved';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Transaksi';
		$this->data['status'] = 4;
		$this->data['payment'] = 0;
		$where = array('transaksi.status'=>4);
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d H:i', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d H:i', strtotime($to)));
		}
		$sort = array('transaksi.id_transaksi','DESC');
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where,'','',$sort)->result_array();
		// error_log($this->db->last_query());
		$this->data['url_report'] = site_url('transaksi/in_progress');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function sampai(){
		
		if(!$this->session->userdata('login') || !$this->session->userdata('sampai_tujuan')){
			$this->no_akses();
			return false;
		}
		$_t = date('Y-m-d H:i');
		$_f = date('Y-m-d').' 00:00';
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : $_f;
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : $_t;
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi Approved';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Transaksi';
		$this->data['status'] = 5;
		$this->data['payment'] = 0;
		$where = array('transaksi.status'=>5);
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d H:i', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d H:i', strtotime($to)));
		}
		$sort = array('transaksi.id_transaksi','DESC');
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where,'','',$sort)->result_array();
		// error_log($this->db->last_query());
		$this->data['url_report'] = site_url('transaksi/sampai');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function complete(){
		
		if(!$this->session->userdata('login') || !$this->session->userdata('complete')){
			$this->no_akses();
			return false;
		}
		$_t = date('Y-m-d H:i');
		$_f = date('Y-m-d').' 00:00';
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : $_f;
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : $_t;
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi Approved';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Transaksi';
		$this->data['status'] = 6;
		$this->data['payment'] = 0;
		$where = array('transaksi.status'=>6);
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d H:i', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d H:i', strtotime($to)));
		}
		$sort = array('transaksi.id_transaksi','DESC');
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where,'','',$sort)->result_array();
		// error_log($this->db->last_query());
		$this->data['url_report'] = site_url('transaksi/complete');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	public function cash(){
		
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
		$this->data['payment'] = 1;
		$this->data['status'] = 0;
		$where = array('transaksi.payment'=>1);
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d H:i', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d H:i', strtotime($to)));
		}
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where)->result_array();
		// error_log($this->db->last_query());
		$this->data['url_report'] = site_url('transaksi/cash');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
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
		$this->data['status'] = 0;
		$this->data['payment'] = 1;
		$where = array('transaksi.payment'=>2);
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d H:i', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d H:i', strtotime($to)));
		}
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where)->result_array();
		// error_log($this->db->last_query());
		$this->data['url_report'] = site_url('transaksi/tempo');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}	
	
	public function reject(){		
		if(!$this->session->userdata('login') || !$this->session->userdata('reject')){
			$this->no_akses();
			return false;
		}
		$_t = date('Y-m-d H:i');
		$_f = date('Y-m-d').' 00:00';
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : $_f;
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : $_t;
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi Approved';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Transaksi';
		$this->data['status'] = 2;
		$where = array('transaksi.status'=>2);
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d H:i', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d H:i', strtotime($to)));
		}
		$sort = array('transaksi.id_transaksi','DESC');
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where,'','',$sort)->result_array();
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
		$last_angs = 0;
		$angs_ke = 0;
		$save = 0;
		$last_angs = (int)$dt_tagihan->angs_ke > 0 ? (int)$dt_tagihan->angs_ke : 0;		
		for($i=1;$i<=$nilai;$i++){
			$angs_ke = 0;
			$angs_ke = $last_angs + $i;
			$this->access->updatetable('tagihan',array('status'=>1,'status_by' => $this->session->userdata('operator_id'),'status_date'=>$tgl), array('id_transaksi' => $id_transaksi,'angs_ke'=>$angs_ke));
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
		$transaksi_detail = '';
		$id_transaksi = (int)$this->converter->decode($_POST['id']);
		$dt_transaksi = $this->access->readtable('transaksi', '', array('transaksi.id_transaksi' => $id_transaksi))->row();		
		$id_member = $dt_transaksi->id_member;
		$id_principle = $dt_transaksi->id_principle;
		$sisa_credit = 0;
		$use_credit = 0;
		$ttl = 0;
		$simpan = array();
		$pesan_fcm = '';
		$this->db->trans_begin();
		$dt_members = $this->access->readtable('members', '', array('id_member' => $id_member))->row();
		if($_POST['nilai'] == 2){
			$ttl = $dt_transaksi->ttl_all;			
			$transaksi_detail = $this->access->readtable('transaksi_detail', '', array('id_trans' => $id_transaksi))->result_array();
			$pesan_fcm = 'Pesanan direject';
			if(!empty($transaksi_detail)){
				foreach($transaksi_detail as $td){
					$id_produk = 0;
					$jml = 0;
					$id_produk = (int)$td['id_product'];
					$id_whs = (int)$td['id_whs'];
					$jml = (int)$td['jml'];
					$dt_product = '';					
					$stok = 0;
					
					if($jml > 0 && $id_produk > 0){
						$dt_product = $this->access->readtable('stok', '', array('id_product' => $id_produk,'deleted_at'=>null,'id_wh'=>$id_whs))->row();
						$stok = (int)$dt_product->stok > 0 ? (int)$dt_product->stok : 0;
						$stok = $stok + $jml;
						$this->access->updatetable('stok', array('stok' => $stok), array('id_product' => $id_produk,'deleted_at'=>null,'id_wh'=>$id_whs));
						error_log($this->db->last_query());
						$dt_product = '';
						// $dt_product = $this->access->readtable('product', '', array('id_product' => $id_produk))->row();
						// $simpan = array(			
							// 'nama_barang'		=> $dt_product->nama_barang,
							// 'id_kategori'		=> $dt_product->id_kategori,	
							// 'deskripsi'			=> $dt_product->deskripsi,	
							// 'harga'				=> $dt_product->harga,
							// 'paket'				=> $dt_product->paket,
							// 'qty'				=> $dt_product->qty,
							// 'diskon'			=> $dt_product->diskon,
							// 'id_area'			=> $dt_product->id_area,
							// 'id_brand'			=> $dt_product->id_brand,
							// 'id_merchant'		=> $dt_product->id_merchant
						// );
						// $simpan += array('id_product'=>$id_produk,'type'=>2,'ket'=>'Return transaksi '.$id_trans.' sebanyak : '.$jml,'update_by'=>$this->session->userdata('operator_id'));
						// $this->access->inserttable('history_product', $simpan);
					}
				}
			}
			$sisa_credit = 0;
			$use_credit = 0;
			$sisa_credit = $dt_members->sisa_credit + $ttl;
			$use_credit = $dt_members->use_credit - $ttl;
			$this->access->updatetable('members',array('sisa_credit'=>$sisa_credit,'use_credit' => $use_credit), array('id_member' => $id_member));	
		}
		$tgl_tempo = '';
		$dt_tempo = array();
		
		if($dt_transaksi->payment == 2 && $_POST['nilai'] == 3){
			$kode_payment = '';			
			$angs = $dt_transaksi->angs;
			$tempo = $dt_transaksi->tempo;
			$kode_payment = $id_transaksi.''.date('ymdHi');
			$simpan += array('tgl_jth_tempo' => $tgl,'kode_payment' => $kode_payment);
			$pesan_fcm = 'Pesanan diproses';
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
		if($_POST['nilai'] == 4) $pesan_fcm = "Pesanan di proses";
		if($_POST['nilai'] == 5){
			$pesan_fcm = 'Pesanan telah sampai';
			$_dt = array();
			$_tgll = '';
			$_tgll = date('Y-m-d H:i', strtotime("+3 days"));
		
			$_dt = array(
				'id_trans'		=> $id_transaksi,
				'completed_at'	=> $_tgll
			);
			$this->access->inserttable('id_trans_auto', $_dt);	
			
		}
		$where = array(
			'id_transaksi' => $id_transaksi
		);
		$simpan += array(
			'status'		=> $_POST['nilai'],
			'appr_rej_date'	=> $tgl,
			'appr_rej_by'	=> $this->session->userdata('operator_id')
		);
		$data_fcm = array(
				'id_notif'	=> $id_transaksi,
				'title'			=> 'GTS',
				'status'		=> $_POST['nilai'],	
				'message' 		=> $pesan_fcm,
				'notif_type' 	=> '2'
			);
		$notif_fcm = array(
				'body'			=> $pesan_fcm,
				'title'			=> 'GTS',
				'badge'			=> '1',
				'sound'			=> 'Default'
		);	
		$ids = array($dt_members->gcm_token);
		if(!empty($ids)){
			$send_fcms = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);	
			$dtt =array();
			$dtt =array(
				'id_member'		=> $id_member,
				'id_transaksi'	=> $id_transaksi,
				'fcm_token'		=> $dt_members->gcm_token,
				'created_at'	=> $tgl,
				'type'			=> 2
			);
			$this->access->inserttable('history_notif', $dtt); 
		}
		echo $this->access->updatetable('transaksi', $simpan, $where);	
	
		$this->db->trans_commit();
			
	}
		
	
	function detail($id_transaksi=''){
		$id_transaksi = (int)$this->converter->decode($id_transaksi);
		$this->data['transaksi'] = $this->access->readtable('transaksi','', array('transaksi.id_transaksi' => $id_transaksi))->row();
		$this->data['transaksi_detail'] = $this->access->readtable('transaksi_detail','',array('id_trans'=>$id_transaksi))->result_array();
		$this->data['paket_detail'] = $this->access->readtable('transaksi_paket_detail','',array('id_trans'=>$id_transaksi))->result_array();
		$this->data['tagihan'] = $this->access->readtable('tagihan','',array('id_transaksi'=>$id_transaksi))->result_array();
		$this->data['judul_browser'] = 'Transaksi detail';
		$this->data['judul_utama'] = 'Transaksi detail';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'Transaksi detail';
		$this->data['isi'] = $this->load->view('transaksi/transaksi_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function export_r(){
		$tgl = date('dmY');
		$this->load->library('excel');
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : '';
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : '';
		$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
		$payment = isset($_REQUEST['payment']) ? (int)$_REQUEST['payment'] : 0;
		$where = array();
		$status_name = '';
		$dates = '';
		if($payment > 0){
			$where = array('transaksi.payment'=>$payment);		
		}
		if($status > 0 || $status == 'payment'){
			if($status == 'payment'){
				$status = 0;
			}
			$where = array('transaksi.status'=>$status);		
		}
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d H:i', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d H:i', strtotime($to)));
		}
		$transaksi = $this->access->readtable('transaksi', '', $where)->result_array();
		
	
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		
		
		$this->excel->getActiveSheet()->getStyle('A1:H1')->getFont()->setSize(12);		
		
		$this->excel->getActiveSheet()->setCellValue('A1', 'DocNum');
		$this->excel->getActiveSheet()->setCellValue('B1', 'DocDate');
        $this->excel->getActiveSheet()->setCellValue('C1', 'DocDueDate');
        $this->excel->getActiveSheet()->setCellValue('D1', 'CardCode');
        $this->excel->getActiveSheet()->setCellValue('E1', 'DocCurrency');
		$this->excel->getActiveSheet()->setCellValue('F1', 'Comments');
        $this->excel->getActiveSheet()->setCellValue('G1', 'SalesPersonCode');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Indicator');        
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'DocNum');
		$this->excel->getActiveSheet()->setCellValue('B2', 'DocDate');
        $this->excel->getActiveSheet()->setCellValue('C2', 'DocDueDate');
        $this->excel->getActiveSheet()->setCellValue('D2', 'CardCode');
        $this->excel->getActiveSheet()->setCellValue('E2', 'DocCur');
		$this->excel->getActiveSheet()->setCellValue('F2', 'Comments');
        $this->excel->getActiveSheet()->setCellValue('G2', 'SlpCode');	
        $this->excel->getActiveSheet()->setCellValue('H2', 'Indicator');	
        	
		
		$i=3;
		$no = 1;
		$_id_trans = '';
		$address = '';
		$sub_ttl = 0;
		$id_trans = array();
		$_no = array();
		if(!empty($transaksi)){
			foreach($transaksi as $t){
				$address = '';
				$_id_trans = $t['id_transaksi'].'_'.$no;
				
				if(!empty($t['remark'])){
					$address .=', '.$t['remark'];
				}
				$address .= ', ship to : '.$t['alamat_penerima'].' '.$t['nama_city'].' '.$t['nama_provinsi'].' '.$t['kode_pos'];
				array_push($id_trans,$t['id_transaksi']);
				array_push($_no,$_id_trans);
				$this->excel->getActiveSheet()->setCellValue('A'.$i, $no);
				$this->excel->getActiveSheet()->setCellValue('B'.$i, date("Ymd", strtotime($t['create_at'])));
				$this->excel->getActiveSheet()->setCellValue('C'.$i, date("Ymd", strtotime($t['create_at'])));
				$this->excel->getActiveSheet()->setCellValue('D'.$i, $t['kd_cust']);
				$this->excel->getActiveSheet()->setCellValue('E'.$i, 'IDR');		
				$this->excel->getActiveSheet()->setCellValue('F'.$i, $t['id_transaksi'].'-GTS-'.date("m-Y", strtotime($t['create_at'])).''.$address);
				$this->excel->getActiveSheet()->setCellValue('G'.$i, $t['sales_id']);								
				$this->excel->getActiveSheet()->setCellValue('H'.$i, 'B2');								
												
				
				$this->excel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getAlignment()->setWrapText(true);
				$this->excel->getActiveSheet()->getStyle('A'.$i.':C'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				$this->excel->getActiveSheet()->getStyle('D'.$i.':F'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);	
				$this->excel->getActiveSheet()->getStyle('G'.$i.':H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				$this->excel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$no++;
				$i++;
			}
			unset($styleArray);	
		}
		
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$this->session->set_userdata(array('reports' =>$id_trans));
		$this->session->set_userdata(array('reports_no' =>$_no));
		$filename ='ogut_header_'.$tgl.'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0'); 					 
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  		
		$objWriter->save('php://output');
		
	}
	
	function export_r2(){
		$tgl = date('dmY');
		$id_trans = $this->session->userdata('reports');
		$_no = $this->session->userdata('reports_no');
		$this->load->library('excel');
		
		$where = array();
		if(!empty($id_trans)){			
			$field_in = 'transaksi_detail.id_trans';
			foreach($id_trans as $it){
				$where_in = implode(',',$id_trans);
				$where_in = str_replace("'",'',$id_trans);
			}
			
		}		
		$_numb = array();
		$_number = '';
		if(!empty($_no)){			
			
			foreach($_no as $_n){
				$_number = explode('_',$_n);
				$_numb[$_number[0]] = $_number[1];
			}
			
		}
		
		$transaksi = $this->access->readtable('transaksi_detail', '', '','','','','','','','',$field_in,$where_in)->result_array();
		$this->session->unset_userdata('reports');
		
		
		$this->excel->setActiveSheetIndex(0);		
		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(25);		
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(25);		
		
		$this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setSize(12);			
		
		
		$this->excel->getActiveSheet()->setCellValue('A1', 'ParentKey');
		$this->excel->getActiveSheet()->setCellValue('B1', 'LineNum');
        $this->excel->getActiveSheet()->setCellValue('C1', 'ItemCode');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Quantity');
		$this->excel->getActiveSheet()->setCellValue('E1', 'WarehouseCode');
        $this->excel->getActiveSheet()->setCellValue('F1', 'SalesPersonCode');
        $this->excel->getActiveSheet()->setCellValue('G1', 'VatGroup');
        $this->excel->getActiveSheet()->setCellValue('H1', 'TaxCode');
        $this->excel->getActiveSheet()->setCellValue('I1', 'CostingCode');
        $this->excel->getActiveSheet()->setCellValue('J1', 'FreeText');
        $this->excel->getActiveSheet()->setCellValue('K1', 'CostingCode2');
        $this->excel->getActiveSheet()->setCellValue('L1', 'CostingCode3');
        $this->excel->getActiveSheet()->setCellValue('M1', 'U_STEM_Disc1');
        $this->excel->getActiveSheet()->setCellValue('N1', 'U_STEM_Disc2');
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'DocNum');
		$this->excel->getActiveSheet()->setCellValue('B2', 'LineNum');
        $this->excel->getActiveSheet()->setCellValue('C2', 'ItemCode');
        $this->excel->getActiveSheet()->setCellValue('D2', 'Quantity');
       
		$this->excel->getActiveSheet()->setCellValue('E2', 'WhsCode');
        $this->excel->getActiveSheet()->setCellValue('F2', 'SlpCode');
        $this->excel->getActiveSheet()->setCellValue('G2', 'VatGroup');
        $this->excel->getActiveSheet()->setCellValue('H2', 'TaxCode');
        $this->excel->getActiveSheet()->setCellValue('I2', 'OcrCode');
        $this->excel->getActiveSheet()->setCellValue('J2', 'FreeText');
        $this->excel->getActiveSheet()->setCellValue('K2', 'OcrCode2');
        $this->excel->getActiveSheet()->setCellValue('L2', 'OcrCode3');  
        $this->excel->getActiveSheet()->setCellValue('M2', 'U_STEM_Disc1');  
        $this->excel->getActiveSheet()->setCellValue('N2', 'U_STEM_Disc2');  
		
		
		$i=3;
		$no = 1;		
		$sub_ttl = 0;
		if(!empty($transaksi)){
			foreach($transaksi as $t){				
				$this->excel->getActiveSheet()->setCellValue('A'.$i, $_numb[$t['id_trans']]);
				$this->excel->getActiveSheet()->setCellValue('B'.$i, '');
				$this->excel->getActiveSheet()->setCellValue('C'.$i, $t['nama_barang']);
				$this->excel->getActiveSheet()->setCellValue('D'.$i, $t['jml']);
				
				$this->excel->getActiveSheet()->setCellValue('E'.$i, $t['ocrcode_p']);		
				$this->excel->getActiveSheet()->setCellValue('F'.$i, $t['sales_id']);
				$this->excel->getActiveSheet()->setCellValue('G'.$i, 'K1');				
				$this->excel->getActiveSheet()->setCellValue('H'.$i, 'K1');	
				$this->excel->getActiveSheet()->setCellValue('I'.$i, $t['ocrcode_c']);					
				$this->excel->getActiveSheet()->setCellValue('J'.$i, $t['id_trans']);					
				$this->excel->getActiveSheet()->setCellValue('K'.$i, 'SLS');					
				$this->excel->getActiveSheet()->setCellValue('L'.$i, $t['ocrcode_b']);			
				$this->excel->getActiveSheet()->setCellValue('M'.$i, $t['diskon']);			
				$this->excel->getActiveSheet()->setCellValue('N'.$i, $t['diskon_product']);			
				
				$this->excel->getActiveSheet()->getStyle('A'.$i.':N'.$i)->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('A'.$i.':N'.$i)->getAlignment()->setWrapText(true);
					
				$this->excel->getActiveSheet()->getStyle('A'.$i.':N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);	
				$this->excel->getActiveSheet()->getStyle('A'.$i.':N'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$i++;
			}
			unset($styleArray);	
		}
		$this->session->unset_userdata('reports_no');
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		ob_clean();
		$filename ='ogut_detail_'.$tgl.'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0'); 					 
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  		
		$objWriter->save('php://output');
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

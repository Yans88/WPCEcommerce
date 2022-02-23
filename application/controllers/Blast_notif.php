<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blast_notif extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
		$this->load->library('send_notif');
	}	
	
	public function index() {			
		$this->data['judul_browser'] = 'Blast Notification';
		$this->data['judul_utama'] = 'Blast Notification';
		$this->data['judul_sub'] = 'List';
		$this->data['blast_notif'] = $this->access->readtable('blast_notif','',array('blast_notif.deleted_at'=>null),array('admin'=>'admin.operator_id = blast_notif.created_by'),'','','LEFT')->result_array();
		$this->data['isi'] = $this->load->view('notif_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_promo' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('promo', $data, $where);
	}
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		$id_promo = isset($_POST['id_promo']) ? (int)$_POST['id_promo'] : 0;		
		$content_notif = isset($_POST['content_notif']) ? $_POST['content_notif'] : '';
		
		$simpan = array(			
			'content'	=> $content_notif		
		);
		
		$where = array();
		$gcm_token = array();
		$ids = array();
		$data_fcm = array();
		$notif_fcm = array();
		$save = 0;	
		if($id_promo > 0){
			$where = array('id_promo'=>$id_promo);
			$save = $this->access->updatetable('blast_notif', $simpan, $where);   
		}else{
			$simpan += array('created_at' => $tgl,'created_by'=>$this->session->userdata('operator_id'));
			$save = $this->access->inserttable('blast_notif', $simpan); 
			if($save){
				$get_member = $this->access->readtable('members','',array('deleted_at'=>null,'status'=>4))->result_array();
				if(!empty($get_member)){
					$data_fcm = array(
						'id_notif'		=> $save,
						'notif_type' 	=> '3',
						'title'			=> 'GTS',
						'message'		=> $content_notif
					);
					$notif_fcm = array(
						'body'			=> $content_notif,
						'title'			=> 'GTS',
						'badge'			=> '1',
						'sound'			=> 'Default'
					);
					foreach($get_member as $gm){
						if(!empty($gm['gcm_token'])){
							array_push($ids, $gm['gcm_token']);
							$dtt =array();
							$dtt =array(
								'id_member'		=> $gm['id_member'],
								'id_bn'			=> $save,
								'fcm_token'		=> $gm['gcm_token'],
								'created_at'	=> $tgl,
								'type'			=> 1
							);
							$this->access->inserttable('history_notif', $dtt); 
						}
						
					}
					$notif = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);
					error_log(serialize($notif)."\n",'3','error_notif');
				}
			}
		}  
		echo $save;
		
		
	}
	
	public function user_promo($id_promo=0){
		$this->data['judul_browser'] = 'Promo';
		$this->data['judul_utama'] = 'Promo';
		$this->data['judul_sub'] = 'List user';
		$where = array('transaksi.id_promo'=>$id_promo);
		$sort = array('transaksi.id_transaksi','DESC');
		$this->data['transaksi'] = $this->access->readtable('transaksi', '',$where, array('merchants'=>'merchants.id_merchants =  transaksi.id_merchant','members'=>'members.id_member = transaksi.id_member'),'','','LEFT')->result_array();
		$this->data['isi'] = $this->load->view('promo/customer_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function chk_promo(){
		$code_promo = isset($_POST['promo_code']) ? $_POST['promo_code'] : '';
		$promo = $this->access->readtable('promo','',array('deleted_at'=>null,'UPPER(kode_promo)'=>strtoupper($code_promo)))->result_array();
		$cnt_promo = count($promo) > 0 ? count($promo) : 0;
		echo $cnt_promo;
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

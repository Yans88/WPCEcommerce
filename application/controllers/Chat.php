<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {
		if(!$this->session->userdata('login') || !$this->session->userdata('chat')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Chat';
		$this->data['judul_utama'] = 'Chat';
		$this->data['judul_sub'] = 'List';
		$this->data['messages'] = $this->access->readtable('messages')->result_array();
		$this->data['isi'] = $this->load->view('chat/messages_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function count_chat(){
		$chat = $this->access->readtable('master_chat','',array('master_chat.status_count >'=>0))->result_array();
		$cnt = count($chat);
		echo $cnt;
	}
	
	function get_list_chat(){
		$search = isset($_POST['search_member']) ? $_POST['search_member'] : 0;
		$sort = array('master_chat.update_at','DESC');
		$select = array('master_chat.*','members.photo','members.nama','members.email');
		if(!empty($search)){
			$list_chat = $this->access->readtable('master_chat',$select,'',array('members'=>'members.id_member = master_chat.id_member'),'',$sort,'LEFT','',array('members.nama'=>$search))->result_array();
		}else{
			$list_chat = $this->access->readtable('master_chat',$select,'',array('members'=>'members.id_member = master_chat.id_member'),'',$sort,'LEFT')->result_array();
		}
		
		$json = array();
		$list_msg = $this->access->readtable('messages')->result_array();
		$input = '';
		$_img = '';
		$i=1;
		if(!empty($list_chat)){
			foreach($list_chat as $lc){				
				$_img = base_url('uploads/member/'.$lc['photo']);
				$input = '';
				if($i == 1){
					$input = '<input type="hidden" name="all_msg" class="all_msg" value="'.count($list_msg).'">';
				}
				if($lc['status_count'] > 0){
					$json[] = '<div class="chat_list" id="'.$lc['id_member'].'">
              <div class="chat_people">               
                <div class="chat_ibs" id="chat_ibs_'.$lc['id_member'].'">
                  <h5>'.$lc['email'].'<span class="chat_date">'.date('d-m-Y', strtotime($lc['update_at'])).'</span></h5>
                  <p>'.$lc['content'].'</p>
                </div>
              </div>'.$input.'
            </div>';
				}else{
					$json[] = '<div class="chat_list" id="'.$lc['id_member'].'">
				  <div class="chat_people">               
					<div class="chat_ib">
					  <h5>'.$lc['email'].'<span class="chat_date">'.date('d-m-Y', strtotime($lc['update_at'])).'</span></h5>
					  <p>'.$lc['content'].'</p>
					</div>
				  </div>'.$input.'
				</div>';
				}
				
			$i++;	
			}
		}
		echo json_encode($json);
		// print_r($id_gym);
	}
	
	function get_chat(){
		$select = array('master_chat.*','members.photo','members.nama','members.email');
		$id_chat = isset($_POST['id_member']) ? $_POST['id_member'] : 0;
		$member = $this->access->readtable('master_chat',$select,array('master_chat.id_member'=>$id_chat),array('members'=>'members.id_member = master_chat.id_member'),'','','LEFT')->row();
		
		$list_chat = $this->access->readtable('messages', '',array('id_chat'=>$member->id_chat))->result_array();
		
		$json = array();
		if(!empty($list_chat)){
			foreach($list_chat as $lc){
				$tgl = date('d M y | H:i', strtotime($lc['date_create']));
				if($lc['user_id_from'] == 'admin'){
					$json[] = ' <div class="outgoing_msg">
              <div class="sent_msg">
				<strong>Admin</strong>
                <p>'.$lc['content'].'</p>
                <span class="time_date">'.$tgl.'</span> </div>
            </div>';
				}else{
					$json[] = '	<div class="incoming_msg">
              
              <div class="received_msg">
				<strong>'.$member->email.'</strong>
                <div class="received_withd_msg">
				  
                  <p>'.$lc['content'].'</p>
                  <span class="time_date">'.$tgl.'</span></div>
              </div>
            </div>';
				}
				
			}
		}
		$datas = array('status_count'=>0);
		$this->access->updatetable('master_chat', $datas, array('id_member'=>$id_chat));
		echo json_encode($json);
	}
	
	function send_chat(){	
	    $this->load->library('send_notif');
		$id_to = isset($_POST['id_member']) ? (int)$_POST['id_member'] : 0;
		$message = isset($_POST['message']) ? $_POST['message'] : '';
		$master_chat = $this->access->readtable('master_chat','',array('id_member'=>$id_to))->row();
		$id_chat = !empty($master_chat) ? (int)$master_chat->id_chat : 0;
		$members = $this->access->readtable('members','',array('members.id_member'=>$id_to))->row();
		$ids = array($members->gcm_token);
		if($id_chat > 0){
			$datas = array('content'=>$message,'status_member'=>1);
			$this->access->updatetable('master_chat', $datas, array('id_chat'=>$master_chat->id_chat));
			$id_chat = $master_chat->id_chat;
		}else{
			$datas = array('id_member'=>$id_to,'content'=>$message,'status_member'=>1);
			$save_chat = $this->access->inserttable('master_chat', $datas);
			$id_chat = $save_chat;
		}
		$data = array(	
			'user_id_from'	=> 'admin',
			'user_id_to'	=> $id_to,
			'content'		=> $message,
			'id_chat'		=> $id_chat,
			'date_create'	=> date('Y-m-d H:i:s'),
			'dari'			=> 'Admin',
			'ke'			=> $members->nama,
			'status'		=> 1
		);
		$save = $this->access->inserttable('messages', $data);
		if(!empty($ids)){
			$data_fcm = array(
				'id_notif'		=> $save,
				'title'			=> 'GTS',				
				'message' 		=> $message,
				'notif_type' 	=> '1'
			);
			$notif_fcm = array(
				'body'			=> $message,
				'title'			=> 'GTS',
				'badge'			=> '1',
				'sound'			=> 'Default'
			);	
			$send_fcms = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);	
			// $dtt =array();
			// $dtt =array(
				// 'id_member'		=> $id_to,
				// 'id_transaksi'	=> $id_transaksi,
				// 'fcm_token'		=> $members->gcm_token,
				// 'created_at'	=> $tgl,
				// 'type'			=> 2
			// );
			// $this->access->inserttable('history_notif', $dtt); 
		}
		echo $save;
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

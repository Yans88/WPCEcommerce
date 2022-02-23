<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Member extends REST_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
		$this->load->model('Setting_m','sm', true);
		$this->load->library('converter');
    }

    public function index_get(){
		$id = $this->get('id');
		$id = (int)$id;
		$dt = array();
		$login = '';
		$status_name = '';	
		if($id > 0){
			$login = $this->access->readtable('members','',array('id_member'=>$id))->row();
			if(!empty($login)){	
				if($login->status == 2){
					$status_name = 'approved';
				}
				if($login->status == 3){
					$status_name = 'rejected';
				}
				if($login->status == 4){
					$status_name = 'active';
				}
				if($login->status == 5){
					$status_name = 'inactive';
				}
				$dt = [
					"id_member"			=> $login->id_member,
					"id_tier"			=> $login->id_tier,
					"id_whs"			=> $login->id_whs,
					"id_sls"			=> $login->sales_id,
					"nama"				=> $login->nama,							
					"email"				=> $login->email,
					"phone"				=> $login->phone,							
					"alamat"			=> $login->address,														
					"fcm_token"			=> $login->gcm_token,														
					"status"			=> $login->status,							
					"status_name"		=> $status_name,							
					"limit_credit"		=> 0,							
					"use_credit"		=> 0,							
					"sisa_credit"		=> 0,	
					"photo"				=> !empty($login->photo) ? base_url('uploads/members/'.$login->photo) : '',	
					"current_pass"		=> $this->converter->decode($login->pass),
					"tgl_reg"			=> date('d-M-Y', strtotime($login->tgl_reg))
				];
			}		
			$this->set_response([
				'err_code' => '00',
				'err_msg' => 'Ok',
				'profile_info' => $dt
			], REST_Controller::HTTP_OK);
			return false;
		}else{
			$login = $this->access->readtable('members','',array('deleted_at'=>null))->result_array();
		}
		
		$status_name = '';
		if(!empty($login)){
			foreach($login as $l){
				if($l['status'] == 2){
					$status_name = 'approved';
				}
				if($l['status'] == 3){
					$status_name = 'rejected';
				}
				if($l['status'] == 4){
					$status_name = 'active';
				}
				if($l['status'] == 1){
					$status_name = 'inactive';
				}
				$dt[] = array(
					"id_member"			=> $l['id_member'],
					"id_tier"			=> $l['id_tier'],
					"id_whs"			=> $l['id_whs'],
					"id_sls"			=> $l['sales_id'],
					"nama"				=> $l['nama'],							
					"email"				=> $l['email'],
					"phone"				=> $l['phone'],							
					"alamat"			=> $l['address'],	
					"fcm_token"			=> $l['gcm_token'],	
					"status"			=> $l['status'],							
					"status_name"		=> $status_name,
					"photo"				=> !empty($l['photo']) ? base_url('uploads/members/'.$l['photo']) : '',		
					"limit_credit"		=> 0,							
					"use_credit"		=> 0,							
					"sisa_credit"		=> 0,							
					"current_pass"		=> $this->converter->decode($l['pass']),
					"tgl_reg"			=> date('d-M-Y', strtotime($l['tgl_reg']))
				);
				
			}
		}
		if (!empty($dt)){
			// error_log(serialize($dt));
            $this->set_response([
				'err_code' => '00',
				'err_msg' => 'Ok',
				'data' => $dt
			], REST_Controller::HTTP_OK);
        }else{
            $this->set_response([
                'err_code' => '04',
                'err_msg' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

	public function reg_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$id_provinsi = isset($param['id_provinsi']) ? (int)$param['id_provinsi'] : 0;
		$id_city = isset($param['id_city']) ? (int)$param['id_city'] : 0;
		$nama_member = isset($param['nama_member']) ? $param['nama_member'] : '';
		$nama_toko = isset($param['nama_toko']) ? $param['nama_toko'] : '';
		$gcm_token = isset($param['fcm_token']) ? $param['fcm_token'] : '';
		$password = isset($param['password']) ? $this->converter->encode($param['password']) : '';
		$old_password = isset($param['old_password']) ? $this->converter->encode($param['old_password']) : '';
		$email = isset($param['email']) ? $param['email'] : ''; 	
		$alamat = isset($param['alamat']) ? $param['alamat'] : '';		
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$tgl_reg = date('Y-m-d H:i:s');		
		$user_id = isset($param['user_id']) ? $param['user_id'] : '';
		$device = isset($param['device']) ? $param['device'] : '';	
		$referensi = isset($param['referensi']) ? $param['referensi'] : '';	
		$kode_pos = isset($param['kode_pos']) ? $param['kode_pos'] : '';	
		$save_sms = 0;
		$save = 0;
		$upl = '';
		$upload = array();
		$config['upload_path'] = "./uploads/members/";
		$config['allowed_types'] = "jpg|png|jpeg|";
		$config['max_size']	= '1048';
		$name = $_FILES['photo']['name'];
		$config['file_name'] = date('YmdHis').$name;
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload',$config);
		if(empty($email) && ($id_member == 0 || $id_member ==  '')){
			$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param Password can\'t empty.' );
			$this->set_response($result, REST_Controller::HTTP_OK);
			return false;
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$result = array('err_code'	=> '06',
							'err_msg'	=> 'Email invalid format.' );
			$this->set_response($result, REST_Controller::HTTP_OK);
			return false;
		}
		if(empty($password) && ($id_member == 0 || $id_member ==  '')){
			$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param Password can\'t empty.' );
			$this->set_response($result, REST_Controller::HTTP_OK);
			return false;
		}
		if(empty($phone) && ($id_member == 0 || $id_member ==  '')){
			$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param Phone can\'t empty.' );
			$this->set_response($result, REST_Controller::HTTP_OK);
			return false;
		}
		$ptn = "/^0/";
		$rpltxt = "62";
		$phone = preg_replace($ptn, $rpltxt, $phone);
		
		$chk_email = $this->access->readtable('members','',array('email'=>$email,'deleted_at'=>null))->row();
		$ketemu = count($chk_email);
		$login = '';
		$data = array();		
		$details = '';		
		$a = '';		
		if($ketemu > 0 && $id_member != $chk_email->id_member){
			$this->set_response([
                'err_code' => '04',
                'err_msg' => 'Email already exist'
            ], REST_Controller::HTTP_OK);
			return false;
		}
		$chk_phone = $this->access->readtable('members','',array('phone'=>$phone,'deleted_at'=>null))->row();
		// error_log($this->db->last_query());
		$ketemu = count($chk_phone);
		// error_log($ketemu);
		if($ketemu > 0 && $id_member != $chk_phone->id_member){
			$this->set_response([
                'err_code' => '04',
                'err_msg' => 'Phone already exist'
            ], REST_Controller::HTTP_OK);
			return false;
		}
		$chk_email = '';
		$date_expired = '';		
		$simpan = array();
		if(!empty($nama_toko)){
			$simpan += array("nama_toko"	=> $nama_toko);
		}
		if(!empty($nama_member)){
			$simpan += array("nama"	=> $nama_member);
		}
		if(!empty($alamat)){
			$simpan += array("address"	=> $alamat);
		}	
		if(!empty($phone)){
			$simpan += array("phone"	=> $phone);
		}
		if(!empty($user_id)){
			$simpan += array("user_id"	=> $user_id);
		}
		if(!empty($gcm_token)){
			$simpan += array("gcm_token"	=> $gcm_token);
		}
		if(!empty($device)){
			$simpan += array("device"	=> $device);
		}		
		
		if(!empty($password)){
			$simpan += array("pass"	=> $password);
		}
		if(!empty($_FILES['photo'])){
			$upl = '';
			if($this->upload->do_upload('photo')){
				$upl = $this->upload->data();
				$simpan += array("photo"	=> $upl['file_name']);
			}
		}
		if(!empty($_FILES['photo_ktp'])){
			$upl = '';
			if($this->upload->do_upload('photo_ktp')){
				$upl = $this->upload->data();
				$simpan += array("photo_ktp"	=> $upl['file_name']);
			}
		}
		if(!empty($_FILES['photo_npwp'])){
			$upl = '';
			if($this->upload->do_upload('photo_npwp')){
				$upl = '';
				$upl = $this->upload->data();
				$simpan += array("photo_npwp"	=> $upl['file_name']);
			}
		}
		if($id_member > 0){
			$chk_member = '';
			if(!empty($password) && empty($old_password)){
				$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param password can\'t empty.' );
				$this->set_response($result, REST_Controller::HTTP_OK);
				return false;
			}
			
			if(!empty($password) && !empty($old_password)){
				$chk_member = $this->access->readtable('members','',array('id_member'=>$id_member,'pass'=>$old_password))->row();
				
				if((int)$chk_member <= 0){
					$result = array( 'err_code'	=> '04',
									 'err_msg'	=> 'Password tidak sesuai' );
					$this->set_response($result, REST_Controller::HTTP_OK);
					return false;					
				}
			}
			$this->access->updatetable('members',$simpan, array("id_member"=>$id_member));
			$save = $id_member;
		}else{
			$simpan +=array('referensi'=>$referensi,'tgl_reg' => $tgl_reg,'email' => $email,'phone'	=> $phone,'limit_credit'=>0,'status'=>1,'id_tier'=>0);
			$save = $this->access->inserttable('members',$simpan);
			
			// $opsi_val_arr = $this->sm->get_key_val();
			// foreach ($opsi_val_arr as $key => $value){
				// $out[$key] = $value;
			// }
			// $this->load->library('send_notif');
			// $from = $out['email'];
			// $pass = $out['pass'];
			// $to = $email;
			// $subject = $out['subj_email_register'];
			// $content_member = $out['content_verifyReg'];
			// $content = str_replace('[#name#]', $nama_member, $content_member);
			
			// if($save){
				// $id = $this->converter->encode($save);
				// $link = VERIFY_REGISTER_LINK.'='.$id;
				// $href = '<a href="'.$link.'">'.$link.'</a>';
				// $content = str_replace('[#verify_link#]', $href, $content);
				// $this->send_notif->send_email($from,$pass, $to,$subject, $content);
				
			// }
			
		}

		$status_name = '';	
		if($save){
			$login = $this->access->readtable('members','',array('id_member'=>$save))->row();
			if(!empty($login)){	
				if($login->status == 2){
					$status_name = 'approved';
				}
				if($login->status == 3){
					$status_name = 'rejected';
				}
				if($login->status == 4){
					$status_name = 'active';
				}
				if($login->status == 5){
					$status_name = 'inactive';
				}
				$details = [
					"id_member"			=> $login->id_member,
					"referensi"			=> $login->referensi,
					"kd_cust"			=> $login->kd_cust,
					"id_sls"			=> $login->sales_id,
					"id_whs"			=> $login->id_whs,
					"nama"				=> $login->nama,
					"nama_toko"			=> $login->nama_toko,					
					"email"				=> $login->email,
					"phone"				=> $login->phone,							
					"alamat"			=> $login->address,														
					"status"			=> $login->status,							
					"status_name"		=> $status_name,		
					"photo"				=> !empty($login->photo) ? base_url('uploads/members/'.$login->photo) : '',
					"photo_ktp"			=> !empty($login->photo_ktp) ? base_url('uploads/members/'.$login->photo_ktp) : '',
					"photo_npwp"		=> !empty($login->photo_npwp) ? base_url('uploads/members/'.$login->photo_npwp) : '',
					"limit_credit"		=> $login->limit_credit,							
					"use_credit"		=> $login->use_credit,							
					"sisa_credit"		=> $login->sisa_credit,							
					"current_pass"		=> $this->converter->decode($login->pass),
					"tgl_reg"			=> date('d-M-Y', strtotime($login->tgl_reg))
				];
			}
			$simpan_alamat =array();
			if($id_member > 0){
				$this->set_response([
					'err_code' => '00',
					'err_msg' => 'Ok',
					'profile_info' => $details,
					
				], REST_Controller::HTTP_OK);
			}else{				
				$simpan_alamat =array(
					'alamat'		=> $alamat,
					'id_member'		=> $login->id_member,
					'created_at' 	=> $tgl_reg,
					'phone'			=> $phone,
					'nama_penerima'	=> $nama_member,
					'nama_alamat'	=> 'Alamat Toko',
					'id_provinsi'	=> $id_provinsi,
					'id_city'		=> $id_city,
					'kode_pos'		=> $kode_pos
				);
				$save = $this->access->inserttable('alamat_pengiriman',$simpan_alamat);
				$this->set_response([
					'err_code' => '00',
					'err_msg' => 'Terima kasih telah mendaftar di pesenaja.com, kami akan mereview keanggotaan anda',
					'profile_info' => $details,
					
				], REST_Controller::HTTP_OK);
			}
			
		}else{
			$this->set_response([
				'err_code' => '03',
				'err_msg' => 'Insert has problem'
			], REST_Controller::HTTP_OK);
		}
	}

	function login_post(){
		$result = array();
		$login = '';
		$param = $this->input->post();
		$email = isset($param['email']) ? $param['email'] : '';
		$password = isset($param['password']) ? $this->converter->encode($param['password']) : '';
		$phone = '';
		$ptn = "/^0/";
		$rpltxt = "62";
		$phone = preg_replace($ptn, $rpltxt, $email);
		$login = $this->access->readtable('members','',array('phone'=>$phone,'pass'=>$password,'deleted_at'=>null))->row();
		// error_log($this->db->last_query());
		if(!empty($email) && !empty($password)){
			if(!filter_var($email, FILTER_VALIDATE_EMAIL) && count($login) == 0) {
				$result = [
					'err_code'	=> '06',
					'err_msg'	=> 'Email invalid format'
				];
				$this->set_response($result, REST_Controller::HTTP_OK);
				return false;
			}else{
				if(count($login) == 0){
					$login = $this->access->readtable('members','',array('email'=>$email,'pass'=>$password,'deleted_at'=>null))->row();
				}
			}
		}else{
			$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param Email or Password can\'t empty.' );
			$this->set_response($result, REST_Controller::HTTP_OK);
			return false;
		}
		$status_name = '';
		$details = '';	
		if(!empty($login)){				
			if($login->status == 1){
				$result = array( 'err_code'	=> '06',
								 'err_msg'	=> 'Waiting approval' );
				$this->set_response($result, REST_Controller::HTTP_OK);
				return false;
			}
			if($login->status == 3){
				$result = array( 'err_code'	=> '04',
								 'err_msg'	=> 'Account rejected' );
				$this->set_response($result, REST_Controller::HTTP_OK);
				return false;
			}
			if($login->status == 4){
				$status_name = 'active';
			}
			if($login->status == 5){
				$result = array( 'err_code'	=> '05',
								 'err_msg'	=> 'Account inactive' );
				$this->set_response($result, REST_Controller::HTTP_OK);
				return false;
			}
			$details = [
				"id_member"			=> $login->id_member,
				"id_tier"			=> $login->id_tier,
				"id_sls"			=> $login->sales_id,
				"id_whs"			=> $login->id_whs,
				"nama"				=> $login->nama,							
				"nama_toko"			=> $login->nama_toko,							
				"email"				=> $login->email,
				"phone"				=> $login->phone,							
				"alamat"			=> $login->address,														
				"fcm_token"			=> $login->gcm_token,														
				"status"			=> $login->status,							
				"status_name"		=> $status_name,
				"photo"				=> !empty($login->photo) ? base_url('uploads/members/'.$login->photo) : '',
				"photo_ktp"			=> !empty($login->photo_ktp) ? base_url('uploads/members/'.$login->photo_ktp) : '',
				"photo_npwp"		=> !empty($login->photo_npwp) ? base_url('uploads/members/'.$login->photo_npwp) : '',
				"limit_credit"		=> $login->limit_credit,							
				"use_credit"		=> $login->use_credit,							
				"sisa_credit"		=> $login->sisa_credit,							
				"current_pass"		=> $this->converter->decode($login->pass),
				"tgl_reg"			=> date('d-M-Y', strtotime($login->tgl_reg))
			];
			$this->set_response([
				'err_code' => '00',
				'err_msg' => 'Ok',
				'profile_info' => $details
			], REST_Controller::HTTP_OK);
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Login failed'
			];
			$this->set_response($result, REST_Controller::HTTP_OK);
		}

	}
	
	function add_address_post(){
		$param = $this->input->post();
		$id_address = isset($param['id_address']) ? (int)$param['id_address'] : 0;		
		$tgl_reg = date('Y-m-d H:i:s');
		$simpan = array();
		foreach($param as $key=>$val){
			$simpan += array( $key => $val);
		}
		if($id_address > 0){
			unset($simpan['id_member']);
			unset($simpan['id_address']);
			$this->access->updatetable('alamat_pengiriman',$simpan, array("id_address"=>$id_address));
			$save = $id_address;
		}else{
			$simpan +=array('created_at' => $tgl_reg);
			$save = $this->access->inserttable('alamat_pengiriman',$simpan);
			// error_log($this->db->last_query());
		}
		if($save){
			$this->set_response([
				'err_code' => '00',
				'err_msg' => 'Ok'				
			], REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'err_code' => '03',
				'err_msg' => 'Insert has problem'
			], REST_Controller::HTTP_OK);
		}
	}
	
	public function del_address_post(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_address = isset($param['id_address']) ? (int)$param['id_address'] : 0;	
		$where = array(
			'id_address' => $id_address
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		$this->access->updatetable('alamat_pengiriman', $data, $where);
		$this->set_response([
				'err_code' => '00',
				'err_msg' => 'Ok'				
			], REST_Controller::HTTP_OK);
	}
	
	public function set_address_post(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_address = isset($param['id_address']) ? (int)$param['id_address'] : 0;	
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;	
		$this->access->updatetable('alamat_pengiriman', array('utama'=>0), array('id_member'=>$id_member));
		$where = array(
			'id_address' => $id_address
		);
		$data = array(
			'utama'	=> 1
		);
		$this->access->updatetable('alamat_pengiriman', $data, $where);
		$this->set_response([
				'err_code' => '00',
				'err_msg' => 'Ok'				
			], REST_Controller::HTTP_OK);
	}
	
	public function get_address_post(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_address = isset($param['id_address']) ? (int)$param['id_address'] : 0;	
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;	
		$login = '';
		$dt = array();
		$select = array('alamat_pengiriman.*','provinsi.nama_provinsi','city.nama_city');
		if($id_address > 0){
			$login = $this->access->readtable('alamat_pengiriman',$select,array('alamat_pengiriman.id_address'=>$id_address, 'alamat_pengiriman.deleted_at'=>null),array('members' => 'members.id_member = alamat_pengiriman.id_member','city' => 'city.id_city = alamat_pengiriman.id_city','provinsi' => 'provinsi.id_provinsi = alamat_pengiriman.id_provinsi'),'','','LEFT')->row();
			$dt = [
				"id_address"	=> $login->id_address,
				"id_member"		=> $login->id_member,
				"id_provinsi"	=> $login->id_provinsi,							
				"id_city"		=> $login->id_city,
				"nama_member"	=> $login->nama,
				"nama_provinsi"	=> $login->nama_provinsi,
				"nama_city"		=> $login->nama_city,
				"kode_pos"		=> $login->kode_pos,							
				"alamat"		=> $login->alamat,														
				"phone"			=> $login->phone,							
				"nama_penerima"	=> $login->nama_penerima,											
				"nama_alamat"	=> $login->nama_alamat,							
				"utama"			=> $login->utama
			];
		}
		if($id_member > 0){
			$login = $this->access->readtable('alamat_pengiriman','',array('alamat_pengiriman.id_member'=>$id_member, 'alamat_pengiriman.deleted_at'=>null),array('members' => 'members.id_member = alamat_pengiriman.id_member','city' => 'city.id_city = alamat_pengiriman.id_city','provinsi' => 'provinsi.id_provinsi = alamat_pengiriman.id_provinsi'),'','','LEFT')->result_array();
			if(!empty($login)){
				foreach($login as $l){
					$dt[] = array(
						"id_address"	=> $l['id_address'],
						"id_member"		=> $l['id_member'],
						"id_provinsi"	=> $l['id_provinsi'],
						"id_city"		=> $l['id_city'],
						"nama_member"	=> $l['nama'],
						"nama_provinsi"	=> $l['nama_provinsi'],
						"nama_city"		=> $l['nama_city'],
						"kode_pos"		=> $l['kode_pos'],
						"alamat"		=> $l['alamat'],
						"phone"			=> $l['phone'],
						"nama_penerima"	=> $l['nama_penerima'],
						"nama_alamat"	=> $l['nama_alamat'],
						"utama"			=> (int)$l['utama']
					);
				}
			}
		}
		if (!empty($dt)){			
            $this->set_response([
				'err_code' => '00',
				'err_msg' => 'Ok',
				'data' => $dt
			], REST_Controller::HTTP_OK);
        }else{
            $this->set_response([
                'err_code' => '04',
                'err_msg' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	function click_recent_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? $param['id_member'] : '';
		$id_product = isset($param['id_product']) ? $param['id_product'] : '';
		$chk_favorite = $this->access->readtable('recent_v','',array('id_member'=>$id_member, 'id_product'=> $id_product))->row();
		$simpan = array(
			'id_member'		=> $id_member,
			'id_product'	=> $id_product
		);
		if(count($chk_favorite) > 0){
			$this->access->deletetable('recent_v',$simpan);
		}
		$simpan += array(
			'created_at'	=> date('Y-m-d H:i:s')
		);
		$this->access->inserttable('recent_v',$simpan);
		$chk_favorite = $this->access->readtable('recent_v','',$simpan)->row();
		if(count($chk_favorite) > 0){
			$this->set_response([
                'err_code' => '00',
                'message' => 'Ok'
            ], REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'err_code' => '03',
				'message' => 'Insert has problem'
			], REST_Controller::HTTP_OK);
		}
	}
	
	function get_recent_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? $param['id_member'] : '';
		$login = $this->access->readtable('members','',array('id_member'=>$id_member))->row();
		$id_tier = !empty($login) ? (int)$login->id_tier : 0;
		// $id_tier = isset($param['id_tier']) ? $param['id_tier'] : '';
		$sort = array('recent_v.created_at','DESC');
		$limit = isset($param['limit']) ? (int)$param['limit'] : 0;
		$select = array('product.*','merchants.id_merchants','merchants.nama_merchants','kategori.nama_kategori','recent_v.created_at');
		$dt_fav = $this->access->readtable('recent_v',$select,array('recent_v.id_member'=>$id_member),array('product'=>'product.id_product = recent_v.id_product','merchants' => 'merchants.id_merchants = product.id_merchant','kategori' => 'kategori.id_kategori = product.id_kategori'), $limit, $sort,'LEFT')->result_array();
		
		$lf = array();
		$path = '';
		$tier = '';
		$diskon = 0;
		$_diskon = 0;		
		if($id_tier > 0){
			$tier = $this->access->readtable('tier','',array('deleted_at'=>null,'id_tier'=>$id_tier))->row();
			$diskon = $tier->diskon > 0 ? $tier->diskon : 0;
			$_diskon = $diskon > 0 ? $diskon / 100 : 0;
		}
		$where_in = array();
		if(!empty($dt_fav)){
			foreach($dt_fav as $df){
				$id_productk = 0;
				$id_productk = (int)$df['id_product'];
				$where_in[] = "$id_productk";
			}
			$field_in = 'list_diskon.id_product';
			$list_diskon = $this->access->readtable('list_diskon',array('list_diskon.id_product','list_diskon.diskon'),array('list_diskon.deleted_at'=>null,'list_member_diskon.deleted_at'=>null,'list_member_diskon.id_member'=>$id_member),array('list_member_diskon'=> 'list_member_diskon.id_diskon = list_diskon.id_diskon'),'','','LEFT','','','', $field_in,$where_in)->result_array();	
			$diskon2 = array();
			$my_diskon = array();
			if(!empty($list_diskon)){
				foreach($list_diskon as $ld){
					array_push($my_diskon, $ld['id_product']);
					$diskon2[$ld['id_product']] = $ld['diskon'];
				}
			}
			foreach($dt_fav as $m){
				if((int)$m['id_merchants'] > 0){
					$status_delete = 'Deleted';
					if($m['deleted_at'] == null){
						$status_delete = 'Available';
					}
					$path = '';
					$hrg_diskon = 0;
					$harga = 0;
					$harga = $m['harga'];
					$diskon_product = 0;
					$diskon_product = (int)$products['diskon'] > 0 ? $products['diskon'] / 100 : 0;
					if (in_array($m['id_product'], $my_diskon)) $diskon_product = $diskon2[$id_product] / 100;	
					$hrg_diskon = $harga - ($harga * $_diskon);
					if($diskon_product > 0){
						$hrg_diskon = $hrg_diskon - ($diskon_product * $hrg_diskon);
					}
					$path = !empty($m['img']) ? base_url('uploads/products/'.$m['img']) : base_url('uploads/no_photo.jpg');
					$lf[] = array(
						'id_product'		=> $m['id_product'],
						'id_principal'		=> $m['id_merchant'],
						'id_kategori'		=> $m['id_kategori'],
						'nama_barang'		=> $m['nama_barang'],
						'harga'				=> $harga,
						'hrg_diskon'		=> $hrg_diskon,
						'diskon'			=> $diskon,
						'diskon_produk'		=> $diskon_product * 100,
						'qty'				=> $m['qty'],
						'deskripsi'			=> $m['deskripsi'],
						'img'				=> $path,
						'nama_principal'	=> $m['nama_merchants'],
						'nama_kategori'		=> $m['nama_kategori'],
						'last_seen_date'	=> $m['created_at'],
						'status'			=> $status_delete
					);
				}
			}
		}
		if (!empty($lf)){
            $this->set_response([
				'err_code' => '00',
				'err_msg' => 'Ok',
				'data' => $lf
			], REST_Controller::HTTP_OK);
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	function history_transaksi_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? $param['id_member'] : '';
		$from = isset($param['start_date']) ? $param['start_date'] : '';
		$to = isset($param['end_date']) ? $param['end_date'] : '';
		$status = isset($param['type']) ? (int)$param['type'] : 0;
		$transaksi = '';
		$sort = array('transaksi.id_transaksi','DESC');
		$where = array();
		$where = array('transaksi.id_member'=>$id_member,'transaksi.status' => $status);
		if(!empty($from) && !empty($to)){
			$where += array('transaksi.create_at >= ' => date('Y-m-d', strtotime($from)), 'transaksi.create_at <=' => date('Y-m-d', strtotime($to)));
		}
		if($id_member > 0){
			$transaksi = $this->access->readtable('transaksi','',$where,'','',$sort)->result_array();
			
		}else{
			$msg = 'Id member is required';
			$err_code = '05';
		}
		
		$dt = array();		

		$status_name = array(
			'0'=> 'Menungu Pembayaran', 
			'1'=> '-', 
			'2'=> 'Reject',
			'3'=> 'Approve', 
			'4'=> 'Pesanan Dikirim',
			'5'=> 'Sampai Tujuan',
			'6'=> 'Selesai',
			'7'=> 'Complain'
		);
		if(!empty($transaksi)){
			foreach($transaksi as $t){
				$id_transaksi = '';
				$id_transaksi = $t['id_transaksi'];
				$select = array('product.qty','transaksi_detail.*');
				$transaksi_detail = $this->access->readtable('transaksi_detail',$select,array('id_trans'=>$id_transaksi),array('product' => 'product.id_product = transaksi_detail.id_product'),'','','LEFT')->result_array();
				
				$_dt = array();
				if(!empty($transaksi_detail)){
					foreach($transaksi_detail as $td){
						$get_paket = '';
						$lis_paket = '';
						if((int)$td['paket'] > 0){
							$get_paket = $this->access->readtable('transaksi_paket_detail','',array('id_trans'=>$id_transaksi,'id_paket'=>$td['id_product']))->result_array();
							$lis_paket = '';
							if(!empty($get_paket)){
								foreach($get_paket as $gp){
									$lis_paket[] = array(
										'id_paket'		=> $gp['id_paket'],
										'id_product'	=> $gp['id_product'],
										'nama_barang'	=> $gp['nama_barang'],
										'img'			=> $gp['img'],
										'jml'			=> $gp['jml'],
										'deskripsi'		=> $gp['deskripsi']
									);
								}
							}
						}
						$_dt[] = array(
							'id_product'		=> $td['id_product'],
							'id_principal'		=> $td['id_principle'],
							'id_kategori'		=> $td['id_kategori'],
							'id_brand'			=> $td['id_brand'],
							'id_area'			=> $td['id_area'],
							'nama_barang'		=> $td['nama_barang'],
							'harga'				=> $td['harga_asli'],
							'hrg_diskon'		=> $td['harga'],
							'diskon'			=> $td['diskon'],							
							'paket'				=> $td['paket'],
							'qty'				=> $td['qty'],
							'deskripsi'			=> $td['deskripsi'],							
							'nama_principal'	=> $td['nama_principal'],
							'nama_kategori'		=> $td['nama_kategori'],
							'nama_brand'		=> $td['nama_brand'],
							'nama_area'			=> $td['nama_area'],
							'nama_barang'		=> $td['nama_barang'],
							'harga'				=> $td['harga'],
							'jml'				=> $td['jml'],
							'note'				=> $td['note'],
							'total'				=> $td['total'],
							'image'				=> $td['img'],
							'lis_paket'			=> $lis_paket
						);						
					}
				}
				$requestURL == '';
				$no_va == '';
				$valid_date == '';
				$valid_time == '';
				$bank_name == '';
				if($t['payment'] == 1){
					if($t['cash_type'] == 1){
						$requestURL = $t['request_url'];
					}
					if($t['cash_type'] == 2){
						$no_va = $t['request_url'];
						$valid_date = $t['valid_date'];
						$valid_time = $t['valid_time'];
						$bank_name = $t['bank_name'];
					}
				}
				// $_dt = array();
				$dt[] = array(
					'id_transaksi'		=> $t['id_transaksi'],
					'kode_payment'		=> $t['kode_payment'],
					'id_principle'		=> $t['id_principle'],
					'id_member'			=> $t['id_member'],
					'nama_principal'	=> $t['nama_principal'],
					'email_principle'	=> $t['email_principle'],
					'nama_member'		=> $t['nama_member'],
					'email_member'		=> $t['email_member'],
					'phone_member'		=> $t['phone_member'],
					'payment'			=> $t['payment'],
					'payment_name'		=> $t['payment_name'],
					'id_bank'			=> $t['id_bank'],
					'id_tempo'			=> $t['id_tempo'],
					'tempo'				=> $t['tempo'],
					'tgl_jth_tempo'		=> $t['tgl_jth_tempo'],
					'angs'				=> $t['angs'],
					'sdh_byr'			=> $t['sdh_byr'],
					'status_tempo'		=> $t['status_tempo'],
					'status_tempo_name'	=> (int)$t['status_tempo'] > 0 ? 'Lunas' : '',
					'total'				=> $t['ttl_all'],
					'id_address'		=> $t['id_address'],
					'id_provinsi'		=> $t['id_provinsi'],
					'id_city'			=> $t['id_city'],
					'nama_provinsi'		=> $t['nama_provinsi'],
					'nama_city'			=> $t['nama_city'],
					'kode_pos'			=> $t['kode_pos'],
					'alamat_penerima'	=> $t['alamat_penerima'],
					'phone_penerima'	=> $t['phone_penerima'],
					'nama_penerima'		=> $t['nama_penerima'],
					'nama_alamat'		=> $t['nama_alamat'],
					'status'			=> $t['status'],
					'status_name'		=> $status_name[$t['status']],
					'status_date'		=> $t['appr_rej_date'] != '' ? $t['appr_rej_date'] : $t['create_at'],
					'tgl_transaksi'		=> $t['create_at'],
					'request_url'		=> $requestURL,
					'reference_no'		=> $t['kode_payment'],
					'tXid'				=> $t['tXid'],
					'no_va'				=> $no_va,
					'valid_date'		=> $valid_date,
					'valid_time'		=> $valid_time,
					'bank_name'			=> $bank_name,
					'nama_bank'			=> $t['nama_bank'],
					'no_rek'			=> $t['no_rek'],
					'holder_name'		=> $t['holder_name'],
					'detail_item'		=> $_dt
				);
			}
		}
		if (!empty($dt)){
            $this->set_response([
				'err_code' => '00',
				'err_msg' => 'Ok',
				'data' => $dt
			], REST_Controller::HTTP_OK);
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	function transaksi_detail_post(){
		$param = $this->input->post();
		$id_transaksi = isset($param['id_transaksi']) ? (int)$param['id_transaksi'] : '';
		$transaksi = $this->access->readtable('transaksi','', array('transaksi.id_transaksi' => $id_transaksi))->row();
		$transaksi_detail = $this->access->readtable('transaksi_detail','',array('id_trans'=>$id_transaksi))->result_array();
		// $this->data['tagihan'] = $this->access->readtable('tagihan','',array('id_transaksi'=>$id_transaksi))->result_array();
		$dt = array();
		$_dt = array();
		if(!empty($transaksi_detail)){
			foreach($transaksi_detail as $td){
				$get_paket = '';
				$lis_paket = '';
				if((int)$td['paket'] > 0){
					$get_paket = $this->access->readtable('transaksi_paket_detail','',array('id_trans'=>$id_transaksi,'id_paket'=>$td['id_product']))->result_array();
					$lis_paket = '';
					if(!empty($get_paket)){
						foreach($get_paket as $gp){
							$lis_paket[] = array(
								'id_paket'		=> $gp['id_paket'],
								'id_product'	=> $gp['id_product'],
								'nama_barang'	=> $gp['nama_barang'],
								'img'			=> $gp['img'],
								'jml'			=> $gp['jml'],
								'deskripsi'		=> $gp['deskripsi']
							);
						}
					}
				}
				$_dt[] = array(
					'id_product'		=> $td['id_product'],
					'id_principal'		=> $td['id_principle'],
					'id_kategori'		=> $td['id_kategori'],
					'id_brand'			=> $td['id_brand'],
					'id_area'			=> $td['id_area'],
					'nama_barang'		=> $td['nama_barang'],
					'harga'				=> $td['harga_asli'],
					'hrg_diskon'		=> $td['harga'],
					'diskon'			=> $td['diskon'],							
					'paket'				=> $td['paket'],
					'qty'				=> $td['qty'],
					'deskripsi'			=> $td['deskripsi'],							
					'nama_principal'	=> $td['nama_principal'],
					'nama_kategori'		=> $td['nama_kategori'],
					'nama_brand'		=> $td['nama_brand'],
					'nama_area'			=> $td['nama_area'],
					'nama_barang'		=> $td['nama_barang'],
					'harga'				=> $td['harga'],
					'jml'				=> $td['jml'],
					'note'				=> $td['note'],
					'total'				=> $td['total'],
					'image'				=> $td['img'],
					'lis_paket'			=> $lis_paket
				);
			}
		}
		$status_name = array(
				'0'=> 'Menungu Pembayaran', 
				'1'=> '', 
				'2'=> 'Reject',
				'3'=> 'Approve', 
				'4'=> 'Pesanan Dikirim',
				'5'=> 'Sampai Tujuan',
				'6'=> 'Selesai',
				'7'=> 'Complain'
		);
		$dt = array(
			"kode_payment"		=> $transaksi->kode_payment,
			"id_transaksi"		=> $id_transaksi,
			"id_address"		=> $transaksi->id_address,
			"id_member"			=> $transaksi->id_member,				
			"id_principle"		=> $transaksi->id_principle,				
			"id_provinsi"		=> $transaksi->id_provinsi,							
			"id_city"			=> $transaksi->id_city,
			"id_bank"			=> $transaksi->id_bank,
			"no_rek"			=> $transaksi->no_rek,
			"holder_name"		=> $transaksi->holder_name,
			"nama_bank"			=> $transaksi->nama_bank,
			"nama_principal"	=> $transaksi->nama_principal,
			"nama_member"		=> $transaksi->nama_member,
			"email_member"		=> $transaksi->email_member,
			"phone_member"		=> $transaksi->phone_member,
			"payment"			=> $transaksi->payment,
			"payment_name"		=> $transaksi->payment_name,
			"id_tempo"			=> $transaksi->id_tempo,
			"ttl_tempo_fee"		=> $transaksi->ttl_tempo_fee,
			"tempo"				=> $transaksi->tempo,
			"tempo_type"		=> $transaksi->tempo_type == 1 ? 'IDR' : '%',   //1=>IDR, 2=>%
			"tempo_fee"			=> $transaksi->tempo_fee,
			"nama_provinsi"		=> $transaksi->nama_provinsi,
			"nama_city"			=> $transaksi->nama_city,
			"kode_pos"			=> $transaksi->kode_pos,							
			"alamat_penerima"	=> $transaksi->alamat_penerima,														
			"phone_penerima"	=> $transaksi->phone_penerima,							
			"nama_penerima"		=> $transaksi->nama_penerima,											
			"nama_alamat"		=> $transaksi->nama_alamat,
			"angsuran"			=> $transaksi->angs,
			"status"			=> $transaksi->status,			
			"status_name"		=> $status_name[$transaksi->status],			
			"tanggal"			=> $transaksi->create_at,
			"detail_item"	=> $_dt
		);
		if(!empty($dt)){
			$this->set_response([
				'err_code' 	=> '00',
				'err_msg' 	=> 'Ok',
				'data' 		=> $dt
			], REST_Controller::HTTP_OK);
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Login failed'
			];
			$this->set_response($result, REST_Controller::HTTP_OK);
		}
	}

	function forgot_post(){

		$result = array();
		$nama = '';
		$new_pass = '';
		$save = 0;
		$param = $this->input->post();
		$email = isset($param['email']) ? $param['email'] : '';

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$result = [
				'err_code'	=> '06',
				'err_msg'	=> 'Email invalid format'
			];
			$this->set_response($result, REST_Controller::HTTP_OK);
			return false;
		}
		$chk_email = $this->access->readtable('members','',array('email'=>$email,'deleted_at'=>null))->row();
		$ketemu = count($chk_email);
		if($ketemu > 0){
			$new_pass = $this->converter->random(8);
			$data = array("pass" => $this->converter->encode($new_pass));
			$this->access->updatetable('members',$data, array("id_member" => $chk_email->id_member));
			$save = $email;
		}else{
			$result = [
				'err_code'	=> '07',
				'err_msg'	=> 'Email Not Registered'
			];
			$this->set_response($result, REST_Controller::HTTP_OK);
			return false;
		}

		if($save == $email){

			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}

			$nama = $chk_email->nama;

			// $this->load->library('email');
			$this->load->library('send_notif');
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $email;
			$subject = $out['subj_email_forgot'];
			$content_member = $out['content_forgotPass'];

			$content = str_replace('[#name#]', $nama, $content_member);
			$content = str_replace('[#new_pass#]', $new_pass, $content);
			$content = str_replace('[#email#]', $email, $content);
			$send = $this->send_notif->send_email($from,$pass, $to,$subject, $content);
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'OK, New password was send to your email'
			];
			
			error_log(serialize($send));
			$this->set_response($result, REST_Controller::HTTP_OK);
		}else{

			$result = [
				'err_code'	=> '05',
				'err_msg'	=> 'Insert has problem'
			];
			$this->set_response($result, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

		}

	}
	
	function recomendation_product_post(){
		$param = $this->input->post();
		$sort = array('transaksi_detail.id_kategori','random');
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$login = $this->access->readtable('members','',array('id_member'=>$id_member))->row();
		$id_tier = !empty($login) ? (int)$login->id_tier : 0;
		// $id_tier = isset($param['id_tier']) ? (int)$param['id_tier'] : 0;
		$limit = isset($param['limit']) ? (int)$param['limit'] : '';
		$where = array('transaksi.id_member'=>$id_member,'transaksi.status >=' => 0);
		$transaksi = $this->access->readtable('transaksi_detail','transaksi_detail.id_kategori',$where,array('transaksi' => 'transaksi.id_transaksi = transaksi_detail.id_trans'),5,$sort,'LEFT','transaksi_detail.id_kategori')->result_array();
		$id_kategori = array();
		if(!empty($transaksi)){
			foreach($transaksi as $t){
				array_push($id_kategori, $t['id_kategori']);
				$_id_kategori = implode( ", ", $id_kategori);
			}
			$field_in = 'product.id_kategori';
			$where_in = array($_id_kategori);
			$sort = array('product.cnt','DESC');
			$where = array('product.deleted_at'=>null,'product.qty >'=> 0);
			$select = array('product.*','merchants.nama_merchants','kategori.nama_kategori');
			$products = $this->access->readtable('product',$select,$where,array('merchants' => 'merchants.id_merchants = product.id_merchant','kategori' => 'kategori.id_kategori = product.id_kategori','brand' => 'brand.id_brand = product.id_brand','area' => 'area.id_area = product.id_area'),$limit,$sort,'LEFT','','','', $field_in,$where_in)->result_array();
		}else{
			$sort = array('product.cnt','DESC');
			$where = array('product.deleted_at'=>null,'product.qty >'=> 0);
			$select = array('product.*','merchants.nama_merchants','kategori.nama_kategori');
			$products = $this->access->readtable('product',$select,$where,array('merchants' => 'merchants.id_merchants = product.id_merchant','kategori' => 'kategori.id_kategori = product.id_kategori','brand' => 'brand.id_brand = product.id_brand','area' => 'area.id_area = product.id_area'),$limit,$sort,'LEFT')->result_array();
		}
		$tier = '';
		$diskon = 0;
		$_diskon = 0;		
		if($id_tier > 0){
			$tier = $this->access->readtable('tier','',array('deleted_at'=>null,'id_tier'=>$id_tier))->row();
			$diskon = $tier->diskon > 0 ? $tier->diskon : 0;
			$_diskon = $diskon > 0 ? $diskon / 100 : 0;
		}
		
		$dt = array();		
		$path = '';
		$where_in = array();
		if(!empty($products)){
			foreach($products as $df){
				$id_productk = 0;
				$id_productk = (int)$df['id_product'];
				$where_in[] = "$id_productk";
			}
			$field_in = 'list_diskon.id_product';
			$list_diskon = $this->access->readtable('list_diskon',array('list_diskon.id_product','list_diskon.diskon'),array('list_diskon.deleted_at'=>null,'list_member_diskon.deleted_at'=>null,'list_member_diskon.id_member'=>$id_member),array('list_member_diskon'=> 'list_member_diskon.id_diskon = list_diskon.id_diskon'),'','','LEFT','','','', $field_in,$where_in)->result_array();	
			$diskon2 = array();
			$my_diskon = array();
			if(!empty($list_diskon)){
				foreach($list_diskon as $ld){
					array_push($my_diskon, $ld['id_product']);
					$diskon2[$ld['id_product']] = $ld['diskon'];
				}
			}
			foreach($products as $m){
				$path = '';
				$hrg_diskon = 0;
				$harga = 0;
				$harga = $m['harga'];
				$diskon_product = 0;
				$diskon_product = (int)$products['diskon'] > 0 ? $products['diskon'] / 100 : 0;
				if (in_array($m['id_product'], $my_diskon)) $diskon_product = $diskon2[$id_product] / 100;	
				$hrg_diskon = $harga - ($harga * $_diskon);			
				if($diskon_product > 0){
					$hrg_diskon = $hrg_diskon - ($diskon_product * $hrg_diskon);
				}
				$path = !empty($m['img']) ? base_url('uploads/products/'.$m['img']) : base_url('uploads/no_photo.jpg');
				$dt[] = array(
					'id_product'		=> $m['id_product'],
					'id_principal'		=> $m['id_merchant'],
					'id_kategori'		=> $m['id_kategori'],
					'id_brand'			=> $m['id_brand'],
					'id_area'			=> $m['id_area'],
					'nama_barang'		=> $m['nama_barang'],
					'harga'				=> $harga,
					'hrg_diskon'		=> $hrg_diskon,
					'diskon'			=> $diskon,
					'diskon_produk'		=> $diskon_product * 100,
					'qty'				=> $m['qty'],
					'paket'				=> $m['paket'],
					'deskripsi'			=> $m['deskripsi'],
					'img'				=> $path,
					'nama_principal'	=> $m['nama_merchants'],
					'nama_kategori'		=> $m['nama_kategori'],
					'nama_brand'		=> $m['nama_brand'],
					'nama_area'			=> $m['nama_area'],
					'cnt_beli'			=> $m['cnt']
				);
			}
		}
		if (!empty($dt)){
            $this->set_response([
				'err_code' => '00',
				'err_msg' => 'Ok',
				'data' => $dt
			], REST_Controller::HTTP_OK);
        }else{
            $this->set_response([
                'err_code' => '04',
                'err_msg' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	function upd_status_post(){
	    $this->load->library('send_notif');
		$param = $this->input->post();		
		$id_transaksi = isset($param['id_transaksi']) ? (int)$param['id_transaksi'] : 0;
		$status = isset($param['status']) ? (int)$param['status'] : 6;
		$dt_transaksi = $this->access->readtable('transaksi', '', array('transaksi.id_transaksi' => $id_transaksi))->row();		
		$id_member = $dt_transaksi->id_member;
		$id_principle = $dt_transaksi->id_principle;
		$ids = array();
		if($status == 2){
			$pesan_fcm = 'Pesanan direject';
			$ttl = $dt_transaksi->ttl_all;
			$dt_members = $this->access->readtable('members', '', array('id_member' => $id_member))->row();
			$transaksi_detail = $this->access->readtable('transaksi_detail', '', array('id_trans' => $id_transaksi))->result_array();
			$ids = array($dt_members->gcm_token);
			if(!empty($transaksi_detail)){
				foreach($transaksi_detail as $td){
					$id_produk = 0;
					$jml = 0;
					$id_produk = (int)$td['id_product'];
					$jml = (int)$td['jml'];
					$id_whs = (int)$td['id_whs'];
					$dt_product = '';					
					$stok = 0;
					if($jml > 0 && $id_produk > 0){
						$dt_product = $this->access->readtable('stok', '', array('id_product' => $id_produk,'deleted_at'=>null,'id_wh'=>$id_whs))->row();
						$stok = (int)$dt_product->stok > 0 ? (int)$dt_product->stok : 0;
						$stok = $stok + $jml;
						$this->access->updatetable('stok', array('stok' => $stok), array('id_product' => $id_produk,'deleted_at'=>null,'id_wh'=>$id_whs));
					}
				}
			}
			$sisa_credit = 0;
			$use_credit = 0;
			$sisa_credit = $dt_members->sisa_credit + $ttl;
			$use_credit = $dt_members->use_credit - $ttl;
			$this->access->updatetable('members',array('sisa_credit'=>$sisa_credit,'use_credit' => $use_credit), array('id_member' => $id_member));	
			if(!empty($ids)){
				$data_fcm = array(
					'id_notif'		=> $id_transaksi,
					'title'			=> 'GTS',
					'status'		=> $status,	
					'message' 		=> $pesan_fcm,
					'notif_type' 	=> '2'
				);
				$notif_fcm = array(
					'body'			=> $pesan_fcm,
					'title'			=> 'GTS',
					'badge'			=> '1',
					'sound'			=> 'Default'
				);	
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
		}
		$where = array(
			'id_transaksi' => $id_transaksi
		);
		$simpan = array(
			'status'		=> $status
		);
		$this->access->updatetable('transaksi', $simpan, $where);
		if($status == 6) $this->access->updatetable('id_trans_auto', array('deleted_at'=> date('Y-m-d H:i:s')), array('id_trans'=>$id_transaksi));
		$this->set_response([
			'err_code' => '00',
			'message' => 'Ok'
		], REST_Controller::HTTP_OK);
	}
	
	function chat_admin_post(){
		$param = $this->input->post();		
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$pesan = isset($param['pesan']) ? $param['pesan'] : '';
		$simpan = array(
			'id_member'		=> $id_member,
			'pesan'			=> $pesan,
			'created_at'	=> date('Y-m-d H:i:s')
		);
		$save = $this->access->inserttable('chat_admin',$simpan);
		$this->set_response([
			'err_code' => '00',
			'message' => 'Ok'
		], REST_Controller::HTTP_OK);
	}
	
	function chat_post(){
		$param = $this->input->post();
		$user_id_form = isset($param['user_id_member']) ? (int)$param['user_id_member'] : 0;
		$user_id_to = 'admin';
		$content = isset($param['content']) ? $param['content'] : '';
		$datas = array();
		$master_chat = '';
		$members = $this->access->readtable('members','',array('members.id_member'=>$user_id_form))->row();
		
		$master_chat = $this->access->readtable('master_chat','',array('id_member'=>$user_id_form))->row();
		$id_chat = !empty($master_chat) ? (int)$master_chat->id_chat : 0;
		if($id_chat > 0){
			$datas = array('content'=>$content,'status_count'=>1);
			$this->access->updatetable('master_chat', $datas, array('id_chat'=>$master_chat->id_chat));
			$id_chat = $master_chat->id_chat;
		}else{
			$datas = array('id_member'=>$user_id_form,'content'=>$content,'status_count'=>1);
			$save_chat = $this->access->inserttable('master_chat', $datas);
			$id_chat = $save_chat;
		}
		
		$data = array(	
			'user_id_from'	=> $user_id_form,
			'user_id_to'	=> $user_id_to,
			'content'		=> $content,
			'date_create'	=> date('Y-m-d H:i:s'),				
			'dari'			=> $members->nama,
			'ke'			=> 'Admin',
			'status'		=> 1,
			'id_chat'		=> $id_chat			
		);
		$save = $this->access->inserttable('messages', $data);
		if($save){
			$this->set_response([
				'err_code' => '00',
				'message' => 'Ok'
			], REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'err_code' => '03',
				'message' => 'Insert has problem'
			], REST_Controller::HTTP_OK);
		}
	}
	
	
	
	function list_chat_detail_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
				
		$m_chat = $this->access->readtable('master_chat','',array('id_member'=>$id_member))->row();		
		$datas = array();
		$members = '';
		$merchants = '';		
		$chats = $this->access->readtable('messages','',array('id_chat'=>$m_chat->id_chat))->result_array();		
		if(!empty($chats)){
			foreach($chats as $c){			
				$dt[] = array(
					'user_id_from'	=> $c['user_id_from'],
					'user_id_to'	=> $c['user_id_to'],
					'dari'			=> $c['dari'],
					'ke'			=> $c['ke'],
					'content'		=> $c['content'],
					'chat_dari'		=> 'Admin',
					'unread'		=> (int)$m_chat->status_member > 0 ? (int)$m_chat->status_member : 0,
					'tgl'			=> date('d-m-Y H:i', strtotime($c['date_create']))
				);
			}
		}
		
		if (!empty($dt)){
            $res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }	
	}
	
	function unread_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;		
		$datas = array('status_member'=>0);
		$this->access->updatetable('master_chat', $datas, array('id_member'=>$id_member));
		$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok'
		);
        $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	}
	
	function status_unread_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;		
		$m_chat = $this->access->readtable('master_chat','',array('id_member'=>$id_member))->row();	
		$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
				'data'		=> array('unread' => (int)$m_chat->status_member > 0 ? (int)$m_chat->status_member : 0)
		);
        $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	}
	
	function fcmid_post(){
		$result = array();	
		
		$param = $this->input->post();
		$user_id = isset($param['id_member']) ? $param['id_member'] : '';
		$gcm_id = isset($param['fcm_token']) ? $param['fcm_token'] : '';		
		$device = isset($param['device']) ? $param['device'] : 1;		
		//if($device == 1){
		//	$device = "ios";
		//}else if($device == 2){
		//	$device = "android";
		////}else{
			$device = $device;
		//}
		$simpan = array(
			'device'	=> $device,
			'gcm_token'	=> $gcm_id
		);
		if(!empty($user_id) && !empty($gcm_id)){
			$this->access->updatetable('members',$simpan, array("id_member"=>$user_id));
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'OK'
			];					
		}else{
			$result = [
				'err_code'	=> '01',
                'err_msg'	=> 'Param id_member or gcm_token can\'t empty.' 
			];			
		}
		$this->set_response($result, REST_Controller::HTTP_OK);		
	}
	
}

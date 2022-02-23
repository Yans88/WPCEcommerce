<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_notif

{
	protected 	$ci;
	public function __construct() {		
		// $this->load->library('converter');
		$this->ci =& get_instance();
		$this->ci->load->library('email');		
	}
	
	
	public function send_email($from=null,$pass=null, $to=null,$subject=null, $body=null){
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://mail.andtechnology.me',
			'smtp_port' => 465,
			//'smtp_host' => 'mail.idijakbar.org',
			//'smtp_port' => 25,
			'smtp_timeout' => 5,
			'smtp_user' => $from,
			'smtp_pass' => $pass,
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'crlf' => "\r\n",
			'newline' => "\r\n",
			'wordwrap' => TRUE
		);		
			   
		$this->ci->email->initialize($config);
		$this->ci->email->from($from, 'GTS');
		$this->ci->email->to($to);
		$this->ci->email->subject($subject);
		$this->ci->email->message($body);
		$save = $this->ci->email->send();
		
		return $save;					   
	}
	
	//{
  //"notification": {
   // "body": "New Order",
   // "badge": "1",
    // "sound":"Default"
  //},
  //"data": {
    //"id_transaksi": $save,
    //"notif_type":1
  //}
  //"registration_ids": ["token"]
//}

    function send_fcm($data_fcm=array(), $notif_fcm=array(), $target){
		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$server_key = 'AIzaSyCNK-xpPLNR67fWAoLnzGrE_orZVSO9ptM';
					
		$fields = array();
		
		$fields['data'] = $data_fcm;
		$fields['notification'] = $notif_fcm;
		if(is_array($target)){
			$fields['registration_ids'] = $target;
		}else{
			$fields['to'] = $target;
		}
		//header with content_type api key
		
		$headers = array(
			'Content-Type:application/json',
			'Authorization:key='.$server_key
		);
					
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
		//error_log(serialize(json_encode($fields)));
		
		return $result;
	}	
	
	
	
	function send_fcm_ios($data=array(),$target=array()){
		$url = 'https://fcm.googleapis.com/fcm/send';
		//api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
		$server_key = 'AIzaSyBCN1Vc6_qQwfwL1QX8rxO7OzMgPWMZc9w';
					
		$fields = array();
		$fields['notification'] = $data['notification'];
		$fields['priority'] = $data['priority'];
		if(is_array($target)){
			$fields['registration_ids'] = $target;
		}else{
			$fields['to'] = $target;
		}
		//header with content_type api key
		$headers = array(
			'Content-Type:application/json',
			'Authorization:key='.$server_key
		);
					
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
	}	
	
}

?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_api

{
	protected 	$ci;
	public function __construct() {		
		$this->ci =& get_instance();
	}
	
	
	function send_data($url= '', $data=array(), $auth='', $_id='', $method='POST'){
		
		$fields = array();
		// $headers = array(
			// "Content-Type:application/json",
			// "Authorization:$auth",
			// "ID:$_id"
		// );
		$headers = array(
			"Content-Type:application/json"
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		//error_log(serialize($headers));
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
		
		return $result;
	}	
	
	function post_data($url= '', $data=array()){
		
		$fields = array();
		$headers = array(
			"cache-control: no-cache",
    		"content-type: multipart/form-data;"
		);
				
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Post Error: ' . curl_error($ch));
		}
		curl_close($ch);
		//return $result;
		return substr($result,4);
	}	
	
	public function apiRequest($url='',$data = ''){
		//$this->set_param();
		// $this->checkParams($this->requestData);
		$postData = '';
		foreach ($data as $key => $value) {
		  $postData .= urlencode($key) . '='.urlencode($value).'&';
		}
		$postData = rtrim($postData, '&');
		$headers = array(
			"cache-control: no-cache",
    		"content-type: multipart/form-data;"
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$result = curl_exec($ch);
		return substr($result,4);
	}
	
	function test($url='',$data=''){

		$curl = curl_init();
		$postData = '';
		foreach ($data as $key => $value) {
		  $postData .= urlencode($key) . '='.urlencode($value).'&';
		}
		$postData = rtrim($postData, '&');
		//error_log('post data 1 : '.$postData);
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $postData,
		  CURLOPT_HTTPHEADER => array(
			"Content-Type: application/x-www-form-urlencoded",
			
			"cache-control: no-cache"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return "cURL Error #:" . $err;
		} else {
		  return $response;
		}
	
	}
	
}

?>
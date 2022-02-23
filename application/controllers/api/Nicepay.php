<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Nicepay extends REST_Controller {

    function __construct(){
        parent::__construct();
		$this->load->library('send_notif');
		$this->load->library('send_api');
		$this->load->model('Setting_m','sm',true);
		$this->load->model('Access','access',true);
    }

   
	
	function register_payment_post(){
		$param = $this->input->post();
		//$url = 'https://dev.nicepay.co.id/nicepay/direct/v2/registration';	
		$url = 'https://www.nicepay.co.id/nicepay/direct/v2/registration';
		$timeStamp = date('YmdHis');
		$iMid = 'IONPAYTEST';
		$mkey   = '33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==';
		$cash_type = isset($param['cash_type']) ? (int)$param['cash_type'] : 01;
		$list_item = isset($param['cartData']) ? json_decode($param['cartData']) : '';
		$referenceNo = 'ORD12345';
		$amt = '10000';
		$currency = 'IDR';
	    $merchantToken = hash('sha256', $timeStamp.$iMid.$referenceNo.$amt.$mkey);
		$goodsNm = 'Test Transaction Nicepay';
		$billingNm = 'Customer Name';
		$billingPhone = '12345678';
		$billingEmail = 'test@mail.com';
		$billingCity = 'Jakarta Pusat';
		$billingState = 'DKI Jakrta';
		$billingPostCd = '10210';
		$billingCountry = 'Indonesia';
		$callBackUrl = 'http://www.merchant.com/ExampleCallback';
		$dbProcessUrl = 'http://www.merchant.com/ExampleDbProcess';
		$description = 'GTS Order #123';
		$userIP = $_SERVER['REMOTE_ADDR'];
		$instmntType = 1;
		$instmntMon = 1;
		$bankCd = 'BMRI';
		$cartData = array();
		$cnt_item = count($list_item) ;
		if($cnt_item > 0){
			$cartData = array(
				'count'	=> $cnt_item,
				'item'	=> $list_item,
			);
		}	
		
		
		if($cash_type == 01){ // CC
			$url = 'https://www.nicepay.co.id/nicepay/api/orderRegist.do';
			$merchantToken = hash('sha256', $iMid.$referenceNo.$amt.$mkey);
			$post_data = array(
				"iMid"				=>$iMid,
				"payMethod"			=>"0".$cash_type,
				"currency"			=>"IDR",
				"amt"				=>$amt,
				"instmntType"		=>$instmntType,
				"instmntMon"		=>$instmntMon,
				"referenceNo"		=>$referenceNo,
				"goodsNm"			=>"Test Transaction Nicepay",
				"billingNm"			=>"Customer Name",
				"billingPhone"		=>"12345678",
				"billingEmail"		=>"email@merchant.com",
				"billingAddr"		=>"Jalan Bukit Berbunga 22",
				"billingCity"		=>"Jakarta",
				"billingState"		=>"DKI Jakarta",
				"billingPostCd"		=>"12345",
				"billingCountry"	=>"Indonesia",
				"callBackUrl"		=>$callBackUrl,
				"dbProcessUrl"		=>$dbProcessUrl,
				"description"		=>"Transaction Description",
				"merchantToken"		=>$merchantToken,
				"userIP"			=>"127.0.0.1",
				"cartData"			=>"{}"			
			);
			$res_nicepay = $this->send_api->apiRequest($url,$post_data);
			$result = json_decode($res_nicepay);
			if(isset($result->data->resultCd) && $result->data->resultCd == "0000"){
			    $res_nicepay = array();
			    $res_nicepay = array(
			            'result_code'    => $result->data->resultCd,
			            'result_message'    => $result->data->resultMsg,
			            'requestURL'    => $result->data->requestURL.'?tXid='.$result->tXid
			        );
              
            } elseif (isset($result->data->resultCd)) {
                $res_nicepay = array();
			    $res_nicepay = array(
			            'result_code'    => $result->data->resultCd,
			            'result_message'    => $result->data->resultMsg
			        );
            }else{
                $res_nicepay = array();
                $res_nicepay = array(
			            'result_message'    => 'Connection Timeout. Please Try again.',
			        );
            }
			
		}
		if($cash_type == 02){
			// $url = 'https://www.nicepay.co.id/nicepay/api/onePass.do';
			$post_data = array(				
				"timeStamp"=>$timeStamp,
				"iMid"=>"IONPAYTEST",
				"payMethod"=>"0".$cash_type,
				"currency"=>"IDR",
				"amt"=>$amt,
				"referenceNo"=>$referenceNo,
				"goodsNm"=>"Test Transaction Nicepay",
				"billingNm"=>"Customer Name",
				"billingPhone"=>"12345678",
				"billingEmail"=>"email@merchant.com",
				"billingAddr"=>"Jalan Bukit Berbunga 22",
				"billingCity"=>"Jakarta",
				"billingState"=>"DKI Jakarta",
				"billingPostCd"=>"12345",
				"billingCountry"=>"Indonesia",
				"deliveryNm"=>"email@merchant.com",
				"deliveryPhone"=>"12345678",
				"deliveryAddr"=>"Jalan Bukit Berbunga 22",
				"deliveryCity"=>"Jakarta",
				"deliveryState"=>"DKI Jakarta",
				"deliveryPostCd"=>"12345",
				"deliveryCountry"=>"Indonesia",
				"description"=>"Transaction Description",
				"dbProcessUrl"=>"http=>//ptsv2.com/t/0ftrz-1519971382/post",
				"merchantToken"=>$merchantToken,
				"reqDomain"=>site_url(),
				"reqServerIP"=>"127.0.0.1",
				"userIP"=>"127.0.0.1",
				"userSessionID"=>"",
				"userAgent"=> $_SERVER['HTTP_USER_AGENT'],
				"userLanguage"=>"ko-KR,en-US;q=0.8,ko;q=0.6,en;q=0.4",
				"cartData"=>"{}",
				"bankCd"=>"CENA",
				"vacctValidDt"=>"20191228",
				"vacctValidTm"=>"091309",
				"merFixAcctId"=>""				
			);
			$res_nicepay = $this->send_api->send_data($url,$post_data);
			$res_nicepay = json_decode($res_nicepay);
		}
		
		$this->set_response([
			'err_code' 		=> '00',
			'err_msg' 		=> 'Ok',
			'tanggal'		=> date('d-m-Y H:i:s'),
			'post_data'		=> $post_data,
			'iMid'			=> $iMid,
			'mkey'			=> $mkey,
			'url'			=> $url,
			'result_nicepay'	=> $res_nicepay
		], REST_Controller::HTTP_OK);
	}
	
	public function chk_payment_post(){
		$iMid = "IONPAYTEST";
		$merchantKey   = '33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==';
		
		$param = $this->input->post();
		$amt = isset($param['amt']) ? $param['amt'] : 0;
		$referenceNo = isset($param['referenceNo']) ? $param['referenceNo'] : '';
		$tXid = isset($param['tXid']) ? $param['tXid'] : '';
		// data dari andtech
		$amt = "5400560";
		$referenceNo = "31909171136";
		$tXid = "IONPAYTEST02201909171136239034";	
		
		$merchantToken = hash("sha256",$iMid.$referenceNo.$amt.$merchantKey);
		$post_data = array(		
			"tXid"			=> $tXid,
			"iMid"			=> $iMid,
			"referenceNo"	=> $referenceNo,
			"amt"			=> $amt,
			"merchantToken"	=> $merchantToken			
			
		);
		$url = 'https://dev.nicepay.co.id/nicepay/api/onePassStatus.do';
		// $res_nicepay = $this->send_api->send_data($url,$post_data);
		$res_nicepay = $this->send_api->test($url, $post_data);
		$result = json_decode($res_nicepay);
		
        if(isset($result->resultCd) && $result->resultCd == '0000'){
			$this->set_response([				
				'tXid'					=> $result->tXid,
				'result_code'			=> $result->resultCd,
				'result_message'		=> $result->resultMsg,
				'referenceNo'			=> $result->referenceNo,
				'payment_method'		=> $result->payMethod,
				'currency'				=> $result->currency,
				'amt'					=> $result->amt,
				'installment_month'		=> $result->instmntMon,
				'status'				=> $result->status,
				'result_nicepay'		=> $result,
				'post_data'				=> $post_data,
				'url'					=> $url
			], REST_Controller::HTTP_OK);
			
		 
		}elseif (isset($result->resultCd)) {
		  // API data not correct, you can redirect back to checkout page or echo error message.
		  // In this sample, we echo error message
			$this->set_response([				
				
				'result_code'			=> $result->resultCd,
				'result_message'		=> $result->resultMsg,
				'post_data'				=> $post_data,
				'url'					=> $url
				
			], REST_Controller::HTTP_OK);
		 
		}else {
			$this->set_response([				
				
				'result_code'			=> 08,
				'result_message'		=> 'Timeout When Checking Payment Status'
				
			], REST_Controller::HTTP_OK);
			
		}     
	}
	
}
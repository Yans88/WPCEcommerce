<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nicepay_calldb extends CI_Controller {

	public function __construct(){
        parent::__construct();        
		$this->load->model('Access', 'access', true);		
		$this->load->model('Setting_m','sm', true);
		$this->load->library('send_notif');
		$this->load->library('send_api');
    }
	
        //backend
	public function index(){
		$iMid = "IONPAYTEST";
		$merchantKey = "33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==";
		$amt = $_GET['amount'];
		$referenceNo = $_GET['referenceNo'];		
		$tXid = $_GET['tXid'];
		$merchantToken = hash("sha256",$iMid.$referenceNo.$amt.$merchantKey);
		$url = 'https://dev.nicepay.co.id/nicepay/api/onePassStatus.do';
		
		$post_data = array(		
			"tXid"			=> $tXid,
			"iMid"			=> $iMid,
			"referenceNo"	=> $referenceNo,
			"amt"			=> $amt,
			"merchantToken"	=> $merchantToken		
			
		);
		$res_nicepay = $this->send_api->test($url,$post_data);
		$result = json_decode($res_nicepay);
		error_log('callback url');
		error_log(serialize($_GET));
		error_log(serialize($result));
		error_log('end callback url');
        if(isset($result->resultCd) && $result->resultCd == '0000'){
		  // echo "<pre>";
		  // echo "tXid              : $result->tXid (Save to your database to check status) \n";
		  // echo "result code       : $result->resultCd\n";
		  // echo "result message    : $result->resultMsg\n";
		  // echo "reference no      : $result->referenceNo\n";
		  // echo "payment method    : $result->payMethod\n";
		  // echo "currency          : $result->currency\n";
		  // echo "amt               : $result->amt\n";
		  // echo "installment month : $result->instmntMon\n";
		  // echo "status            : $result->status\n";
		  // echo "</pre>";
			echo 'Transaction Success';
			echo '<script>console.log(\'RECEIVEOK\');</script>';
		}elseif (isset($result->resultCd)) {
		  // API data not correct, you can redirect back to checkout page or echo error message.
		  // In this sample, we echo error message
			echo "<pre>";
			echo "result code       :".$result->resultCd."\n";
			echo "result message    :".$result->resultMsg."\n";
			echo "</pre>";
			echo 'Transaction Failed';
			echo '<script>console.log(\'RECEIVEFALSE\');</script>';
		}else {
		  // echo "<pre>";
		  // echo "Timeout When Checking Payment Status";
		  // echo "</pre>";
			echo 'Transaction Failed';
			echo '<script>console.log(\'RECEIVEFALSE\');</script>';
		}     
	}
	
	function db_process(){
		$iMid = "IONPAYTEST";		
		$merchantKey = "33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==";
		$amt = $_REQUEST['amt'];
		$referenceNo = $_REQUEST['referenceNo'];
		$merchantToken = hash("sha256",$iMid.$referenceNo.$amt.$merchantKey);
		$tXid = $_REQUEST['tXid'];
		$pushedToken = $_REQUEST['merchantToken'];
		$merchantTokenC = hash('sha256',$iMid.$tXid.$amt.$merchantKey);
		$dt_upd = array();
		$post_data = array(		
			"tXid"			=> $tXid,
			"iMid"			=> $iMid,
			"referenceNo"	=> $referenceNo,
			"amt"			=> $amt,
			"merchantToken"	=> $merchantToken		
			
		);
		$url = 'https://dev.nicepay.co.id/nicepay/api/onePassStatus.do';
		$res_nicepay = $this->send_api->test($url,$post_data);
		$result = json_decode($res_nicepay);
		error_log('db_process');
		error_log($result->bankCd);
		error_log(serialize($_REQUEST));
		error_log(serialize($result));
		error_log('end db_process');
		//Process Response Nicepay
		if($pushedToken == $merchantTokenC){
		  if(isset($result->bankCd)){
			if($result->status == '0'){
				$dt_upd = array(
					'status'			=> 3, 				//approve
					'status_pg'			=> $result->status,
					'status_name_pg'	=> 'Transaction Status VA Paid',
					'date_pg'			=> date("Y-m-d H:i:s"),
				);
				// $createlog(date("Y-m-d H:i:s")." Reference No. ".$referenceNo." - Transaction Status VA Paid "."\n");
			}elseif ($result->status == '1') {
				$dt_upd = array(
					'status'			=> 8, 				// Cancel/Expired payment
					'status_pg'			=> $result->status,
					'status_name_pg'	=> 'Transaction Status VA Reversal',
					'date_pg'			=> date("Y-m-d H:i:s"),
				);
				// $createlog(date("Y-m-d H:i:s")." Reference No. ".$referenceNo." - Transaction Status VA Reversal "."\n");
			}elseif ($result->status == '3') {
				$dt_upd = array(
					'status'			=> 8, 				// Cancel/Expired payment
					'status_pg'			=> $result->status,
					'status_name_pg'	=> 'Transaction Status VA Canceled',
					'date_pg'			=> date("Y-m-d H:i:s"),
				);
				// $createlog(date("Y-m-d H:i:s")." Reference No. ".$referenceNo." - Transaction Status VA Canceled "."\n");
			}elseif ($result->status == '4') {
				$dt_upd = array(
					'status'			=> 8, 				// Cancel/Expired payment
					'status_pg'			=> $result->status,
					'status_name_pg'	=> 'Transaction Status VA Expired',
					'date_pg'			=> date("Y-m-d H:i:s"),
				);
				// $createlog(date("Y-m-d H:i:s")." Reference No. ".$referenceNo." - Transaction Status VA Expired "."\n");
			}else {
				$dt_upd = array(
					'status'			=> 8, 				// Cancel/Expired payment
					'status_pg'			=> '',
					'status_name_pg'	=> 'Transaction Status VA Unknown',
					'date_pg'			=> date("Y-m-d H:i:s"),
				);
				// $createlog(date("Y-m-d H:i:s")." Reference No. ".$referenceNo." - Payment Status Unknown "."\n");
			}
		  }else{
			if($result->status == '0'){
				$dt_upd = array(
					'status'			=> 3, 				//approve
					'status_pg'			=> $result->status,
					'status_name_pg'	=> 'Transaction Status CC Success',
					'date_pg'			=> date("Y-m-d H:i:s"),
				);
				// $createlog(date("Y-m-d H:i:s")." Reference No. ".$referenceNo." - Transaction Status CC Success "."\n");
			}elseif ($result->status == '1') {
				$dt_upd = array(
					'status'			=> 8, 				// Cancel/Expired payment
					'status_pg'			=> $result->status,
					'status_name_pg'	=> 'Transaction Status CC Void',
					'date_pg'			=> date("Y-m-d H:i:s"),
				);
				// $createlog(date("Y-m-d H:i:s")." Reference No. ".$referenceNo." - Transaction Status CC Void "."\n");
			}elseif ($result->status == '2') {
				$dt_upd = array(
					'status'			=> 8, 				// Cancel/Expired payment
					'status_pg'			=> $result->status,
					'status_name_pg'	=> 'Transaction Status CC Refund',
					'date_pg'			=> date("Y-m-d H:i:s"),
				);
				// $createlog(date("Y-m-d H:i:s")." Reference No. ".$referenceNo." - Transaction Status CC Refund "."\n");
			}elseif ($result->status == '9') {
				$dt_upd = array(
					'status'			=> 8, 				// Cancel/Expired payment
					'status_pg'			=> $result->status,
					'status_name_pg'	=> 'Transaction Status CC Unpaid',
					'date_pg'			=> date("Y-m-d H:i:s"),
				);
				//$createlog(date("Y-m-d H:i:s")." Reference No. ".$referenceNo." - Transaction Status CC Unpaid "."\n");
			}else {
				$dt_upd = array(
					'status'			=> 8, 				// Cancel/Expired payment
					'status_pg'			=> $result->status,
					'status_name_pg'	=> 'Transaction Status CC Unknown',
					'date_pg'			=> date("Y-m-d H:i:s"),
				);
				// $createlog(date("Y-m-d H:i:s")." Reference No. ".$referenceNo." - Payment Status Unknown "."\n");
			}
		  }
		}else {
			$dt_upd = array(
					'status'			=> 8, 				// Cancel/Expired payment
					'status_pg'			=> $result->status,
					'status_name_pg'	=> 'Token Not Match',
					'date_pg'			=> date("Y-m-d H:i:s"),
				);
			// $createlog(date("Y-m-d H:i:s")." Reference No. ".$referenceNo." - Token Not Match "."\n");
		}
		$where = array(
			'kode_payment' => $referenceNo
		);
		$this->access->updatetable('transaksi', $dt_upd, $where);
		error_log($this->db->last_query());
		error_log(serialize($dt_upd));
	}

	
	
}
	
	
    
   

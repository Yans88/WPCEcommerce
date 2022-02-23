<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complete_trans extends CI_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {	
		$tgl = date('Y-m-d H:i');	
		$where = array('date_format(completed_at, "%Y-%m-%d %H:%i") <='=> $tgl, 'deleted_at'=>null);
		$auto = $this->access->readtable('id_trans_auto','',$where)->result_array();
		error_log('cron0 : '.$this->db->last_query());
		if(!empty($auto)){
			foreach($auto as $a){
				$where = array(
					'id_transaksi' => $a['id_trans']
				);
				$simpan = array(
					'status'		=> 6
				);
				$this->access->updatetable('transaksi', $simpan, $where);	
				error_log('cron1 : '. $this->db->last_query());
				$this->access->updatetable('id_trans_auto', array('deleted_at'=> date('Y-m-d H:i:s')), array('id_trans'=>$a['id_trans']));
				error_log('cron2 : '.$this->db->last_query());
			}
			
		}
	}
	
	
	
	


}

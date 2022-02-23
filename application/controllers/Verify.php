<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('Access', 'access', true);
	}


	public function index(){
		$id	= $this->input->get('id');		
		$result	= array();
		$res['dt'] = 'Failed';
		if(!empty($id)){
			$id	= $this->converter->decode($id);
			$login = $this->access->readtable('members','',array('id_member'=>$id))->row();
			if($login->status_by > 0){
				$res['dt'] = 'Failed';
			}else{
				$data =array('status' => 1);
				$this->access->updatetable('members',$data, array("id_member" => $id));	
				$res['dt'] = 'Congratulation';
			}
		}
		
		$this->load->view('themes/verify', $res);
	}
	
	
	
}

?>
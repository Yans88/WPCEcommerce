<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';


class Category extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();       
		$this->load->model('Access','access',true);	
		$this->load->model('Setting_m','sm', true);
		// $this->load->library('converter');
    }

    public function index_get(){
        $id = $this->get('id');	
		$id = (int)$id;
		$kategori = '';
		$sort = array('nama_kategori','ASC');
		if($id > 0){
			$kategori = $this->access->readtable('kategori','',array('id_kategori'=>$id,'deleted_at'=>null),'','',$sort)->result_array();
		}else{
			$kategori = $this->access->readtable('kategori','',array('deleted_at'=>null),'','',$sort)->result_array();
		}
		$dt = array();
		$path = '';
		if(!empty($kategori)){
			foreach($kategori as $k){
				$path = !empty($k['img']) ? base_url('uploads/kategori/'.$k['img']) : base_url('uploads/no_photo.jpg');
				if($k['nama_kategori'] != 'Banner'){
					$dt[] = array(
						"id_kategori"		=> $k['id_kategori'],
						"nama_kategori"		=> $k['nama_kategori'],
						'image'				=> $path
					);
				}
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
		
	public function index_post(){
		$param = $this->input->post();
		$keyword = isset($param['keyword']) ? $param['keyword'] : 0;
		$id_merchant = isset($param['id_principal']) ? (int)$param['id_principal'] : 0;
		$_like = array();
		$where = array('kategori.deleted_at'=>null);
		if(!empty($keyword)){
			$keyword = $this->db->escape_str($keyword);
			// $_like = array('newphone'=>$keyword);
		}
		if($id_merchant > 0){
			$where += array('kategori.id_merchant'=> $id_merchant);
		}
		$sort = array('nama_kategori','ASC');
		$select = array('kategori.nama_kategori','sub_kategori.* ');
		$kategori = $this->access->readtable('kategori','',$where,array('merchants' => 'merchants.id_merchants = kategori.id_merchant'),'',$sort,'LEFT','',$_like)->result_array();
	
		$dt = array();
		$path = '';
		if(!empty($kategori)){
			foreach($kategori as $k){
				$path = !empty($k['img']) ? base_url('uploads/kategori/'.$k['img']) : base_url('uploads/no_photo.jpg');
				if($k['nama_kategori'] != 'Banner'){
					$dt[] = array(
						"id_kategori"		=> $k['id_kategori'],
						"nama_kategori"		=> $k['nama_kategori'],
						'image'				=> $path,
						'id_principal'		=> $k['id_merchants'],
						'nama_principal'		=> $k['nama_merchants']
					);
				}
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
	
	
	
}

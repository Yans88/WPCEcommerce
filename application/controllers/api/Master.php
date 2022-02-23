<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Master extends REST_Controller {

    function __construct(){        
        parent::__construct();	
		$this->load->library('send_notif');	
		$this->load->model('Api_m');	
		$this->load->model('Access','access',true);		
    }	
	
	public function banners_get(){
        $id = $this->get('id');	
		$id = (int)$id;
		$_banner = '';
		$_banner = $this->access->readtable('banner','',array('deleted_at'=>null))->result_array();		
		$dt = array();
		$path = '';
		$dataku = array();		
		if(!empty($_banner)){
			foreach($_banner as $k){
				$path = !empty($k['img']) ? base_url('uploads/banner/'.$k['img']) : base_url('uploads/no_photo.jpg');
				$dt[] = array(
					'id_banner'		=> $k['id_banner'],						
					'image'			=> $path
				);
			}
			$dataku = array(
				'err_msg' 	=> 'ok',
				'err_code' 	=> '00',
				'data' 		=> $dt	
			);
		}
				
		if (!empty($dataku)){
            $this->set_response($dataku, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'err_msg' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
        }
    }
	
	function tc_get(){
		$term_condition = $this->Api_m->get_key_val();
		$tc = isset($term_condition['term_condition']) ? $term_condition['term_condition'] : '';
		$tcku = array();
		$dataku = array();
		if(!empty($tc)){
			$tc = preg_replace("/<p[^>]*?>/", "", $tc);
			$tc = str_replace("</p>", "", $tc);
			//$tc = str_replace("\r\n","<br />",$tc);
			$tcku = [
					'term_condition' 	=> $tc		
			];
			$dataku = array(
				'err_msg' 	=> 'ok',
				'err_code' 	=> '00',
				'data' 		=> $tc	
			);
			$this->set_response($dataku, REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'data' 	=> $tc,
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
		}
	}
	
	function policy_get(){
		$policy = $this->Api_m->get_key_val();
		$p = isset($policy['policy']) ? $policy['policy'] : '';
		$tc = array();
		$dataku = array();
		if(!empty($p)){
			$p = preg_replace("/<p[^>]*?>/", "", $p);
			$p = str_replace("</p>", "", $p);
			//$p = str_replace("\r\n","<br />",$p);
			$tc = [
					'policy' 	=> $p		
			];
			$dataku = array(
				'err_msg' 	=> 'ok',
				'err_code' 	=> '00',
				'data' 		=> $p	
			);
			$this->set_response($dataku, REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'data' 	=> $p,
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
		}
	}
	
	public function tempo_get(){
        $id = $this->get('id');	
		$id = (int)$id;
		$_banner = '';
		$_banner = $this->access->readtable('master_payment','',array('deleted_at'=>null))->result_array();		
		$dt = array();
		$path = '';
		$dataku = array();		
		if(!empty($_banner)){
			foreach($_banner as $k){
				
				$dt[] = array(
					'id_payment'	=> $k['id_payment'],						
					'tempo'			=> $k['nama_payment'],
					'admin_fee'		=> $k['admin_fee'],
					'type'			=> $k['type'],
					'type_name'		=> $k['type'] > 1 ? '%' : 'IDR',	
				);
			}
			$dataku = array(
				'err_msg' 	=> 'ok',
				'err_code' 	=> '00',
				'data' 		=> $dt	
			);
		}
				
		if (!empty($dataku)){
            $this->set_response($dataku, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'err_msg' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
        }
    }
	
	function provinsi_get(){
		$dataku = array();	
		$_prov = $this->access->readtable('provinsi','',array('deleted_at'=>null))->result_array();		
		if(!empty($_prov)){
			foreach($_prov as $p){
				
				$dt[] = array(
					'id_provinsi'	=> $p['id_provinsi'],						
					'nama_provinsi'	=> $p['nama_provinsi']
				);
			}
			$dataku = array(
				'err_msg' 	=> 'ok',
				'err_code' 	=> '00',
				'data' 		=> $dt	
			);
		}
		if (!empty($dataku)){
            $this->set_response($dataku, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'err_msg' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
        }
	}
	
	function city_post(){
		$dataku = array();	
		$where = array('deleted_at'=>null);
		$param = $this->input->post();
		$id_provinsi = isset($param['id_provinsi']) ? (int)$param['id_provinsi'] : 0;
		$prov = '';
		if($id_provinsi > 0){
			$where += array('id_provinsi' => $id_provinsi);
			$prov = $this->access->readtable('provinsi','',$where)->row();
		}
		$city = $this->access->readtable('city','',$where)->result_array();		
		if(!empty($city)){
			foreach($city as $p){
				
				$dt[] = array(
					'id_provinsi'	=> $p['id_provinsi'],						
					'id_city'		=> $p['id_city'],						
					'nama_provinsi'	=> $prov->nama_provinsi,						
					'nama_city'		=> $p['nama_city']
				);
			}
			$dataku = array(
				'err_msg' 	=> 'ok',
				'err_code' 	=> '00',
				'data' 		=> $dt	
			);
		}
		if (!empty($dataku)){
            $this->set_response($dataku, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'err_msg' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
        }
	}
	
	function area_get(){
		$dataku = array();	
		$_prov = $this->access->readtable('area','',array('deleted_at'=>null))->result_array();		
		if(!empty($_prov)){
			foreach($_prov as $p){
				
				$dt[] = array(
					'id_area'	=> $p['id_area'],						
					'nama_area'	=> $p['nama_area']
				);
			}
			$dataku = array(
				'err_msg' 	=> 'ok',
				'err_code' 	=> '00',
				'data' 		=> $dt	
			);
		}
		if (!empty($dataku)){
            $this->set_response($dataku, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'err_msg' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
        }
	}
	
	function brand_get(){
		$dataku = array();	
		$_prov = $this->access->readtable('brand','',array('deleted_at'=>null))->result_array();		
		if(!empty($_prov)){
			foreach($_prov as $p){
				
				$dt[] = array(
					'id_brand'		=> $p['id_brand'],						
					'nama_brand'	=> $p['nama_brand']
				);
			}
			$dataku = array(
				'err_msg' 	=> 'ok',
				'err_code' 	=> '00',
				'data' 		=> $dt	
			);
		}
		if (!empty($dataku)){
            $this->set_response($dataku, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'err_msg' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
        }
	}
	
	public function master_bank_get(){
		$_banner = '';
		$_banner = $this->access->readtable('master_bank','',array('deleted_at'=>null))->result_array();		
		$dt = array();
		$path = '';
		$dataku = array();		
		if(!empty($_banner)){
			foreach($_banner as $k){
				
				$dt[] = array(
					'id_bank'		=> $k['id_bank'],						
					'nama_bank'		=> $k['nama_bank'],
					'holder_name'	=> $k['holder_name'],
					'no_rek'		=> $k['no_rek']	
				);
			}
			$dataku = array(
				'err_msg' 	=> 'ok',
				'err_code' 	=> '00',
				'data' 		=> $dt	
			);
		}
				
		if (!empty($dataku)){
            $this->set_response($dataku, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'err_msg' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
        }
    }
    
    function disc_va_get(){
		$policy = $this->Api_m->get_key_val();
		$p = isset($policy['disc_va']) ? $policy['disc_va'] : '';
		$dataku = array();
		if(!empty($p)){
			$p = str_replace(",", "", $p);
			$p = str_replace(".", "", $p);			
			$dataku = array(
				'err_msg' 	=> 'ok',
				'err_code' 	=> '00',
				'data' 		=> $p	
			);
			$this->set_response($dataku, REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'data' 	=> $p,
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
		}
	}
	
	function disc_mt_get(){
		$policy = $this->Api_m->get_key_val();
		$p = isset($policy['disc_payment']) ? $policy['disc_payment'] : '';
		$dataku = array();
		if(!empty($p)){
			$p = str_replace(",", "", $p);
			$p = str_replace(".", "", $p);			
			$dataku = array(
				'err_msg' 	=> 'ok',
				'err_code' 	=> '00',
				'data' 		=> $p	
			);
			$this->set_response($dataku, REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'data' 	=> $p,
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
		}
	}
	
}

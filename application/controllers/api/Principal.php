<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Principal extends REST_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
		$this->load->model('Setting_m','sm', true);
		$this->load->library('converter');
		$this->load->library('send_api');
    }

    public function index_post (){
		$merchants = $this->access->readtable('merchants','',array('merchants.deleted_at'=>null))->result_array();
		$dt = array();		
		if(!empty($merchants)){
			foreach($merchants as $m){
				$dt[] = array(
					'id_pricipal'		=> $m['id_merchants'],
					'nama_principal'	=> $m['nama_merchants'],
					'email'				=> $m['email']
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
	
	public function products_post(){
		$param = $this->input->post();
		$keyword = isset($param['keyword']) ? $param['keyword'] : '';
		$id_whs = isset($param['id_whs']) ? (int)$param['id_whs'] : 0;
		$id_merchant = isset($param['id_principal']) ? (int)$param['id_principal'] : 0;
		$id_kategori = isset($param['id_kategori']) ? $param['id_kategori'] : '';
		$start_price = isset($param['start_price']) ? $param['start_price'] : '';
		$end_price = isset($param['end_price']) ? $param['end_price'] : '';
		$area = isset($param['area']) ? (int)$param['area'] : 0;
		$brand = isset($param['brand']) ? (int)$param['brand'] : 0;
		$sort = isset($param['sort']) ? (int)$param['sort'] : 0;
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$login = $this->access->readtable('members','',array('id_member'=>$id_member))->row();
		$id_tier = !empty($login) ? (int)$login->id_tier : 0;
		$_like = array();
		$or_like = array();
		$field_in = '';
		$where_in = array();
		$where = array('product.deleted_at'=>null);
		if(!empty($keyword)){
			$keyword = $this->db->escape_str($keyword);
			$_like = array('product.nama_barang'=>$keyword);
			$or_like = array('product.deskripsi'=>$keyword);
		}
		$_sort = '';
		if($sort == 1){
			$_sort = array('ABS(product.harga)','ASC');
		}
		if($sort == 2){
			$_sort = array('ABS(product.harga)','DESC');
		}
		if($sort == 3){
			$_sort = array('ABS(product.penjualan)','DESC');
		}
		if($id_merchant > 0){
			$where += array('product.id_merchant'=> $id_merchant);
		}
		if($area > 0){
			$where += array('product.id_area'=> $area);
		}
		if($brand > 0){
			$where += array('product.id_brand'=> $brand);
		}
		if(!empty($start_price)){
			$where += array('product.harga >= '=> (int)$start_price);
		}
		if(!empty($end_price)){
			$where += array('product.harga <= '=> (int)$end_price);
		}
		if(!empty($id_kategori)){			
			$field_in = 'product.id_kategori';
			$where_in = array($id_kategori);
		}
		$field_in2 = '';		
		$where_in2 = array();
		$select = array('product.*','merchants.nama_merchants','kategori.nama_kategori','brand.nama_brand','area.nama_area');
		$products = $this->access->readtable('product',$select,$where,array('merchants' => 'merchants.id_merchants = product.id_merchant','kategori' => 'kategori.id_kategori = product.id_kategori','brand' => 'brand.id_brand = product.id_brand','area' => 'area.id_area = product.id_area'),'',$_sort,'LEFT','',$_like,$or_like, $field_in,$where_in)->result_array();
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
		$diskon_product = 0;
		$diskon2 = array();
		$my_diskon = array();
		$list_diskon = $this->access->readtable('list_diskon',array('list_diskon.id_product','list_diskon.diskon'),array('list_diskon.deleted_at'=>null,'list_member_diskon.deleted_at'=>null,'list_member_diskon.id_member'=>$id_member),array('list_member_diskon'=> 'list_member_diskon.id_diskon = list_diskon.id_diskon'),'','','LEFT')->result_array();
		if(!empty($list_diskon)){
			foreach($list_diskon as $ld){
				array_push($my_diskon, $ld['id_product']);
				$diskon2[$ld['id_product']] = $ld['diskon'];
			}
		}
		if(!empty($products)){
			foreach($products as $m){
				$diskon_product = 0;
				$stok = 0;
				$diskon_product = (int)$m['diskon'] > 0 ? $m['diskon'] / 100 : 0;
				if (in_array($m['id_product'], $my_diskon)) $diskon_product = $diskon2[$m['id_product']] / 100;				
				$path = '';
				$hrg_diskon = 0;
				$harga = 0;
				$harga = $m['harga'];
				// if($id_tier > 0){
					$hrg_diskon = $harga - ($harga * $_diskon);
				// }	
				
				if($diskon_product > 0){
					$hrg_diskon = $hrg_diskon - ($diskon_product * $hrg_diskon);
				}		
				if($id_whs > 0){
					$_stok = '';
					$_stok = $this->access->readtable('stok','',array('id_product' => $m['id_product'],'id_wh'=>$id_whs,'deleted_at'=>null))->row();
					$stok = $_stok->stok;
				}
				$path = !empty($m['img']) ? base_url('uploads/products/'.$m['img']) : base_url('uploads/no_photo.jpg');
				$dt[] = array(
					'id_product'		=> $m['id_product'],
					'id_principal'		=> $m['id_merchant'],
					'id_kategori'		=> $m['id_kategori'],
					'id_brand'			=> $m['id_brand'],
					'id_area'			=> $m['id_area'],
					'nama_barang'		=> $m['nama_barang'],
					'harga'				=> $m['harga'],
					'hrg_diskon'		=> $hrg_diskon,
					'diskon'			=> $diskon,
					'diskon_produk'		=> $diskon_product * 100,
					'qty'				=> $stok,
					'paket'				=> 0,
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
	
	public function packet_post(){
		$param = $this->input->post();
		$date = date('Y-m-d');
		$keyword = isset($param['keyword']) ? $param['keyword'] : '';
		$id_whs = isset($param['id_whs']) ? (int)$param['id_whs'] : 0;
		$id_merchant = isset($param['id_principal']) ? (int)$param['id_principal'] : 0;
		$id_kategori = isset($param['id_kategori']) ? $param['id_kategori'] : '';
		$start_price = isset($param['start_price']) ? $param['start_price'] : '';
		$end_price = isset($param['end_price']) ? $param['end_price'] : '';
		$start_date = isset($param['start_date']) ? date('Y-m-d', strtotime($param['start_date'])) : $date;
		$end_date = isset($param['end_date']) ? date('Y-m-d', strtotime($param['end_date'])) : $date;
		$area = isset($param['area']) ? (int)$param['area'] : 0;
		$brand = isset($param['brand']) ? (int)$param['brand'] : 0;
		$sort = isset($param['sort']) ? (int)$param['sort'] : 0;
		$limit = isset($param['limit']) ? $param['limit'] : '';
		$id_tier = isset($param['id_tier']) ? (int)$param['id_tier'] : 0;
		$_like = array();
		$or_like = array();
		$where = array('product.deleted_at'=>null,'paket'=>1,'date_format(product.start_date, "%Y-%m-%d") <='=> $start_date, 'date_format(product.end_date, "%Y-%m-%d") >=' => $end_date);
		if(!empty($keyword)){
			$keyword = $this->db->escape_str($keyword);
			$_like = array('product.nama_barang'=>$keyword);
			$or_like = array('product.deskripsi'=>$keyword);
		}
		$_sort = '';
		if($sort == 1){
			$_sort = array('ABS(product.harga)','ASC');
		}
		if($sort == 2){
			$_sort = array('ABS(product.harga)','DESC');
		}
		if($sort == 3){
			$_sort = array('ABS(product.penjualan)','DESC');
		}
		if($id_merchant > 0){
			$where += array('product.id_merchant'=> $id_merchant);
		}
		if($area > 0){
			$where += array('product.id_area'=> $area);
		}
		if($brand > 0){
			$where += array('product.id_brand'=> $brand);
		}
		if(!empty($start_price)){
			$where += array('product.harga >= '=> (int)$start_price);
		}
		if(!empty($end_price)){
			$where += array('product.harga <= '=> (int)$end_price);
		}
		if(!empty($id_kategori)){			
			$field_in = 'product.id_kategori';
			$where_in = array($id_kategori);
		}
		$field_in2 = '';		
		$where_in2 = array();
		$select = array('product.*','merchants.nama_merchants','kategori.nama_kategori','brand.nama_brand','area.nama_area');
		$products = $this->access->readtable('product',$select,$where,array('merchants' => 'merchants.id_merchants = product.id_merchant','kategori' => 'kategori.id_kategori = product.id_kategori','brand' => 'brand.id_brand = product.id_brand','area' => 'area.id_area = product.id_area'),$limit,$_sort,'LEFT','',$_like,$or_like, $field_in,$where_in)->result_array();
		
		$tier = '';
		$diskon = 0;
		$_diskon = 0;
		if($id_tier > 0){
			$tier = $this->access->readtable('tier','',array('deleted_at'=>null,'id_tier'=>$id_tier))->row();
			$diskon = $tier->diskon > 0 ? $tier->diskon : 0;
			
		}
		$dt = array();		
		$path = '';
		if(!empty($products)){
			foreach($products as $m){
				$path = '';
				$hrg_diskon = 0;
				$stok = 0;
				$harga = 0;
				$harga = $m['harga'];
				$diskon = 0;
				$_diskon = 0;
				if($id_tier > 0 && (int)$m['pot_tier'] > 0){
					$diskon = $tier->diskon > 0 ? $tier->diskon : 0;
					$_diskon = $diskon > 0 ? $diskon / 100 : 0;
					$hrg_diskon = $harga - ($harga * $_diskon);
				}
				$path = !empty($m['img']) ? base_url('uploads/products/'.$m['img']) : base_url('uploads/no_photo.jpg');
				if($id_whs > 0){
					$_stok = '';
					$_stok = $this->access->readtable('stok','',array('id_product' => $m['id_product'],'id_wh'=>$id_whs,'deleted_at'=>null))->row();
					$stok = $_stok->stok;
				}
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
					'diskon_produk'		=> $m['diskon'],
					'qty'				=> $stok,
					'paket'				=> 1,
					'deskripsi'			=> $m['deskripsi'],
					'img'				=> $path,
					'nama_principal'	=> $m['nama_merchants'],
					'nama_kategori'		=> $m['nama_kategori'],
					'nama_brand'		=> $m['nama_brand'],
					'nama_area'			=> $m['nama_area']
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
	
	function product_detail_get($id_product=0, $id_member=0,$id_whs=0){
		$_like = array();
		$dt = array();
		$select = array('product.*','merchants.nama_merchants','merchants.photo','kategori.nama_kategori','brand.nama_brand','area.nama_area');
		$where = array('product.deleted_at'=>null,'product.id_product'=> $id_product);
		$products = $this->access->readtable('product',$select,$where,array('merchants' => 'merchants.id_merchants = product.id_merchant','kategori' => 'kategori.id_kategori = product.id_kategori','brand' => 'brand.id_brand = product.id_brand','area' => 'area.id_area = product.id_area'),'','','LEFT','',$_like)->row();
		
		$login = $this->access->readtable('members','',array('id_member'=>$id_member))->row();
		$id_tier = !empty($login) ? (int)$login->id_tier : 0;
		
		$list_diskon = $this->access->readtable('list_diskon',array('list_diskon.id_product','list_diskon.diskon'),array('list_diskon.deleted_at'=>null,'list_member_diskon.deleted_at'=>null,'list_member_diskon.id_member'=>$id_member,'list_diskon.id_product'=>$id_product),array('list_member_diskon'=> 'list_member_diskon.id_diskon = list_diskon.id_diskon'),'','','LEFT')->row();
		
		$tier = '';
		$diskon = 0;
		$_diskon = 0;
		$paket = 0;
		$list_product = null;
		$paket_detail = null;
		if(!empty($products)){
			$path = '';
			$photo = '';
			$hrg_diskon = 0;
			$harga = 0;
			$stok = 0;
			$harga = $products->harga;
			$paket = (int)$products->paket ;
			$diskon_product = 0;
			$diskon_product = (int)$products->diskon > 0 ? $products->diskon / 100 : 0;
			if(!empty($list_diskon)) $diskon_product = $list_diskon->diskon / 100;
			if($id_tier > 0 && (int)$products->pot_tier > 0){
				$tier = $this->access->readtable('tier','',array('deleted_at'=>null,'id_tier'=>$id_tier))->row();
				$diskon = $tier->diskon > 0 ? $tier->diskon : 0;
				$_diskon = $diskon > 0 ? $diskon / 100 : 0;						
			}
			$hrg_diskon = $harga - ($harga * $_diskon);		
			if($diskon_product > 0){
				$hrg_diskon = $hrg_diskon - ($diskon_product * $hrg_diskon);
			}
			if($id_whs > 0){
				$_stok = '';
				$_stok = $this->access->readtable('stok','',array('id_product' => $id_product,'id_wh'=>$id_whs,'deleted_at'=>null))->row();
				$stok = $_stok->stok;
			}
			if($paket > 0){
				$select = array();
				$where = array();
				$where = array('paket_detail.deleted_at'=>null,'paket_detail.id_paket'=> $id_product);
				$select = array('paket_detail.*','product.nama_barang','product.img','product.deskripsi','kategori.nama_kategori','brand.nama_brand','area.nama_area');
				$paket_detail = $this->access->readtable('paket_detail',$select,$where,array('product' => 'product.id_product = paket_detail.id_product','kategori' => 'kategori.id_kategori = product.id_kategori','brand' => 'brand.id_brand = product.id_brand','area' => 'area.id_area = product.id_area'),'','','LEFT')->result_array();
				if(!empty($paket_detail)){
					foreach($paket_detail as $m){
						$path = '';
						$path = !empty($m['img']) ? base_url('uploads/products/'.$m['img']) : base_url('uploads/no_photo.jpg');
						$list_product[] = array(
							'id_product'		=> $m['id_product'],
							
							'nama_barang'		=> $m['nama_barang'],
							'qty'				=> $m['qty'],
							'deskripsi'			=> $m['deskripsi'],
							'img'				=> $path
							
						);
					}
				}
			}
			$path = !empty($products->img) ? base_url('uploads/products/'.$products->img) : base_url('uploads/no_photo.jpg');
			$photo = !empty($products->photo) ? base_url('uploads/principle/'.$products->photo) : base_url('uploads/no_photo.jpg');
			$dt = array(
				'id_tier'		=> $id_tier,
				'id_product'		=> $products->id_product,
				'id_principal'		=> $products->id_merchant,
				'id_kategori'		=> $products->id_kategori,
				'id_brand'			=> $products->id_brand,
				'id_area'			=> $products->id_area,
				'nama_barang'		=> $products->nama_barang,
				'harga'				=> $products->harga,
				'harga'				=> $harga,
				'hrg_diskon'		=> $hrg_diskon,
				'diskon'			=> $diskon,
				'diskon_produk'		=> $diskon_product * 100,
				'qty'				=> $stok,
				'deskripsi'			=> $products->deskripsi,
				'img'				=> $path,
				'photo'				=> $photo,
				'nama_principal'	=> $products->nama_merchants,
				'nama_kategori'		=> $products->nama_kategori,
				'nama_brand'		=> $products->nama_brand,
				'nama_area'			=> $products->nama_area,
				'list_product'		=> $list_product
			);
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

}
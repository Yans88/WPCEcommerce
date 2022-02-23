<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Transaksi extends REST_Controller {

    function __construct(){
        parent::__construct();
		$this->load->library('send_notif');
		$this->load->library('send_api');
		$this->load->model('Setting_m','sm',true);
		$this->load->model('Access','access',true);
    }

   
	
	function send_transaksi_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		
		$tempo = isset($param['tempo']) ? (int)$param['tempo'] : 0;
		$ttl_tempo_fee = isset($param['tempo']) ? $param['tempo_fee'] : 0;
		$cash = isset($param['cash']) ? (int)$param['cash'] : 0;
		$alamat_kirim = isset($param['alamat_kirim']) ? (int)$param['alamat_kirim'] : 0;
		$list_item = isset($param['list_item']) ? json_decode($param['list_item']) : '';	
		$cash_type = isset($param['cash_type']) ? (int)$param['cash_type'] : 0;
		$bank_code = isset($param['bank_code']) ? strtoupper($param['bank_code']) : 0;
		$manual_transfer = isset($param['manual_transfer']) ? (int)$param['manual_transfer'] : 0;
		$id_bank = isset($param['id_bank']) ? (int)$param['id_bank'] : 0;
		$remark = isset($param['remark']) ? $param['remark'] : '';
		$kode_payment = '';
		$payment = '';
		$_tempo = '';
		$nama_bank = '';
		$holder_name = '';		
		$no_rek = '';		
		$master_bank = '';		
		$_status = 0;
		$tempo_name = 0;
		$_tgl = date('ymdHi');
		$tgl_now = date('Y-m-d H:i:s');
		$this->db->trans_begin();
		if($cash > 0){
			$kode_payment = $id_member.''.$_tgl;
			$payment = 1;
			$payment_name = 'Cash';
			$_status = 0;
		}
		if($tempo > 0){
			$_tempo = $this->access->readtable('master_payment','',array('deleted_at'=>null,'id_payment'=>$tempo))->row();	
			$payment = 2;
			$payment_name = 'Tempo';
			$tempo_type = $_tempo->type;
			$tempo_name = $_tempo->nama_payment;
			$_status = 0;
			if($tempo_type == 1){
				$ttl_tempo_fee = $_tempo->admin_fee > 0 ? $_tempo->admin_fee : 0;
			}
			if($tempo_type == 2){
				$ttl_tempo_fee = $_tempo->admin_fee > 0 ? $_tempo->admin_fee / 100: 0;
			}
		}
		$bank_name = array(
				'BMRI'	=> 'Bank Mandiri',
				'IBBK'	=> 'Bank International Indonesia Maybank',
				'BBBA'	=> 'Bank Permata',
				'CENA'	=> 'Bank Central Asia',
				'BNIN'	=> 'Bank Negara Indonesia 46',
				'HNBN'	=> 'Bank KEB Hana Indonesia',
				'BRIN'	=> 'Bank Rakyat Indonesia',
				'BNIA'	=> 'Bank PT. BANK CIMB NIAGA, TBK',
				'BDIN'	=> 'Bank PT. BANK DANAMON INDONESIA, TBK',
				'OTHR'	=> 'etc, unknown',
		);
		if($manual_transfer > 0){
			$payment = 3;
			$payment_name = 'Manual Transfer';
			$_status = 0;
			$master_bank = $this->access->readtable('master_bank','',array('master_bank.id_bank'=>$id_bank))->row();
			$nama_bank = !empty($master_bank->nama_bank) ? $master_bank->nama_bank : '';
			$holder_name = !empty($master_bank->holder_name) ? $master_bank->holder_name : '';
			$no_rek = !empty($master_bank->no_rek) ? $master_bank->no_rek : '';			
		}
		
		$_address = $this->access->readtable('alamat_pengiriman','',array('alamat_pengiriman.id_address'=>$alamat_kirim, 'alamat_pengiriman.deleted_at'=>null),array('members' => 'members.id_member = alamat_pengiriman.id_member','city' => 'city.id_city = alamat_pengiriman.id_city','provinsi' => 'provinsi.id_provinsi = alamat_pengiriman.id_provinsi','warehouse' => 'warehouse.id_whs = members.id_whs','sales' => 'sales.id_sales = members.sales_id'),'','','LEFT')->row();
		
		$sisa_credit = $_address->sisa_credit;
		$use_credit = $_address->use_credit;
		$login = $this->access->readtable('members','',array('id_member'=>$id_member))->row();
		$id_tier = !empty($login) ? (int)$login->id_tier : 0;
		$diskon = 0;
		$_diskon = 0;
		$tier = '';
		$id_whs = $_address->id_whs;
		$nama_whs = $_address->nama_whs;
		$ocrcode_p = $_address->whs_code;
		$ocrcode_c = $_address->ocrcode_c;
		$kd_cust = $_address->kd_cust;
		$id_sls = $_address->sales_id;
		$sales_id = $_address->slp_code;
		if($id_tier > 0){
			$tier = $this->access->readtable('tier','',array('deleted_at'=>null,'id_tier'=>$id_tier))->row();
			$diskon = $tier->diskon > 0 ? $tier->diskon : 0;
			$_diskon = $diskon > 0 ? $diskon / 100 : 0;
		}
		if((int)$id_whs <= 0){
			$this->set_response([
				'err_code'	=> '04',
				'err_msg' 	=> 'Produk tidak ditemukan, id_whs is null',
				'err_stok' 	=> '',
				'data'		=> ''
			], REST_Controller::HTTP_OK);
			return false;
		}
		//0=>Order, 1=>Payment Complete, 3=> Approve, 2=>Reject
		$status_name = array(
			'0' =>'Menungu Pembayaran', 
			'1' =>'Payment Complete/Pesanan diproses', 
			'2' =>'Reject',
			'3' =>'Approve', 
			'4' =>'Pesanan Dikirim',
			'5' =>'Sampai Tujuan',
			'6' =>'Selesai',
			'7' =>'Complain'
		);
		$simpan_dt = array(
			"kode_payment"		=> $kode_payment,
			"id_address"		=> $alamat_kirim,
			"id_member"			=> $id_member,				
			"kd_cust"			=> $kd_cust,				
			"id_sls"			=> $id_sls,				
			"sales_id"			=> $sales_id,
			"id_whs"			=> $id_whs,	
			"id_provinsi"		=> $_address->id_provinsi,							
			"id_city"			=> $_address->id_city,
			"nama_member"		=> $_address->nama,
			"email_member"		=> $_address->email,
			"phone_member"		=> $_address->phone,
			"payment"			=> $payment,
			"payment_name"		=> $payment_name,
			"cash_type"			=> $cash_type,
			"id_tempo"			=> $tempo,
			"ttl_tempo_fee"		=> $ttl_tempo_fee,
			"tempo"				=> count($_tempo) > 0 ? $_tempo->nama_payment : 0,
			"tempo_type"		=> count($_tempo) > 0 ? $_tempo->type : 0,   //1=>IDR, 2=>%
			"tempo_fee"			=> count($_tempo) > 0 ? $_tempo->admin_fee : 0,
			"nama_provinsi"		=> $_address->nama_provinsi,
			"nama_city"			=> $_address->nama_city,
			"kode_pos"			=> $_address->kode_pos,							
			"alamat_penerima"	=> $_address->alamat,														
			"phone_penerima"	=> $_address->phone,							
			"nama_penerima"		=> $_address->nama_penerima,											
			"nama_alamat"		=> $_address->nama_alamat,
			"status"			=> $_status,			
			"id_tier"			=> $id_tier,			
			"diskon"			=> $diskon,			
			"bank_code"			=> $bank_code,			
			"bank_name"			=> $bank_name[$bank_code],			
			"id_bank"			=> $id_bank,			
			"nama_bank"			=> $nama_bank,			
			"no_rek"			=> $no_rek,			
			"holder_name"		=> $holder_name,			
			"remark"			=> $remark,			
			"create_at"			=> $tgl_now
			
		);
		$id_product = '';	
		$products = '';	
		$path = '';
		$id_principal = '';
		$jml = 0;	
		$ttl = 0;	
		$ttl_all = 0;	
		$dt_stock = array();	
		$dt = array();
		$dt_nicepay = array();
		$_id_principal = array();
		$opsi_val_arr = $this->sm->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}
		$disc_tambahan = 0;
		if($manual_transfer > 0){
			$disc_tambahan = $out['disc_payment'] > 0 ? str_replace('.','',$out['disc_payment']) : 0;			
			$disc_tambahan = str_replace(',','',$disc_tambahan);			
		}
		if($cash_type == 2){
			$disc_tambahan = $out['disc_va'] > 0 ? str_replace('.','',$out['disc_va']) : 0;			
			$disc_tambahan = str_replace(',','',$disc_tambahan);			
		}
		$where_in = array();
		for($n = 0; $n < count($list_item); $n++){
			$id_productk = 0;
			$id_productk = (int)$list_item[$n]->id_product;
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
		for($i = 0; $i < count($list_item); $i++){
			$id_product = '';	
			$note = '';	
			$jml = 0 ;	
			$id_product = $list_item[$i]->id_product;	
			$jml = $list_item[$i]->jml;
			$note = $list_item[$i]->note;
			$products = '';
			if((int)$id_product > 0 && (int)$jml > 0){
				$select = array('product.*','merchants.nama_merchants','merchants.email','kategori.nama_kategori','brand.nama_brand','area.nama_area','brand.ocrcode_b','stok.stok');
				$products = $this->access->readtable('product',$select,array('product.deleted_at'=>null,'product.id_product'=> $id_product,'stok.id_product'=>$id_product,'stok.id_wh'=>$id_whs,'stok.deleted_at'=>null),array('merchants' => 'merchants.id_merchants = product.id_merchant','kategori' => 'kategori.id_kategori = product.id_kategori','brand' => 'brand.id_brand = product.id_brand','area' => 'area.id_area = product.id_area','stok' => 'stok.id_product = product.id_product'),'','','LEFT')->row();
				
				$path = '';				
				if(!empty($products)){
					$id_principal = '';
					$id_brand = '';
					$path = '';
					$total = 0;
					$hrg_diskon = 0;
					$harga = 0;
					$diskon_product = 0;
					$diskon_product = (int)$products->diskon > 0 ? $products->diskon / 100 : 0;
					if (in_array($id_product, $my_diskon)) $diskon_product = $diskon2[$id_product] / 100;	
					$pot_tier = (int)$products->pot_tier > 0 ? (int)$products->pot_tier : 0;
					$_diskon = $pot_tier * $_diskon;
					$harga = $products->harga;
					
					$hrg_diskon = $harga - ($harga * $_diskon);
					if($diskon_product > 0){
						$hrg_diskon = $hrg_diskon - ($diskon_product * $hrg_diskon);
					}
					$total = (int)$jml * $hrg_diskon;
					$ttl_all += $total;
					$path = !empty($products->img) ? base_url('uploads/products/'.$products->img) : base_url('uploads/no_photo.jpg');				
					$id_principal = $products->id_merchant;
					$id_brand = $products->id_brand;
					$princ_brand = '';
					$princ_brand = $id_principal.'_'.$id_brand;
					if(!in_array($princ_brand, $_id_principal)){
						array_push($_id_principal, $princ_brand);
					}
					$dt_nicepay[] = array(
						'img_url' 		=> $path,
						'goods_name' 	=> $products->nama_barang,
						'goods_detail' 	=> $products->deskripsi,
						'goods_detail' 	=> $products->deskripsi,
						'goods_amt' 	=> $products->harga
					);
					$dt[$princ_brand][] = array(
						'id_product'		=> $products->id_product,
						'id_principle'		=> $id_principal,
						'id_kategori'		=> $products->id_kategori,
						'id_brand'			=> $products->id_brand,
						'id_area'			=> $products->id_area,
						'nama_barang'		=> $products->nama_barang,
						'harga_asli'		=> $products->harga,
						'harga'				=> $hrg_diskon,
						'diskon'			=> $diskon,
						'diskon_product'	=> $diskon_product * 100,
						'stok'				=> $products->stok,
						'paket'				=> $products->paket,
						'jml'				=> $jml,
						'sisa_stok'			=> (int)$products->stok - (int)$jml,
						'total'				=> $total,
						'deskripsi'			=> $products->deskripsi,
						'img'				=> $path,
						'nama_principal'	=> $products->nama_merchants,
						'nama_kategori'		=> $products->nama_kategori,
						'nama_brand'		=> $products->nama_brand,
						'nama_area'			=> $products->nama_area,
						'note'				=> $note,
						'id_whs'			=> $id_whs,
						'id_sls'			=> $id_sls,
						'nama_whs'			=> $nama_whs,
						'ocrcode_p'			=> $ocrcode_p,
						'ocrcode_c'			=> $ocrcode_c,
						'sales_id'			=> $sales_id,
						'ocrcode_b'			=> $products->ocrcode_b
					);
					$_dt[$princ_brand] = array(
						'id_principle'		=> $id_principal,
						'id_brand'			=> $id_brand,
						'nama_principal'	=> $products->nama_merchants,
						'email_principle'	=> $products->email,						
						'product'			=> $dt[$princ_brand]
					);
					error_log($jml);
					error_log((int)$products->stok);
					if((int)$jml > (int)$products->stok){
						$dt_stock[] = array(
							'id_whs'			=> $id_whs,
							'id_sls'			=> $id_sls,
							'id_product'		=> $products->id_product,
							'id_principle'		=> $id_principal,
							'id_kategori'		=> $products->id_kategori,
							'id_brand'			=> $products->id_brand,
							'id_area'			=> $products->id_area,
							'nama_barang'		=> $products->nama_barang,
							'harga'				=> $products->harga,
							'stok'				=> $products->stok,
							'paket'				=> $products->paket,
							'jml'				=> $jml,
							'sisa_stok'			=> (int)$products->stok - (int)$jml,
							'total'				=> $total,
							'deskripsi'			=> $products->deskripsi,
							'img'				=> $path,
							'nama_principal'	=> $products->nama_merchants,
							'nama_kategori'		=> $products->nama_kategori,
							'nama_brand'		=> $products->nama_brand,
							'nama_area'			=> $products->nama_area,
							'note'				=> $note
						);
					}
				}				
			}			
		}
		
		$save = 0;
		$res = array();
		$ttl_cart = array();
		$_simpan_dt = array();
		$ttl_angs = 0;
		
		if(count($dt_stock) == 0){
			for($n=0;$n<count($_id_principal);$n++){		
				$_simpan_dt = array();
				$_simpan_dt = $simpan_dt;			
				$_ttl = 0;
				$k = 0;			
				foreach($dt[$_id_principal[$n]] as $val){
					$_ttl += $val['total'];
					
					$k++;				
				}
				// $disc = 0;
				// $disc = $_ttl * $disc_tambahan;
				$ttl_alls[$_id_principal[$n]] = 0;
				$ttl_cart[$_id_principal[$n]] = 0;
				$ans[$_id_principal[$n]] = 0;
				$_disc[$_id_principal[$n]] = 0;
				$ttl_cart[$_id_principal[$n]] = $k;
				$ttl_alls[$_id_principal[$n]] = ceil($_ttl - $disc_tambahan);
				$ttl_bfr_disc[$_id_principal[$n]] = $_ttl;
				$_disc[$_id_principal[$n]] = $disc_tambahan;
				if($tempo_name > 0){
					$angs[$_id_principal[$n]] = round($_ttl / $tempo_name);
				}
				
				$_simpan_dt +=array('ttl_disc_payment'=>$_disc[$_id_principal[$n]],'diskon_payment'=>$disc_tambahan,'ttl_cart' => $ttl_cart[$_id_principal[$n]],'ttl_all' => $ttl_alls[$_id_principal[$n]],'angs' => $angs[$_id_principal[$n]],'ttl_bfr_disc' => $ttl_bfr_disc[$_id_principal[$n]]);
				$_dt[$_id_principal[$n]]['ttl_cart'] = $ttl_cart[$_id_principal[$n]];
				$_dt[$_id_principal[$n]]['ttl_all'] = $ttl_alls[$_id_principal[$n]];
				$_dt[$_id_principal[$n]]['angs'] = $angs[$_id_principal[$n]];
				
				$res[] = $_dt[$_id_principal[$n]];
				unset($_dt[$_id_principal[$n]]['product']);
				
				$_simpan_dt +=$_dt[$_id_principal[$n]];
				$save = 0;
				$save = $this->access->inserttable('transaksi',$_simpan_dt);	
				error_log(PHP_EOL.''.$tgl_now.' '.$this->db->last_query(),3,'err');
				$_save = 0;
				if($save){
					foreach($dt[$_id_principal[$n]] as $key=>$val){
						$_id_product = '';
						$sisa_stok = '';
						$val += array('id_trans' => $save);	
						$this->access->inserttable('transaksi_detail', $val);
						error_log(PHP_EOL.''.$tgl_now.' '.$this->db->last_query(),3,'err');
						if($val['paket'] > 0){
							$this->simpan_paket($val);
						}
						$_id_product = $val['id_product'];
						$sisa_stok = $val['sisa_stok'];
						$this->access->updatetable('stok', array('stok' => $sisa_stok), array('id_product' => $_id_product,'id_wh'=>$id_whs));
						
						// $dt_product = '';
						// if($val['paket'] <= 0){
							// $dt_product = $this->access->readtable('product', '', array('id_product' => $_id_product))->row();
							// $simpan = array(			
								// 'nama_barang'		=> $dt_product->nama_barang,
								// 'id_kategori'		=> $dt_product->id_kategori,	
								// 'deskripsi'			=> $dt_product->deskripsi,	
								// 'harga'				=> $dt_product->harga,
								// 'paket'				=> $dt_product->paket,
								// 'qty'				=> $dt_product->qty,
								// 'diskon'			=> $dt_product->diskon,
								// 'id_area'			=> $dt_product->id_area,
								// 'id_brand'			=> $dt_product->id_brand,
								// 'id_merchant'		=> $dt_product->id_merchant
							// );
							// $simpan += array('id_product'=>$id_produk,'type'=>1,'ket'=>'Transaksi '.$save.', sebanyak : '.$val['jml']);
							// $this->access->inserttable('history_product', $simpan);
						// }
					}					
				}
			}
		}
		
		
		$ttl_all = ceil($ttl_all);
		$simpan_dt += array("status_name"=> $status_name[$status],'total' => $ttl_all,'ttl_angs' => $ttl_angs,'id_trans'=>$save, 'list_item'=>$res);
		if(count($dt_stock) > 0){
			$this->db->trans_rollback();
			$this->set_response([
				'err_code'	=> '06',
				'err_msg' 	=> 'Stok tidak cukup',
				'err_stok' 	=> $dt_stock,
				'data'		=> $simpan_dt
			], REST_Controller::HTTP_OK);
			return false;
		}
		
		$res_nicepay = null;
		$requestURL = '';
		$no_va = '';
		$valid_date = '';
		$valid_time = '';
		$tXid = '';
		// if($cash_type > 0 && $cash > 0){
			// $res_nicepay = $this->reg_nicepay($cash_type, $kode_payment, $ttl_all, $simpan_dt);
			// if($res_nicepay['result_code'] == '0000'){
				// $tXid = $res_nicepay['result_tXid'];
				// $reference_no = $res_nicepay['reference_no'];
				// if($cash_type == 1){
					// $requestURL = $res_nicepay['requestURL'];
					// $this->access->updatetable('transaksi',array('request_url'=>$requestURL,'tXid'=>$tXid), array("kode_payment"=>$kode_payment));
				// }
				// if($cash_type == 2){
					// $no_va = $res_nicepay['no_va'];					
					// $valid_date = $res_nicepay['valid_date'];
					// $valid_time = $res_nicepay['valid_time'];
					// $this->access->updatetable('transaksi',array('tXid'=>$tXid,'no_va'=>$no_va,'valid_date'=> date('Y-m-d', strtotime($valid_date)),'valid_time'=>date('H:i:s',strtotime($valid_time))), array("kode_payment"=>$kode_payment));
				// }
				// $this->db->trans_commit();
			// }else{
				// $this->db->trans_rollback();				
			// }
		// }
		
		// if($tempo > 0 || $manual_transfer > 0){
			// $this->db->trans_commit();
		// }
		$this->db->trans_commit();
		
		$this->set_response([
			'err_code' 		=> '00',
			'err_msg' 		=> 'Terima Kasih, Pesanan Anda Akan Kami Proses',
			'data'			=> $simpan_dt,
			'request_url'	=> $requestURL,
			'reference_no'	=> $reference_no,
			'tXid'			=> $tXid,
			'no_va'			=> $no_va,
			'valid_date'	=> $valid_date,
			'valid_time'	=> $valid_time,
			'res_nicepay'	=> $res_nicepay,
			
		], REST_Controller::HTTP_OK);
	}
	
	function simpan_paket($val = array()){
		$id_trans = $val['id_trans'];
		$id_product = $val['id_product'];
		
		$where = array('paket_detail.deleted_at'=>null,'paket_detail.id_paket'=> $id_product);
		$select = array('paket_detail.*','product.nama_barang','product.img','product.deskripsi');
		$products = $this->access->readtable('paket_detail',$select,$where,array('product' => 'product.id_product = paket_detail.id_product'),'','','LEFT')->result_array();
		// error_log($this->db->last_query());
		$simpan = array();
		$path = '';
		if(!empty($products)){
			foreach($products as $p){
				$path = !empty($p['img']) ? base_url('uploads/products/'.$p['img']) : base_url('uploads/no_photo.jpg');	
				$simpan = array(
					'id_trans'			=> $id_trans,
					'id_paket'			=> $id_product,
					'id_product'		=> $p['id_product'],			
					'nama_barang'		=> $p['nama_barang'],
					'img'				=> $path,			
					'jml'				=> $p['qty'],
					'deskripsi'			=> $p['deskripsi'],
					
				);
				$this->access->inserttable('transaksi_paket_detail', $simpan);
			}			 
		}
		
	}
	
	
	function reg_nicepay($payMethod= 0, $kode_payment=0, $ttl=0, $data=array()){
		$url = 'https://dev.nicepay.co.id/nicepay/direct/v2/registration';		
		$timeStamp = date('YmdHis');
		$date = new DateTime('+1 day');
		// $date->modify('+1 day');
		$iMid = 'IONPAYTEST';
		$mkey   = '33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==';
		$currency = 'IDR';
		$amt = $ttl;
		
		$referenceNo = $kode_payment;
		$merchantToken = hash('sha256', $timeStamp.$iMid.$referenceNo.$amt.$mkey);
		$goodsNm = 'GTS #'.$kode_payment;
		$billingNm = $data['nama_member'];
		$billingPhone = $data['phone_member'];
		$billingEmail = $data['email_member'];
		$billingAddr = $data['alamat_penerima'];
		$billingCity = $data['nama_city'];
		$billingState = $data['nama_provinsi'];
		$billingPostCd = $data['kode_pos'];
		$bankCd = $data['bank_code'];
		$billingCountry = 'Indonesia';
		$callBackUrl = base_url('nicepay_calldb');
		$dbProcessUrl = base_url('nicepay_calldb/db_process');
		$description = 'GTS Order #'.$kode_payment;
		$userIP = $_SERVER['REMOTE_ADDR'];
		$instmntType = 1;
		$instmntMon = 1;
		$cnt_item = count($data);
		$cartData = array(
			'count'	=> $cnt_item,
			'item'	=> $data,
		);
		$res_nicepay = '';
		$result = '';
		if($payMethod == 1){
			$url = 'https://www.nicepay.co.id/nicepay/api/orderRegist.do';
			$merchantToken = hash('sha256', $iMid.$referenceNo.$amt.$mkey);
			$post_data = array(
				"iMid" 				=> $iMid,
				"payMethod" 		=> '0'.$payMethod,
				"currency" 			=> $currency,
				"amt" 				=> $amt,
				"instmntType"		=> $instmntType,
				"instmntMon"		=> $instmntMon,
				"referenceNo"		=> $referenceNo,
				"goodsNm" 			=> $goodsNm,
				"billingNm" 		=> $billingNm,
				"billingPhone" 		=> $billingPhone,
				"billingEmail" 		=> $billingEmail,
				"billingAddr"		=> $billingAddr,
				"billingCity" 		=> $billingCity,
				"billingState" 		=> $billingState,
				"billingPostCd" 	=> $billingPostCd,
				"billingCountry" 	=> $billingCountry,
				"callBackUrl" 		=> $callBackUrl,
				"dbProcessUrl" 		=> $dbProcessUrl,
				"merchantToken" 	=> $merchantToken,
				"description"	 	=> $description,
				"userIP" 			=> $userIP,
				"cartData"			=>"{}"
			);
			
			$res_nicepay = $this->send_api->apiRequest($url,$post_data);
			$result = json_decode($res_nicepay);
			if(isset($result->data->resultCd) && $result->data->resultCd == "0000"){
			    $res_nicepay = array();
			    $res_nicepay = array(
			            'result_code'    	=> $result->data->resultCd,
			            'result_tXid'    	=> $result->data->tXid,
			            'result_message'    => $result->data->resultMsg,
			            'reference_no'    	=> $referenceNo,
			            'requestURL'    	=> $result->data->requestURL.'?tXid='.$result->tXid
			        );
              
            } elseif (isset($result->data->resultCd)) {
                $res_nicepay = array();
			    $res_nicepay = array(
			            'result_code'    	=> $result->data->resultCd,
			            'result_message'    => $result->data->resultMsg,
						'result_tXid'    	=> $result->data->tXid,
						'reference_no'    	=> $referenceNo
			        );
            }else{
                $res_nicepay = array();
                $res_nicepay = array(
			            'result_message'    => 'Connection Timeout. Please Try again.',
			        );
            }
		}
		if($payMethod == 2){
			$cartData = array();
			$post_data = array(				
				"timeStamp"			=> $timeStamp,
				"iMid" 				=> $iMid,
				"payMethod" 		=> '0'.$payMethod,
				"currency" 			=> $currency,
				"amt" 				=> $amt,				
				"referenceNo"		=> $referenceNo,
				"goodsNm" 			=> $goodsNm,
				"billingNm" 		=> $billingNm,
				"billingPhone" 		=> $billingPhone,
				"billingEmail" 		=> $billingEmail,
				"billingAddr"		=> $billingAddr,
				"billingCity" 		=> $billingCity,
				"billingState" 		=> $billingState,
				"billingPostCd" 	=> $billingPostCd,
				"billingCountry" 	=> $billingCountry,
				"deliveryNm"		=> $billingNm,
				"deliveryPhone"		=> $billingPhone,
				"deliveryAddr"		=> $billingAddr,
				"deliveryCity"		=> $billingCity,
				"deliveryState"		=> $billingState,
				"deliveryPostCd"	=> $billingPostCd,
				"deliveryCountry"	=> $billingCountry,
				"description"		=> $description,
				"dbProcessUrl"		=> $dbProcessUrl,
				"merchantToken"		=> $merchantToken,
				"reqDomain"			=> site_url(),
				"reqServerIP"		=> $userIP,
				"userIP"			=> $userIP,
				"userSessionID"		=> "697D6922C961070967D3BA1BA5699C2C",
				"userAgent"			=> $_SERVER['HTTP_USER_AGENT'],
				"userLanguage"		=> "ko-KR,en-US;q=0.8,ko;q=0.6,en;q=0.4",
				"cartData"			=> "{}",
				"bankCd"			=> $bankCd,
				"vacctValidDt"		=> $date->format('Ymd'),
				"vacctValidTm"		=> "235959",
				"merFixAcctId"		=> ""				
			);
			
			$res_nicepay = $this->send_api->send_data($url,$post_data);
			$result = json_decode($res_nicepay);
			
			if(isset($result->resultCd) && $result->resultCd == "0000"){
			    $res_nicepay = array();
			    $res_nicepay = array(
			            'result_code'    	=> $result->resultCd,
			            'result_message'    => $result->resultMsg,
						'reference_no'    	=> $result->referenceNo,
						'result_tXid'    	=> $result->tXid,
			            'no_va'   		 	=> $result->vacctNo,
			            'valid_date'	 	=> $result->vacctValidDt,
			            'valid_time'	 	=> $result->vacctValidTm,
			        );
              
            } elseif (isset($result->resultCd)) {
                $res_nicepay = array();
			    $res_nicepay = array(
			            'result_code'    	=> $result->resultCd,
			            'result_message'    => $result->resultMsg,
						'reference_no'    	=> $result->referenceNo,
						'result_tXid'    	=> $result->tXid
			        );
            }else{
                $res_nicepay = array();
                $res_nicepay = array(
			            'result_message'    => 'Connection Timeout. Please Try again.',
			        );
            }
		}
			
		
		return $res_nicepay;
		
		
	}
	
	function test_order_post(){
		$param = $this->input->post();
		
		$list_item = isset($param['list_item']) ? json_decode($param['list_item']) : '';	
		$where_in = array();
		for($n = 0; $n < count($list_item); $n++){
			$id_productk = 0;
			$id_productk = (int)$list_item[$n]->id_product;
			$where_in[] = "$id_productk";			
		}
		$field_in = 'list_diskon.id_product';
		$list_diskon = $this->access->readtable('list_diskon',array('list_diskon.id_product','list_diskon.diskon'),array('list_diskon.deleted_at'=>null,'list_member_diskon.deleted_at'=>null,'list_member_diskon.id_member'=>3509),array('list_member_diskon'=> 'list_member_diskon.id_diskon = list_diskon.id_diskon'),'','','LEFT','','','', $field_in,$where_in)->result_array();		
		$this->set_response([
			'err_code' 		=> '00',
			'err_msg' 		=> 'Terima Kasih, Pesanan Anda Akan Kami Proses',
			'data'			=> $this->db->last_query()
			
			
		], REST_Controller::HTTP_OK);
	}
	
	
	
	
}
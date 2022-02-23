<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);
		$this->load->model('Dashboard', 'dbd', true);
	}	
	
	public function index() {
		
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
				
		$this->data['judul_browser'] = 'Beranda';
		$this->data['judul_utama'] = 'Beranda';
		$this->data['judul_sub'] = 'GTS';
		$this->data['brand'] = $this->access->readtable('brand','',array('deleted_at'=>null))->result_array();
		$this->data['years'] = $this->access->readtable('members',array('date_format(members.tgl_reg, "%Y") as years'),'','','',array('years','DESC'),'','years')->result_array();
		
		$this->data['isi'] = $this->load->view('dashboard_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function load_monthly_sales(){	
		$satuan = isset($_POST['satuan']) ? $_POST['satuan'] : 'qty';
		$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
		$month = isset($_POST['month']) ? (int)$_POST['month'] : 0;
		$dt = $this->dbd->monthly_sales($satuan,$year,$month);	
		$i = 1;
		$_ac = array();	
		if(!empty($dt)){
			foreach($dt as $d){
				$_ac[] = array('y'=>$d['nama_brand'], 'a'=> $d['cnt']);	
			}
		}		
		if(count($_ac) <= 0){
			$_ac[] = array('y'=>'', 'a'=>0);
		}		
		echo json_encode($_ac);
	}
	
	function load_top_shop_sales(){	
		$brand = isset($_POST['brand']) && $_POST['brand'] > 0 ? (int)$_POST['brand'] : 0;
		$satuan = isset($_POST['satuan']) ? $_POST['satuan'] : 'qty';
		$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
		$month = isset($_POST['month']) ? (int)$_POST['month'] : 0;
		$dt = $this->dbd->top_shop_sales($brand,$satuan,$year,$month);	
		$i = 1;
		$_ac = array();	
		if(!empty($dt)){
			foreach($dt as $d){
				$nama = str_replace(' ','\n',$d['nama']);
				$_ac[] = array('y'=>$d['nama'], 'a'=> $d['cnt']);				
			}
		}		
		if(count($_ac) <= 0){
			$_ac[] = array('y'=>'', 'a'=>0);
		}		
		echo json_encode($_ac);
	}
	
	function load_top_shop_sales_w(){	
		$brand = isset($_POST['brand']) && $_POST['brand'] > 0 ? (int)$_POST['brand'] : 0;
		$month = isset($_POST['month']) && $_POST['month'] > 0 ? (int)$_POST['month'] : 0;
		$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
		$satuan = isset($_POST['satuan']) ? $_POST['satuan'] : 'qty';
		$dt = $this->dbd->top_shop_sales_w($brand,$month,$satuan,$year);	
		$i = 1;
		$_ac = array();	
		if(!empty($dt)){
			foreach($dt as $d){
				if(!empty($d['nama'])){
					$nama = str_replace(' ','\n',$d['nama']);
					$_ac[] = array('y'=>$d['nama'], 'a'=> $d['cnt']);
				}				
			}
		}		
		if(count($_ac) <= 0){
			$_ac[] = array('y'=>'', 'a'=>0);
		}		
		echo json_encode($_ac);
	}
	
	function load_top_shop_sales_sku(){	
		$brand = isset($_POST['brand']) && $_POST['brand'] > 0 ? (int)$_POST['brand'] : 0;	
		$satuan = isset($_POST['satuan']) ? $_POST['satuan'] : 'qty';
		$month = isset($_POST['month']) && $_POST['month'] > 0 ? (int)$_POST['month'] : 0;
		$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
		$dt = $this->dbd->top_shop_sales_sku($brand,$satuan,$year,$month);	
		$i = 1;
		$_ac = array();	
		if(!empty($dt)){
			foreach($dt as $d){
				error_log($d['cnt']);
				if(!empty($d['nama'])){
					$nama = str_replace(' ','\n',$d['nama']);
					$_ac[] = array('y'=>$d['nama'], 'a'=> $d['cnt']);
				}				
			}
		}		
		if(count($_ac) <= 0){
			$_ac[] = array('y'=>'', 'a'=>0);
		}		
		echo json_encode($_ac);
	}
	
	function load_stock_value(){	
		$brand = isset($_POST['brand']) && $_POST['brand'] > 0 ? (int)$_POST['brand'] : 0;
		$satuan = isset($_POST['satuan']) ? $_POST['satuan'] : 'qty';
		$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
		$month = isset($_POST['month']) ? (int)$_POST['month'] : 0;
		$dt = $this->dbd->whs_stock($brand, $satuan);	
		$i = 1;
		$_ac = array();	
		if(!empty($dt)){
			foreach($dt as $d){
				$nama = str_replace(' ','\n',$d['nama']);
				$_ac[] = array('y'=>$d['nama'], 'a'=>$d['cnt']);				
			}
		}		
		if(count($_ac) <= 0){
			$_ac[] = array('y'=>'', 'a'=>0);
		}		
		echo json_encode($_ac);
	}
	
	function load_top_stock(){	
		$brand = isset($_POST['brand']) && $_POST['brand'] > 0 ? (int)$_POST['brand'] : 0;
		$dt = $this->dbd->top_stock($brand);	
		$i = 1;
		$_ac = array();	
		if(!empty($dt)){
			foreach($dt as $d){
				$nama = str_replace(' ','\n',$d['nama']);
				$_ac[] = array('y'=>$d['nama'], 'a'=>(int)$d['cnt']);				
			}
		}		
		if(count($_ac) <= 0){
			$_ac[] = array('y'=>'', 'a'=>0);
		}		
		echo json_encode($_ac);
	}
	
	function load_top_shop_salesman(){	
		$brand = isset($_POST['brand']) && $_POST['brand'] > 0 ? (int)$_POST['brand'] : 0;
		$satuan = isset($_POST['satuan']) ? $_POST['satuan'] : 'qty';
		$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
		$month = isset($_POST['month']) ? (int)$_POST['month'] : 0;
		$dt = $this->dbd->top_shop_salesman($brand,$satuan,$year,$month);	
		$i = 1;
		$_ac = array();	
		if(!empty($dt)){
			foreach($dt as $d){
				$nama = str_replace(' ','\n',$d['nama']);
				if(!empty($d['nama']) || $d['nama'] != '') $_ac[] = array('y'=>$d['nama'], 'a'=>$d['cnt']);			
			}
		}		
		if(count($_ac) <= 0){
			$_ac[] = array('y'=>'', 'a'=>0);
		}		
		echo json_encode($_ac);
	}
	
	function load_complete_reject(){	
		$satuan = isset($_POST['satuan']) ? $_POST['satuan'] : 'qty';
		$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
		$month = isset($_POST['month']) ? (int)$_POST['month'] : 0;
		$dt = $this->dbd->count_complete_reject($satuan,$year,$month);
		echo json_encode($dt);
	}

	function load_daily_sales(){	
		$brand = isset($_POST['brand']) && $_POST['brand'] > 0 ? (int)$_POST['brand'] : 0;
		$satuan = isset($_POST['satuan']) ? $_POST['satuan'] : 'qty';
		$dt = $this->dbd->daily_sales($brand,$satuan);	
		$i = 1;
		$_ac = array();	
		if(!empty($dt)){
			foreach($dt as $d){
				$_ac[] = array('y'=>$d['nama_brand'], 'a'=>$d['cnt']);				
			}
		}		
		if(count($_ac) <= 0){
			$_ac[] = array('y'=>'', 'a'=>0);
		}		
		echo json_encode($_ac);
	}
	
	function load_new_outlets(){		
		// error_log($_POST['year']);
		$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
		$dt = $this->dbd->new_outlets($year);	
		$i = 1;
		$_ac = array();	
		$res = array();	
		$month = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Des');
		if(!empty($dt)){
			foreach($dt as $d){
				$res[$d['month']] = (int)$d['cnt'];
				// $_ac[] = array('y'=>$d['nama_brand'], 'a'=>(int)$d['cnt']);				
			}
		}
		foreach ($month as $m){
			$_ac[] = array('y'=>$m, 'a'=>(int)$res[$m]);	
		} 
		if(count($_ac) <= 0){
			$_ac[] = array('y'=>'', 'a'=>0);
		}		
		echo json_encode($_ac);
	}
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}


}

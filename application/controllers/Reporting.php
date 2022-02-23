<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporting extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);	
	}	
	
	public function index() {
		
		if(!$this->session->userdata('login') || !$this->session->userdata('reporting')){
			$this->no_akses();
			return false;
		}
		$date_now = date('d-m-Y');
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : $date_now;
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : $date_now;
		$this->data['froms'] = $from;
		$this->data['to'] = $to;
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi Approved';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'List of Transaksi';
		$this->data['status'] = 'payment';
		// $this->data['payment'] = 0;
		$where = array();
		$where = array('transaksi.status'=>3);
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('date_format(transaksi.create_at, "%Y-%m-%d") >= ' => date('Y-m-d', strtotime($from)), 'date_format(transaksi.create_at, "%Y-%m-%d") <=' => date('Y-m-d', strtotime($to)));
		}
		$sort = array('transaksi.id_transaksi','DESC');
		$this->data['transaksi'] = $this->access->readtable('transaksi', '', $where,'','',$sort)->result_array();
		
		$this->data['url_report'] = site_url('reporting');
		
		$this->data['isi'] = $this->load->view('transaksi/transaksi_vv', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}		
	
	function detail($id_transaksi=''){
		$id_transaksi = (int)$this->converter->decode($id_transaksi);
		$this->data['transaksi'] = $this->access->readtable('transaksi','', array('transaksi.id_transaksi' => $id_transaksi))->row();
		$this->data['transaksi_detail'] = $this->access->readtable('transaksi_detail','',array('id_trans'=>$id_transaksi))->result_array();
		$this->data['paket_detail'] = $this->access->readtable('transaksi_paket_detail','',array('id_trans'=>$id_transaksi))->result_array();
		$this->data['tagihan'] = $this->access->readtable('tagihan','',array('id_transaksi'=>$id_transaksi))->result_array();
		$this->data['judul_browser'] = 'Transaksi detail';
		$this->data['judul_utama'] = 'Transaksi detail';
		$this->data['judul_sub'] = 'GTS';
		$this->data['title_box'] = 'Transaksi detail';
		$this->data['isi'] = $this->load->view('transaksi/transaksi_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function export_r(){
		$tgl = date('dmY');
		$this->load->library('excel');
		$from = isset($_REQUEST['froms']) ? $_REQUEST['froms'] : '';
		$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : '';
		$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
		$payment = isset($_REQUEST['payment']) ? (int)$_REQUEST['payment'] : 0;
		$where = array();
		$status_name = '';
		$dates = '';
		// if($payment > 0){
			// $where = array('transaksi.payment'=>$payment);		
		// }
		// if($status > 0 || $status == 'payment'){
			// if($status == 'payment'){
				// $status = 0;
			// }
			// $where = array('transaksi.status'=>$status);		
		// }
		$where = array('transaksi.status'=>3);
		$id_merchant = $this->session->userdata('id_merchant') > 0 ? $this->session->userdata('id_merchant') : 0;
		$_level = $this->session->userdata('level');		
		if($_level == 2){
			$where += array('transaksi.id_principle' => $id_merchant);
		}
		if(!empty($from) && !empty($to)){
			$where += array('date_format(transaksi.create_at, "%Y-%m-%d") >= ' => date('Y-m-d', strtotime($from)), 'date_format(transaksi.create_at, "%Y-%m-%d") <=' => date('Y-m-d', strtotime($to)));
		}
		$selects = array('transaksi.*','transaksi_detail.*','product.deskripsi','members.ocrcode_p');
		$transaksi = $this->access->readtable('transaksi_detail', '', $where,array('transaksi' => 'transaksi.id_transaksi = transaksi_detail.id_trans'),'','','LEFT')->result_array();
		error_log($this->db->last_query());
	
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		// $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(45);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(45);
		// $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(45);				
		
		
		$this->excel->getActiveSheet()->getStyle('A1:S1')->getFont()->setSize(12);				
		
		
		$this->excel->getActiveSheet()->setCellValue('A1', 'Principal');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Cabang');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Invoice No.');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Invoice Date');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Sales Code');
		
        $this->excel->getActiveSheet()->setCellValue('F1', 'Customer Code');	
        $this->excel->getActiveSheet()->setCellValue('G1', 'Customer Name');	
        $this->excel->getActiveSheet()->setCellValue('H1', 'Alamat');	
        $this->excel->getActiveSheet()->setCellValue('I1', 'Provinsi');	
        $this->excel->getActiveSheet()->setCellValue('J1', 'Item Code');	
        $this->excel->getActiveSheet()->setCellValue('K1', 'Description');	
        $this->excel->getActiveSheet()->setCellValue('L1', 'Type');	
        $this->excel->getActiveSheet()->setCellValue('M1', 'Brand');	
        	
        $this->excel->getActiveSheet()->setCellValue('N1', 'Quantity');	
        $this->excel->getActiveSheet()->setCellValue('O1', 'Pricelist Price');	
        $this->excel->getActiveSheet()->setCellValue('P1', 'Final Price');	
        $this->excel->getActiveSheet()->setCellValue('Q1', 'Remark Invoice');	
		
		$i=2;
		$no = 1;
		$_id_trans = '';
		$address = '';
		$_ttl = 0;
		
		if(!empty($transaksi)){
			foreach($transaksi as $t){	
				$_ttl += $t['total'];			
				$this->excel->getActiveSheet()->setCellValue('A'.$i, $t['nama_principal']);
				$this->excel->getActiveSheet()->setCellValue('B'.$i,$t['ocrcode_p']);
				$this->excel->getActiveSheet()->setCellValue('C'.$i,$t['id_transaksi']);
				$this->excel->getActiveSheet()->setCellValue('D'.$i, date("d/m/Y", strtotime($t['create_at'])));
				$this->excel->getActiveSheet()->setCellValue('E'.$i, $t['sales_id']);
				// $this->excel->getActiveSheet()->setCellValue('F'.$i, '');		
				$this->excel->getActiveSheet()->setCellValue('F'.$i, $t['kd_cust']);
				$this->excel->getActiveSheet()->setCellValue('G'.$i, $t['nama_member']);								
				$this->excel->getActiveSheet()->setCellValue('H'.$i, $t['alamat_penerima']);								
				$this->excel->getActiveSheet()->setCellValue('I'.$i, $t['nama_provinsi']);								
				$this->excel->getActiveSheet()->setCellValue('J'.$i, $t['nama_barang']);								
				$this->excel->getActiveSheet()->setCellValue('K'.$i, $t['deskripsi']);								
				$this->excel->getActiveSheet()->setCellValue('L'.$i, $t['nama_kategori']);								
				$this->excel->getActiveSheet()->setCellValue('M'.$i, $t['nama_brand']);								
				// $this->excel->getActiveSheet()->setCellValue('O'.$i, '');								
				$this->excel->getActiveSheet()->setCellValue('N'.$i, $t['jml']);								
				$this->excel->getActiveSheet()->setCellValue('O'.$i, $t['harga_asli']);	 							
				$this->excel->getActiveSheet()->setCellValue('P'.$i, $t['total']);								
				$this->excel->getActiveSheet()->setCellValue('Q'.$i, $t['remark']);								
				
				$this->excel->getActiveSheet()->getStyle('A'.$i.':Q'.$i)->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('A'.$i.':Q'.$i)->getAlignment()->setWrapText(true);
				// $this->excel->getActiveSheet()->getStyle('A'.$i.':S'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				$this->excel->getActiveSheet()->getStyle('A'.$i.':Q'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);	
				$this->excel->getActiveSheet()->getStyle('N'.$i.':P'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				// $this->excel->getActiveSheet()->getStyle('P'.$i)->getNumberFormat()->setFormatCode('0,000.00');						
				$this->excel->getActiveSheet()->getStyle('O'.$i.':P'.$i)->getNumberFormat()->setFormatCode('0,000.00');						
				$this->excel->getActiveSheet()->getStyle('A'.$i.':S'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$i++;
			}
			$this->excel->getActiveSheet()->setCellValue('P'.$i, $_ttl);
			$this->excel->getActiveSheet()->getStyle('P'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$this->excel->getActiveSheet()->getStyle('P'.$i)->getNumberFormat()->setFormatCode('0,000.00');
			unset($styleArray);	
		}
		
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$this->session->set_userdata(array('reports' =>$id_trans));
		$this->session->set_userdata(array('reports_no' =>$_no));
		$filename ='sales_report_'.$tgl.'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0'); 					 
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  		
		$objWriter->save('php://output');
		
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

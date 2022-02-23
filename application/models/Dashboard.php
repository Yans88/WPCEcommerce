<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();	
    }
    
	
	function monthly_sales($satuan='qty',$year='',$month=''){
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status >= 3 and transaksi.status < 7';
		$dt = date_create_from_format('m-Y', $month.'-'.$year);
		$month = $dt->format('M-Y');		
		$_sql .=' And date_format(transaksi.create_at, "%b-%Y") = "'.$month.'"';
		$sql = 'SELECT round(sum(transaksi_detail.jml),2) as cnt, brand.nama_brand FROM transaksi_detail LEFT JOIN brand on brand.id_brand = transaksi_detail.id_brand WHERE id_trans in ('.$_sql.')';		
		if($satuan == 'idr') $sql = 'SELECT round(sum(transaksi_detail.total),2) as cnt, brand.nama_brand FROM transaksi_detail LEFT JOIN brand on brand.id_brand = transaksi_detail.id_brand WHERE id_trans in ('.$_sql.')';				
		$sql .=' GROUP by transaksi_detail.id_brand order by ABS(transaksi_detail.id_brand) ASC';		
		// error_log('mothly_sales : '.$month);
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function top_shop_sales($brand=0,$satuan='qty',$year='',$month=''){
		$dt = date_create_from_format('m-Y', $month.'-'.$year);
		$month = $dt->format('M-Y');
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status >= 3 and transaksi.status < 7';
		$_sql .=' And date_format(transaksi.create_at, "%b-%Y") = "'.$month.'"';
		if($brand > 0) $_sql .= ' AND transaksi.id_brand = '.$brand;
		$sql = 'SELECT round(sum(transaksi_detail.jml),2) as cnt, members.nama FROM transaksi_detail LEFT JOIN transaksi on transaksi.id_transaksi = transaksi_detail.id_trans LEFT JOIN members on members.id_member = transaksi.id_member WHERE id_trans in ('.$_sql.')';	
		if($satuan == 'idr') $sql = 'SELECT round(sum(transaksi_detail.total),2) as cnt, members.nama FROM transaksi_detail LEFT JOIN transaksi on transaksi.id_transaksi = transaksi_detail.id_trans LEFT JOIN members on members.id_member = transaksi.id_member WHERE id_trans in ('.$_sql.')';	
		$sql .=' GROUP by transaksi.id_member order by cnt DESC limit 10';
		// error_log('top_shop_sales : '.$sql);
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function top_shop_sales_w($brand=0,$month=0, $satuan='qty',$year=0){
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status >= 3 and transaksi.status < 7';
		if($brand > 0) $_sql .= ' AND transaksi.id_brand = '.$brand;
		if($month > 0) $_sql .= ' AND date_format(transaksi.create_at, "%c") = '.$month;	
		if($year > 0) $_sql .= ' AND date_format(transaksi.create_at, "%Y") = '.$year;	
		$sql = 'SELECT round(sum(transaksi_detail.jml),2) as cnt, warehouse.nama_whs as nama FROM transaksi_detail LEFT JOIN warehouse on warehouse.id_whs = transaksi_detail.id_whs WHERE id_trans in ('.$_sql.')';	
		if($satuan == 'idr') $sql = 'SELECT round(round(sum(transaksi_detail.total),2),2) as cnt, warehouse.nama_whs as nama FROM transaksi_detail LEFT JOIN warehouse on warehouse.id_whs = transaksi_detail.id_whs WHERE id_trans in ('.$_sql.')';	
		$sql .=' GROUP by transaksi_detail.id_whs order by cnt DESC limit 10';	
		//error_log('top_shop_sales_w : '.$sql);
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function top_shop_sales_sku($brand=0,$satuan='qty',$year='',$month=''){	
		$dt = date_create_from_format('m-Y', $month.'-'.$year);
		$month = $dt->format('M-Y');
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status >= 3 and transaksi.status < 7';		
		$_sql .=' And date_format(transaksi.create_at, "%b-%Y") = "'.$month.'"';
		if($brand > 0) $_sql .= ' AND transaksi.id_brand = '.$brand;
		$sql = 'SELECT round(sum(transaksi_detail.jml),2) as cnt, product.nama_barang as nama FROM transaksi_detail LEFT JOIN product on product.id_product = transaksi_detail.id_product WHERE id_trans in ('.$_sql.')';
		if($satuan == 'idr') $sql = 'SELECT round(sum(transaksi_detail.total),2) as cnt, product.nama_barang as nama FROM transaksi_detail LEFT JOIN product on product.id_product = transaksi_detail.id_product WHERE id_trans in ('.$_sql.')';
		$sql .=' GROUP by transaksi_detail.id_product order by cnt DESC limit 10';	
		// error_log('top_shop_sales_sku : '.$_sql);
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function whs_stock($brand=0, $satuan='qty'){		
		$sql = 'SELECT sum(stok.stok) as cnt, warehouse.nama_whs as nama FROM stok LEFT JOIN warehouse on warehouse.id_whs = stok.id_wh LEFT JOIN product on product.id_product = stok.id_product LEFT JOIN brand on brand.id_brand = product.id_brand WHERE stok.deleted_at is null';
		if($brand > 0) $sql .= ' AND product.id_brand = '.$brand;
		$sql .=' GROUP by stok.id_wh order by cnt DESC';		
		//error_log($sql);
		//error_log('whs_stock : '.$sql);
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function top_stock($brand=0){		
		$sql = 'SELECT sum(stok.stok) as cnt, product.nama_barang as nama FROM stok LEFT JOIN product on product.id_product = stok.id_product WHERE stok.deleted_at is null';
		if($brand > 0) $sql .= ' AND product.id_brand = '.$brand;
		$sql .=' GROUP by stok.id_product order by cnt DESC limit 10';		
		//error_log('top_stock : '.$sql);
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function top_shop_salesman($brand=0, $satuan='qty',$year=0,$month=0){
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status >= 3 and transaksi.status < 7';		
		if($brand > 0) $_sql .= ' AND transaksi.id_brand = '.$brand;
		if($month > 0) $_sql .= ' AND date_format(transaksi.create_at, "%c") = '.$month;	
		if($year > 0) $_sql .= ' AND date_format(transaksi.create_at, "%Y") = '.$year;	
		$sql = 'SELECT round(sum(transaksi_detail.jml),2) as cnt, sales.nama_sales as nama FROM transaksi_detail LEFT JOIN sales on sales.id_sales = transaksi_detail.id_sls WHERE id_trans in ('.$_sql.')';	
		if($satuan == 'idr') $sql = 'SELECT round(sum(transaksi_detail.total),2) as cnt, sales.nama_sales as nama FROM transaksi_detail LEFT JOIN sales on sales.id_sales = transaksi_detail.id_sls WHERE id_trans in ('.$_sql.')';		
		$sql .=' GROUP by transaksi_detail.id_sls order by cnt DESC limit 10';	
		//error_log('top_shop_salesman : '.$sql);		
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function count_complete_reject($satuan='qty',$year=0,$month=0){
		$res = array();
		$sql = '';
		if($satuan == 'idr'){
			$sql = 'select sum(transaksi.ttl_all) as cnt FROM transaksi WHERE transaksi.status >= 3 and transaksi.status < 7';
		}else{
			$sql = 'select COUNT(transaksi.id_transaksi) as cnt FROM transaksi WHERE transaksi.status >= 3 and transaksi.status < 7';
		}
		if($month > 0) $sql .= ' AND date_format(transaksi.create_at, "%c") = '.$month;	
		if($year > 0) $sql .= ' AND date_format(transaksi.create_at, "%Y") = '.$year;	
		$dt = $this->db->query($sql)->row();
		// error_log('complete : '.$sql);
		$res = array('complete' => $dt->cnt);
		$sql = '';
		if($satuan == 'idr'){
			$sql = 'select sum(transaksi.ttl_all) as cnt FROM transaksi WHERE transaksi.status = 2';
		}else{
			$sql = 'select COUNT(transaksi.id_transaksi) as cnt FROM transaksi WHERE transaksi.status = 2';
		}
		if($month > 0) $sql .= ' AND date_format(transaksi.create_at, "%c") = '.$month;	
		if($year > 0) $sql .= ' AND date_format(transaksi.create_at, "%Y") = '.$year;	
		$dt = $this->db->query($sql)->row();
		// error_log('reject : '.$sql);
		$res += array('reject' => $dt->cnt);
		return $res;
	}
	
	function daily_sales($brand=0,$satuan='qty'){
		$month = date('d-m-Y');	
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status >= 3 and transaksi.status < 7';
		$_sql .=' And date_format(transaksi.create_at, "%d-%m-%Y") = "'.$month.'"';
		if($brand > 0) $_sql .= ' AND transaksi.id_brand = '.$brand;		
		$sql = 'SELECT round(sum(transaksi_detail.jml),2) as cnt, brand.nama_brand FROM transaksi_detail LEFT JOIN brand on brand.id_brand = transaksi_detail.id_brand WHERE id_trans in ('.$_sql.')';	
		if($satuan == 'idr') $sql = 'SELECT round(sum(transaksi_detail.total),2) as cnt, brand.nama_brand FROM transaksi_detail LEFT JOIN brand on brand.id_brand = transaksi_detail.id_brand WHERE id_trans in ('.$_sql.')';
		$sql .=' GROUP by transaksi_detail.id_brand order by ABS(transaksi_detail.id_brand) ASC';	
//error_log('daily_sales : '.$sql);		
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function new_outlets($year=''){		
		$sql = 'SELECT COUNT(members.id_member) as cnt,date_format(members.tgl_reg, "%b") as month, date_format(members.tgl_reg, "%Y") as year FROM members WHERE members.status = 4';				
		$sql .=' And date_format(members.tgl_reg, "%Y") = "'.$year.'"';
		$sql .=' GROUP by month';	
		//error_log('new_outlets : '.$sql);
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	//SELECT COUNT(members.id_member) as cnt,date_format(members.tgl_reg, "%b") as month, date_format(members.tgl_reg, "%Y") as year FROM members WHERE members.status = 4 And date_format(members.tgl_reg, "%Y") = "2020" GROUP by month
	//https://afrijaldzuhri.com/mengatasi-error-group-by-di-mysql/
	//https://dba.stackexchange.com/questions/237048/1055-expression-1-of-select-list-is-not-in-group-by-clause-and-contains-nonag
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();	
    }
    
	
	function monthly_sales(){
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status = 6';
		$month = date('M-Y');		
		$_sql .=' And date_format(transaksi.create_at, "%b-%Y") = "'.$month.'"';
		$sql = 'SELECT sum(transaksi_detail.jml) as cnt, brand.nama_brand FROM transaksi_detail LEFT JOIN brand on brand.id_brand = transaksi_detail.id_brand WHERE id_trans in ('.$_sql.')';		
		$sql .=' GROUP by transaksi_detail.id_brand order by ABS(transaksi_detail.id_brand) ASC';	
		
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function top_shop_sales($brand=0){
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status = 6';
		if($brand > 0) $_sql .= ' AND transaksi.id_brand = '.$brand;
		$sql = 'SELECT sum(transaksi_detail.jml) as cnt, members.nama FROM transaksi_detail LEFT JOIN transaksi on transaksi.id_transaksi = transaksi_detail.id_trans LEFT JOIN members on members.id_member = transaksi.id_member WHERE id_trans in ('.$_sql.')';		
		$sql .=' GROUP by transaksi.id_member order by cnt DESC limit 10';		
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function top_shop_sales_w($brand=0,$month=0){
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status = 6';
		if($brand > 0) $_sql .= ' AND transaksi.id_brand = '.$brand;
		if($month > 0) $_sql .= ' AND date_format(transaksi.create_at, "%c") = '.$month;	
		$sql = 'SELECT sum(transaksi_detail.jml) as cnt, warehouse.nama_whs as nama FROM transaksi_detail LEFT JOIN warehouse on warehouse.id_whs = transaksi_detail.id_whs WHERE id_trans in ('.$_sql.')';	
		$sql .=' GROUP by transaksi_detail.id_whs order by cnt DESC limit 10';		
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function top_shop_sales_sku($brand=0){
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status = 6';		
		if($brand > 0) $_sql .= ' AND transaksi.id_brand = '.$brand;
		$sql = 'SELECT sum(transaksi_detail.jml) as cnt, product.nama_barang as nama FROM transaksi_detail LEFT JOIN product on product.id_product = transaksi_detail.id_product WHERE id_trans in ('.$_sql.')';
		$sql .=' GROUP by transaksi_detail.id_product order by cnt DESC limit 10';		
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function whs_stock($brand=0){		
		$sql = 'SELECT sum(stok.stok) as cnt, warehouse.nama_whs as nama FROM stok LEFT JOIN warehouse on warehouse.id_whs = stok.id_wh LEFT JOIN product on product.id_product = stok.id_product LEFT JOIN brand on brand.id_brand = product.id_brand WHERE stok.deleted_at is null';
		if($brand > 0) $sql .= ' AND product.id_brand = '.$brand;
		$sql .=' GROUP by stok.id_wh order by cnt DESC';		
		// error_log($sql);
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function top_stock($brand=0){		
		$sql = 'SELECT sum(stok.stok) as cnt, product.nama_barang as nama FROM stok LEFT JOIN product on product.id_product = stok.id_product WHERE stok.deleted_at is null';
		if($brand > 0) $sql .= ' AND product.id_brand = '.$brand;
		$sql .=' GROUP by stok.id_product order by cnt DESC limit 10';		
		// error_log($sql);
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function top_shop_salesman($brand=0){
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status = 6';		
		if($brand > 0) $_sql .= ' AND transaksi.id_brand = '.$brand;		
		$sql = 'SELECT sum(transaksi_detail.jml) as cnt, sales.slp_code as nama FROM transaksi_detail LEFT JOIN sales on sales.id_sales = transaksi_detail.id_sls WHERE id_trans in ('.$_sql.')';		
		$sql .=' GROUP by transaksi_detail.id_sls order by cnt DESC limit 10';		
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function count_complete_reject(){
		$res = array();
		$sql = 'select COUNT(transaksi.id_transaksi) as cnt FROM transaksi WHERE transaksi.status = 6';
		$dt = $this->db->query($sql)->row();
		$res = array('complete' => $dt->cnt);
		$sql = 'select COUNT(transaksi.id_transaksi) as cnt FROM transaksi WHERE transaksi.status = 2';
		$dt = $this->db->query($sql)->row();
		$res += array('reject' => $dt->cnt);
		return $res;
	}
	
	function daily_sales($brand=0){
		$month = date('d-m-Y');	
		$_sql = 'SELECT id_transaksi FROM transaksi WHERE transaksi.status = 6';
		$_sql .=' And date_format(transaksi.create_at, "%d-%m-%Y") = "'.$month.'"';
		if($brand > 0) $_sql .= ' AND transaksi.id_brand = '.$brand;		
		$sql = 'SELECT sum(transaksi_detail.jml) as cnt, brand.nama_brand FROM transaksi_detail LEFT JOIN brand on brand.id_brand = transaksi_detail.id_brand WHERE id_trans in ('.$_sql.')';	
		$sql .=' GROUP by transaksi_detail.id_brand order by ABS(transaksi_detail.id_brand) ASC';			
		$dt = $this->db->query($sql)->result_array();		
		return $dt;
	}
	
	function new_outlets($year=''){		
		$sql = 'SELECT COUNT(members.id_member) as cnt,date_format(members.tgl_reg, "%b") as month, date_format(members.tgl_reg, "%Y") as year FROM members WHERE members.status = 4';				
		$sql .=' And date_format(members.tgl_reg, "%Y") = "'.$year.'"';
		$sql .=' GROUP by month';				
		$dt = $this->db->query($sql)->result_array();
		//error_log(PHP_EOL.''.$sql.' '.$this->db->last_query(),3,'err');
		return $dt;
	}
	
}
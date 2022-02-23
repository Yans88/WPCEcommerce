<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_m extends CI_Model {

	function get_key_val() {
		$out = array();
		//$this->db->select('id,setting_key,setting_val');
		$this->db->from('setting');
		$query = $this->db->get();
		if($query->num_rows()>0){
				$result = $query->result();
				foreach($result as $value){
					$out[$value->setting_key] = $value->setting_val;
				}
				return $out;
		} else {
			return FALSE;
		}
	}
	
	
	
}
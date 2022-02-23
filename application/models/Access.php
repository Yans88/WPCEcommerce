<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Access extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();	
    }
    function readtable($tablename = '', $select='', $where = '', $join = '', $limit = '',$sort = '',$join_model = '',$group_by ='', $like='', $or_like='', $field_in = '', $where_in = '', $field_in2 = '', $where_in2 = '', $field_notin='',$where_notin=''){
		
		if(!empty($like)){
    		$this->db->like($like);
        }
		if(!empty($or_like)){
    		$this->db->or_like($or_like);
        }
        if(!empty($where)){
    		$this->db->where($where);
        }
		if(!empty($field_in)){
    		$this->db->where_in($field_in, $where_in);
        }
		if(!empty($field_in2)){
    		$this->db->where_in($field_in2, $where_in2);
        }
		if(!empty($field_notin)){
    		$this->db->where_not_in($field_notin, $where_notin);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }
        if(is_array($join) AND !empty($join)){
            foreach($join as $key => $data){  
                $this->db->join($key, $data,$join_model);
            }
        }
        if(!empty($limit)){ 
			// error_log(serialize($limit));
            $this->db->limit($limit);
            
        }
        if(!empty($select)){
            $this->db->select($select);
        }  
		// $cnt = count($sort);
		
		if(!empty($sort)){			
    		$this->db->order_by($sort[0],$sort[1]);
			//$this->db->order_by($sort[2],$sort[3]);		
        }
		
        $query = $this->db->get($tablename);
        return $query;
    }
    function inserttable($tablename = '', $data = '')
    {
       $this->db->insert($tablename, $data); 
	   return $this->db->insert_id();
    }
    function updatetable($tablename = '', $data = '', $where='')
    {    
        $this->db->where($where);
        return $this->db->update($tablename, $data);
    }
    function deletetable($tablename = '',$where='')
    {
        return $this->db->delete($tablename, $where); 
    }
	
	
	
	
	
}
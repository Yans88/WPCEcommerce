<?php
class Validation{
	protected 	$ci;
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model('Api_m');		
    }
	
	function check_exist($table=null, $where=null, $val=null, $user_id=null){
		$err['username'] = ['err_code' => '02', 'err_msg' => 'Username has registered'];
		$err['email'] = ['err_code' => '03', 'err_msg' => 'Email has registered'];
		$err['ok'] = ['err_code' => '00', 'err_msg' => 'OK'];
		$chk = $this->ci->Api_m->get_value($table, $where, $val, $user_id);
		if(!empty($chk)){
			return $err[$where];
		}else{
			return $err['ok'];
		}
	}
	
	
	
	function validateRequired($compare=array()){        
        $result = "";		
        foreach($compare as $key=>$val ){
			if($val == ''){
				$result = $key;
				break;
			}
            
        }		
        return $result;
    }
}

?>
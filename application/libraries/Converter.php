<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Converter 

{

	protected $ci;
	protected $skey;
	protected $apikey;
	

	function __construct(){

		$this->ci 		= & get_instance();
		$this->skey 	= $this->ci->config->item('encryption_key');
		$this->apikey	= $this->ci->config->item('encryption_key');
	}

	public function encode($value=null){
		
	    if(empty($value)){return false;}

        $text = $value;

        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);

        return trim($this->safe_b64encode($crypttext));

    }

 

    function decode($value){
 

        if(!$value){return "";}

        $crypttext = $this->safe_b64decode($value); 

        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);

        return trim($decrypttext);

    }

	

	function safe_b64encode($string) {

 

        $data = base64_encode($string);

        $data = str_replace(array('+','/','='),array('-','_',''),$data);

        return $data;

    }

 

	function safe_b64decode($string) {

        $data = str_replace(array('-','_'),array('+','/'),$string);

        $mod4 = strlen($data) % 4;

        if ($mod4) {

            $data .= substr('====', $mod4);

        }

        return base64_decode($data);

    }

	function calculate_string( $mathString )	

	{

		$mathString = trim($mathString);     // trim white spaces

		$mathString = ereg_replace ('[^0-9\+-\*\/\(\) ]', '', $mathString);    // remove any non-numbers chars; exception for math operators

		$compute = create_function("", "return (" . $mathString . ");" );

		return 0 + $compute();

	}

	

	function tgl_indo($tgl)

	{

		$data	= explode("-",$tgl);

		$format	= $data['2']."/".$data['1']."/".$data['0'];

		return $format;

	}

	

	function tgl_db($tgl)

	{

		$data	= explode("-",$tgl);

		$format	= $data['2']."-".$data['1']."-".$data['0'];

		return $format;

	}

	

	function encrypt($input)

	{

		$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);

		$input = $this->pkcs5_pad($input, $size);

		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');

		$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);

		mcrypt_generic_init($td, $this->apikey , $iv);

		$data = mcrypt_generic($td, $input);

		mcrypt_generic_deinit($td);

		mcrypt_module_close($td);

		$data = base64_encode($data);

		return $data;

	}

	

	function pkcs5_pad ($text, $blocksize) 

	{

		$pad = $blocksize - (strlen($text) % $blocksize);

		return $text . str_repeat(chr($pad), $pad);

	}

	

	function decrypt($sStr)

	{

		$decrypted= mcrypt_decrypt(

		MCRYPT_RIJNDAEL_128,

		$this->apikey,

		base64_decode($sStr),

		MCRYPT_MODE_ECB

		);

		$dec_s = strlen($decrypted);

		$padding = ord($decrypted[$dec_s-1]);

		$decrypted = substr($decrypted, 0, -$padding);

		return $decrypted;

	}	

	

	function random($length=10)

	{

		$str 			= '0123456789abcdefghjklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$random_word	= str_shuffle($str);

		$word 			= substr($random_word,0,$length);

		

		return $word;

	}


	function randomNumber($length=10)

	{

		$str 			= '0123456789';

		$random_word	= str_shuffle($str);

		$word 			= substr($random_word,0,$length);

		

		return $word;

	}

}



?>
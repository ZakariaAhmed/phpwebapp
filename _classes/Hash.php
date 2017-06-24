<?php

class Hash{
	
	public static function make($string, $salt = ''){
		return hash('sha256',$string,$salt);
	}
	
	public static function salt($length){
		 return random_bytes($length);
		 //return substr(strtr(base64_encode(hex2bin(RandomToken(32))), '+', '.'), 0, 44);	
	}
	
	public static function unique() {
		return self::make(uniqid());
	}
	
	
}

?>
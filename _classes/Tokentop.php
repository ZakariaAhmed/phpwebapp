<?php
class Tokentop {
	public static function generate() {
		//Session::put(Config::get('session/token_name'), md5(uniqid()));
		$Tokentopvalue = trim(Session::put(Config::get('session/tokentop_name'), md5(uniqid())));
		return $Tokentopvalue;
	}

	public static function check($tokentop) {
		$tokentopName =  Config::get('session/tokentop_name');
		
			if(Session::exists($tokentopName) && $tokentop === Session::get($tokentopName)) {
			Session::delete($tokentopName);
			return true;
		}
		
		return false;
		
	}
	
}


?>
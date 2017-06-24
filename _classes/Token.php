<?php
class Token {
	public static function generate() {
		//Session::put(Config::get('session/token_name'), md5(uniqid()));
		$Tokenvalue = trim(Session::put(Config::get('session/token_name'), md5(uniqid())));
		return $Tokenvalue;
	}

	public static function check($token) {
		$tokenName =  Config::get('session/token_name');
		
			if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		}
		
		return false;
		
	}
	
}


?>
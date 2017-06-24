<?php

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) 
{	
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));	
	if($hashCheck === false)
	{
        //echo '';
  } 
  else 
  {
		if($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();
		}
		
    $count = $hashCheck->count();
    if($count) {
        $user = new User($hashCheck->first()->user_id);
				$user->login();
    }
  }
}

?>
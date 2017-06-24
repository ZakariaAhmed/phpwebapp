<?php
class Setting {
	
	static $_getdata, $q_url, $q_urls, $sf_value;

		public static function getExist($get){
				if(isset($_GET[$get]))
				{
					self::$_getdata = $_GET[$get];
					return true;
				}
				
				return false;
		}
		

		public function getdata(){
			return self::$_getdata;
		}
		
		
		public function saverec(){
				if(isset($_GET['rec'])){
					self::$_getdata = $_GET['rec'];
					Session::put('rec',$_GET['rec']);
				}
				else {
					  Session::put('rec','25');
				}
		}
		
		public function showrec(){
			return Session::get('rec');
		}
		
		public static function qurlexist(){
				$q_url = $_SERVER['REQUEST_URI'];
				if (strpos($q_url,'?') !== false) {
					 $temp = explode("?", $q_url);
				   self::$q_url = $temp[1];
				   return true;
				}
				return false;
		}
		
		public static function aurlexist(){
				$q_url = $_SERVER['REQUEST_URI'];
				$q_urlpieces = explode("?", $q_url);	
				if($q_urlpieces[1]){			
							if (strpos($q_urlpieces[1],'&') !== false) {
				    	self::$q_urls = explode("&", $q_urlpieces[1]);
				    	return true;
							}
					}
				
				return false;
		}
		
		
		public static function saveget(){
				$q_urlar = self::$q_url;
				$q_urlar = explode("=", $q_urlar);
				$sf_name = $q_urlar[0];
				$sf_value = $q_urlar[1];
				Session::put($sf_name,$sf_value);
				//echo  $q_urlar;
		}
		

		public static function saveallget(){
				
				foreach(self::$q_urls as $a_url)
					{					
						$q_urlar = explode("=", $a_url);
						$sf_name = $q_urlar[0];
						$sf_value = $q_urlar[1];
						Session::put($sf_name,$sf_value);
					}

		}
		
		
		public static function saveallMygets(){
				if(self::qurlexist())
				{
						if(self::aurlexist())
						{
							//echo 'save more than 1 get';
							self::saveallget();
							
						}
						else
						{
						 //echo 'save 1 get';
						 self::saveget();
						}
				}
		}
		
		
		
		
 
}

?>
<?php
class Validate {
	private $_passed = false,
					$_errors = array(),
					$_db = null,
					$_currency = array("DKK","USD","EUR","GBP","SEK","AED","AUD","INR","CAD","SOS","KES","NOK","RUB","SAR","ETB","YER","TRY","CNY","UGX");
					
	public function __construct(){
		$this->_db = DB::getInstance();
	}
	
	public function check($source,$items = array()){
		foreach($items as $item => $rules){
			foreach($rules as $rule => $rule_value){
				//echo "{$item} {$rule} must be {$rule_value} <br>";
				$value = trim($source[$item]);
				$item = escape($item );
				
				
				if($rule === 'nr' && (!is_numeric(str_replace(",", ".",str_replace(".", "", $value))))){
					$this->addError("{$item} not number"); 
				}
				if($rule === 'required' && empty($value)){
					$this->addError("{$item} is required"); 
				} else if(!empty($value)){
					switch($rule){
						case 'nr':
							if(!is_numeric(str_replace(",", ".",str_replace(".", "", $value)))){
								$this->addError("{$item} not number");
							}
						break;
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$item} must be minimum of {$rule_value}");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$item} must be maximum of {$rule_value}");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("{$rule_value} must match {$item}");
							}
						break;
						case 'intmax':
							if($value > $rule_value){
								$this->addError("{$item} must be maximum of {$rule_value}");
							}
						break;
						case 'intmin':
							if($value < $rule_value){
								$this->addError("{$item} must be minimum of {$rule_value}");
							}
						break;
						case 'currency':
							if($this->currencycheck($value)){
								$this->addError("{$item} must known currency");
							}
						break;
						case 'email':
							if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
								$this->addError("{$item} not valid email address");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value,array($item,'=',$value));
							if($check->count()){
								$this->addError("{$item} already exist.");
							}
						break;
						case 'updunique':
							$check = $this->_db->get('agents',array($item,'=',$value));
							if($check->count() == 1 AND $check->first()->id <> $rule_value){
								$this->addError("{$item} already exist.");
							}
						break;
						
					}
				}
				
			}
		}
		
		if(empty($this->_errors)){
			$this->_passed = true;
		}
		return $this;
	}
	
	
	private function addError($error){
		$this->_errors[] = $error;
	}

	public function errors(){
		return $this->_errors;
	}

	public function passed(){
		return $this->_passed;
	}
	
	public function currencycheck($curr){
		$passed = true;
		foreach($this->_currency as $item){
			if(strtoupper($curr) == $item) $passed = false;  
		}
		return $passed;
	}
	
	
	
}
?>
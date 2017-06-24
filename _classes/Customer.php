<?php

class Customer {
	
	private $_db,
			$_data;
	
	public function __construct($customer = null){
		$this->_db = DB::getInstance();		
		if($customer) {
			$this->find($customer);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('customers',$id,$fields)){
			throw new Exception('There was a problem updating the customer.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('customers',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($customer = null){
		if($customer){
			$field = (is_numeric($customer)) ? 'id' : 'formhash';
			$data = $this->_db->get('customers', array($field,'=',$customer));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function data(){
		return $this->_data;
	}
	

}


?>
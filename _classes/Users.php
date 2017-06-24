<?php

class Users {
	
	private $_db,
			$_data,
			$_data2,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;
	
	public function __construct($user = null){
		$this->_db = DB::getInstance();
	}
	
	public function update($fields = array(), $id = null){
		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		
		if(!$this->_db->update('users',$id,$fields)){
			throw new Exception('There was a problem updating the user.');
			
		}
	}
	
	public function create($fields = array()){
		if(!$this->_db->insert('users',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}
	
	public function find($user = null){
		if($user){
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('users', array($field,'=',$user));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	

	
	public function data(){
		return $this->_data;
	}
	
	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}
	
}


?>
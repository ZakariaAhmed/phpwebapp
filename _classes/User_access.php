<?php

class User_access {
	
	private $_db,
			$_data;
	
	public function __construct($user_access = null){
		$this->_db = DB::getInstance();		
		if($user_access) {
			$this->find($user_access);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('user_access',$id,$fields)){
			throw new Exception('There was a problem updating the agent.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('user_access',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($user_access = null){
		if($user_access){
			//$field = (is_numeric($agentsettings)) ? 'id' : 'set_valuta1';
			$field = 'id';
			$data = $this->_db->get('user_access', array($field,'=',$user_access));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function finduserid($user_access = null){
		if($user_access){
			//$field = (is_numeric($agentsettings)) ? 'id' : 'set_valuta1';
			$field = 'userid';
			$data = $this->_db->get('user_access', array($field,'=',$user_access));
			
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
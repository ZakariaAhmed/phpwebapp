<?php

class Systeminfo {
	
	private $_db,
			$_data;
	
	public function __construct($systeminfo = null){
		$this->_db = DB::getInstance();		
		if($systeminfo) {
			$this->find($systeminfo);
		}		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('systeminfo',$id,$fields)){
			throw new Exception('There was a problem updating the agent.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('systeminfo',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($systeminfo = null){
		if($systeminfo){
			//$field = (is_numeric($agentsettings)) ? 'id' : 'set_valuta1';
			$field = 'id';
			$data = $this->_db->get('systeminfo', array($field,'=',$systeminfo));
			
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
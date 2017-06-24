<?php

class Schedule {
	
	private $_db,
			$_data;
	
	public function __construct($schedule = null){
		$this->_db = DB::getInstance();		
		if($schedule) {
			$this->find($schedule);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('schedules',$id,$fields)){
			throw new Exception('There was a problem updating the schedule.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('schedules',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($schedule = null){
		if($schedule){
			$field = (is_numeric($schedule)) ? 'id' : 'formhash';
			$data = $this->_db->get('schedules', array($field,'=',$schedule));
			
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
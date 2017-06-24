<?php

class Url {
	
	private $_db,
			$_data;
	
	public function __construct($url = null){
		$this->_db = DB::getInstance();		
		if($url) {
			$this->find($url);
		}
		
	}
	

	public function update($fields = array(), $id = null){		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('urls',$id,$fields)){
			throw new Exception('There was a problem updating the url.');
			
		}
	}

	
	public function create($fields = array()){
		if(!$this->_db->insert('urls',$fields)){
			throw new Exception('There was a problem creating the new account.');
			
		}
	}

	
	public function find($url = null){
		if($url){
			$field = (is_numeric($url)) ? 'id' : 'formhash';
			$data = $this->_db->get('urls', array($field,'=',$url));
			
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
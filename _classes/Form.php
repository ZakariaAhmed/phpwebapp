<?php

class Form {

    private $FormAttributes = array();
    private $FullForm;
    private $FormField;
    private $FormFieldHidden;
    private $FormStart;
    private $FormEnd;
    private $FormBody;
    public  $form = array();


    public function __construct($formtypevar)
    {
		   	$this->FormAttributes = $formtypevar; 
			$this->FormStart .= '<div class="modal fade '.$this->FormAttributes['formid'].'" id="myModal" styles="overflow:hidden" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">';
			$this->FormStart .= '<div class="modal-dialog" role="document">';
			$this->FormStart .= '<div class="modal-content">';
			$this->FormStart .= '<div class="modal-header">';
			$this->FormStart .= '<h4 class="modal-title" id="myModalLabel">'.$this->FormAttributes['formtitle'].'</h4>';
			$this->FormStart .= '<button type="button push-right" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
			$this->FormStart .= '<div class="modal-body">';
			if(!empty($this->FormAttributes['action']))
			$this->FormStart .= '<form action="'.$this->FormAttributes['action'].'" method="post" id="'.$this->FormAttributes['formid'].'">';
			else 
			$this->FormStart .= '<form action="" method="post" id="'.$this->FormAttributes['formid'].'">';
			$this->FormStart .= '<input id="POST" name="POST" type="hidden" value="1">';
			$this->FormStart .= '<input id="POSTACTION" name="POSTACTION" type="hidden" value="'.$this->FormAttributes['postaction'].'">';
			$this->FormStart .= '<input id="formhash" name="formhash" type="hidden" value="'.bin2hex(random_bytes(16)).'">';

			$this->FormEnd .= '</form>';
			$this->FormEnd .= '</div>';
			$this->FormEnd .= '<div class="modal-footer">';
			$this->FormEnd .= '<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">'.$this->FormAttributes['cancelvalue'].'</button>';
			$this->FormEnd .= '<button type="submit" class="btn btn-success btn-sm" form="'.$this->FormAttributes['formid'].'">'.$this->FormAttributes['submitvalue'].'</button>';
			$this->FormEnd .= '</div></div>';
			$this->FormEnd .= '</div>';
			$this->FormEnd .= '</div>';

    }
    
    public function addfield($fieldArray){
		$FormField = '';
		$FormField .= '<div class="form-group">';
		$FormField .= '<label for="smFormGroupInput" class="col-sm-2 col-form-label col-form-label-sm">'.$fieldArray['label'].':</label>';
		$FormField .= '<div class="col-sm-10">';
		$FormField .= '<input type="text" class="form-control form-control-sm" id="'.$fieldArray['id'].'" name="'.$fieldArray['name'].'" placeholder="'.$fieldArray['placeholder'].'" value="'.$fieldArray['value'].'" '.$fieldArray['extra'].'>';
		$FormField .= '</div>';
		$FormField .= '</div>'; 
		return $FormField;
    }



    public function addselectfield1($fieldArray){
		$FormSelectField = '';
		$FormSelectField .= '<div class="form-group">';
		$FormSelectField .= '<label for="smFormGroupInput" class="col-sm-2 col-form-label col-form-label-sm">'.$fieldArray['label'].':</label>';
		$FormSelectField .= '    <select class="js-example-basic-single pure-input-1-5" name="'.$fieldArray['name'].'" size="1">';

		$results = $wpdb->get_results("SELECT * FROM ".$fieldArray['tabelname']." WHERE deleted = 0 order by ".$fieldArray['ordername']);
            if(!empty($results)) {
            foreach($results as $r)
            {
                $FormSelectField .= '<option value="'.$r->id. '"'; 
                if($fieldArray['selectedid'] == $r->id) $FormSelectField .= 'selected'; 
                $FormSelectField .= '>' . $r->facultyname . '</option>';
            }
            } 

        $FormSelectField .= '</select></div>';
        return $FormSelectField;
    }

    public function addselectfield($fieldArray){
		$FormSelectField = '';
		$FormSelectField .= '<div class="form-group">';
		$FormSelectField .= '<label for="smFormGroupInput" class="col-sm-2 col-form-label col-form-label-sm">'.$fieldArray['label'].':</label>';
		$FormSelectField .= '<div class="col-sm-10">';
        $FormSelectField .= '    <select class="jqs" style="min-width:300px;" name="'.$fieldArray['name'].'" id="'.$fieldArray['id'].'" size="1">';

		$FormSelectField .= $fieldArray['option'];

        $FormSelectField .= '</select></div>';
        $FormSelectField .= '</div>';
        return $FormSelectField;
    }

    public function addtextarea($fieldArray){
		$FormTextarea .= '<div class="form-group">';
		$FormTextarea .= '<label for="smFormGroupInput" style="max-width:100% !important;" class="col-sm-2 col-form-label col-form-label-sm">'.$fieldArray['label'].':</label>';
		$FormTextarea .= '<div class="col-sm-10">';
		$FormTextarea .= '<textarea class="form-control" id="'.$fieldArray['id'].'" name="'.$fieldArray['name'].'" rows="'.$fieldArray['rows'].'">'.$fieldArray['textvalue'].'</textarea>';
		$FormTextarea .= '</div>';
		$FormTextarea .= '</div>';
		return $FormTextarea;
    }
    
    public function addfieldhidden($fieldhiddenArray){
		$this->FormFieldHidden .= '<input type="hidden"';
		$this->FormFieldHidden .= ' name="'.$fieldhiddenArray['name'].'"'; 
		$this->FormFieldHidden .= ' id="'.$fieldhiddenArray['id'].'"';
		$this->FormFieldHidden .= ' value="'.$fieldhiddenArray['value'].'">';	
		return $this->FormFieldHidden; 
    }

   public function addformbody($FormBody){
		$this->FormBody = $FormBody;
    }

    
    public function FullForm(){
    	$this->FullForm .= $this->FormStart;
     	$this->FullForm .= $this->FormBody;
    	$this->FullForm .= $this->FormEnd;
    	return $this->FullForm;
    }
    
    
}

?>
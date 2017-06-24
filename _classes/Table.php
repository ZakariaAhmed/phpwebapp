<?php

class Table {

    private $TableAttributes = array();
    
    private $FullTable;
    private $AllTableTr;
    private $AllTableTh;
    private $AllTableTd;
  
    private $TableStart;
    private $TableEnd;
    public  $Table = array();


    public function __construct($newTableAttributes)
    {
		    $this->TableAttributes = $newTableAttributes;
		    $tableclass = '';
		    if($this->TableAttributes['tableclass']) $tableclass = ' class="'.$this->TableAttributes['tableclass'].'"';
		    $this->TableStart .= '<table cellspacing="0" '.$tableclass.'> ';
		    $this->TableEnd .= '</table>';
    }
    
    public function submit_th($trclass){
    		if($trclass) $trclass = 'class="'.$trclass.'"';
				$this->AllTableTr .= '<tr '.$trclass.'>'.$this->AllTableTh.' ';
				$this->AllTableTr .= '</tr>';
   	    $this->AllTableTh = '';
    }

    public function submit_thead($trclass){
    		if($trclass) $trclass = 'class="'.$trclass.'"';
				$this->AllTableTr .= '<thead><tr '.$trclass.'>'.$this->AllTableTh.' ';
				$this->AllTableTr .= '</tr></thead>';
   	    $this->AllTableTh = '';
    }
    
    public function submit_td($trclass){
    		if($trclass) $trclass = 'class="'.$trclass.'"';
				$this->AllTableTr .= '<tr '.$trclass.'>'.$this->AllTableTd.' ';
				$this->AllTableTr .= '</tr>';
   	    $this->AllTableTd = '';
    }
    
    public function addth($tdclass,$tdvalue){
				$this->AllTableTh .= '<th class="'.$tdclass.'">'.$tdvalue.'</th>';
    }
    
    public function addthc($tdclass,$tdcspan,$tdvalue){
				$this->AllTableTh .= '<th class="'.$tdclass.'" colspan="'.$tdcspan.'">'.$tdvalue.'</th>';
    }
    
    public function addtd_span($tdclass,$tdvalue,$img){
				$this->AllTableTd .= '<td class="'.$tdclass.'"><span class="'.$img.'">'.$tdvalue.'</span></td>';
    }
    
    public function addtd($tdclass,$tdvalue){
				$this->AllTableTd .= '<td class="'.$tdclass.'">'.$tdvalue.'</td>';
    }
    
    public function addtdc($tdclass,$tdcspan,$tdvalue){
				$this->AllTableTh .= '<td class="'.$tdclass.'" colspan="'.$tdcspan.'">'.$tdvalue.'</td>';
    }

    public function addtdr($tdclass,$tdrspan,$tdvalue){
				$this->AllTableTh .= '<td class="'.$tdclass.'" rowspan="'.$tdrspan.'">'.$tdvalue.'</td>';
    }
        
    public function addtdlink($tdclass,$tdvalue,$tdurl){
				$this->AllTableTd .= '<td class="'.$tdclass.'"><div class="divBox"><a href="'.$tdurl.'">'.$tdvalue.'</a></div></td>';
    }
    
    public function FullTable(){
    	$this->FullTable .= $this->TableStart;
    	$this->FullTable .= $this->AllTableTr;
    	$this->FullTable .= $this->TableEnd;
    	return $this->FullTable;
    }
    
    
}

?>
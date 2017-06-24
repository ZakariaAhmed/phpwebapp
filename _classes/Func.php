<?php
class Func {
	
	private $div;
	private $divStart;
  private $divEnd;
  private $div_pagenr;
  private $li_pagenr_left;
  private $li_pagenr_center;
  private $li_pagenr_right;
  public $pginfo = array();
	
	public static function exists($name){
		return (isset($_SESSION[$name])) ? true: false;	
	}
	
	public static function div($class, $value){
		return '<div class="'.$class.'">'.$value.'</div>';
	}
	
	public static function div_left($class, $value){
		return '<div class="'.$class.'" style="float:left;">'.$value.'</div>';
	}
	
	public static function div_right($class, $value){
		return '<div class="'.$class.'" style="float:right;">'.$value.'</div>';
	}
	
	public static function div_space($pxnr,$value){
		if($value == '') $value = '&emsp;';
		return '<div style="float:left;width:'.$pxnr.'px;">'.$value.'</div>';
	}
	
	public static function span($class, $value){
		return '<span class="'.$class.'">'.$value.'</span>';
	}
	
	public static function dropdown_button($dropdown_topname){
		$dropdown = '<a id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">';
		$dropdown .= $dropdown_topname;
		$dropdown .= '</a>';
		return $dropdown;
	}
	
	public static function frontmenu_button($fmb_name,$fmb_url,$fmb_name_desc){
		$frontmenu_button = '<a class="hMenuKnap" href="'.$fmb_url.'">';
		$frontmenu_button .= '<span class="hIcon'.$fmb_name.'"></span>';
		$frontmenu_button .= '<span class="hMenuKnapHl">'.$fmb_name.'</span>';
		$frontmenu_button .= '<span class="hMenuKnapText">'.$fmb_name_desc.'</span>';
		$frontmenu_button .= '</a>';
		return $frontmenu_button;
	}
	
	
	public static function q($qpagename,$qshow,$qaction,$qsearchvalue,$qbuttonname,$qt,$qextra)
	{
		if($qsearchvalue) $qsearchvalue = 'value="'.$qsearchvalue.'"';
		$form = '<form id="tfnewsearch" method="get" action="'.$qaction.'">';
		$pagename_search = '';
		$search = '';

		$pagename_search .= '<div class="toptitlebox" >';
		$pagename_search .= '	<div class="pagename">';
		$pagename_search .= $qpagename;
		$pagename_search .= '	</div>';
			$search .= '<div class="searchfield">';
			$search .= $form;
			$search .= '  			<input type="text" class="tftextinput" name="q" id="q" size="21" maxlength="120" '.$qsearchvalue.'> ';
			$search .= '  			<input type="hidden" name="formtype" value="q"> ';
			$search .= '  			<input type="hidden" name="qt" value="'.$qt.'"> ';
			$search .= $qextra;
			$search .= '	</div>';
			$search .= '	<div class="searchbtn">';
			$search .= '		<input type="submit" value="'.$qbuttonname.'" class="tfbutton">';
			$search .= '	</form><div class="tfclear"></div>';
			$search .= '	</div> ';
			
		if($qshow) $pagename_search .= $search;
		$pagename_search .= '</div>';
		$pagename_search .= '</form>';

		return $pagename_search;
	}
	
	
	public static function button($class, $formid, $value){
		return '<button class="'.$class.'" data-toggle="modal" data-target=".'. $formid .'">'.$value.'</button>';
	}
	
	public function add_pagenr_left($active,$pgbefore){
		if($active) $this->li_pagenr_left .= '<li><a href="?pgbefore='.$pgbefore.'">&laquo; Previus</a></li>';
		else $this->li_pagenr_left .= '<li class="disabled"><a href="#">&laquo;</a></li>';
	}
	
	public function add_pagenr_center($active, $pg){
		if($active) $active = 'class="active"'; else $active = '';
		$this->li_pagenr_center .= '<li '.$active.'><a href="?pg='.$pg.'">'.$pg.'</a></li>';
	}
	
	public function add_pagenr_right($active, $pgnext){
		if($active) $this->li_pagenr_right .= '<li><a href="?pgnext='.$pgnext.'">Next &raquo;</a></li>';
		else $this->li_pagenr_right .= '<li class="disabled"><a href="#">&raquo;</a></li>';
	}
	
	public function div_pagenr(){
		$this->div_pagenr .= '<div style="width:1140px;">';
		$this->div_pagenr .= '<ul class="pagination pagination-sm">';
		$this->div_pagenr .= $this->li_pagenr_left;
		$this->div_pagenr .= $this->li_pagenr_center;
		$this->div_pagenr .= $this->li_pagenr_right;
		$this->div_pagenr .= '</ul>';
		$this->div_pagenr .= '</div>';
		return $this->div_pagenr;
	}
	
	public static function search_query($query,$init_q,$search_fieldsArray,$searchOperator){
		$new_query = $query;
		if($init_q) 
		{
			foreach( $search_fieldsArray as $search_fields ) 
			{ 
				$new_query .= ' '.$searchOperator.' '.$search_fields.' like "%'.$init_q.'%"'; 
			}
			
			//$new_query = $query . ' AND name like "%'.$init_q.'%"';	
		}
		
		return $new_query; 
	}
	
	public static function pginfo($query,$init_rec,$init_pg,$init_orderby,$init_sort,$init_search){
		$temp_query = DB::getInstance()->query($query);
		$pginfo['totalpages'] = round(($temp_query->count() / $init_rec), 0);
		$pginfo['totalrec'] = $temp_query->count();
		$pginfo['limitstart'] = (($init_rec * $init_pg) - $init_rec);
		$pginfo['limitend'] = $init_rec; //$temp_query->count();
		$tmptotalrecords = $pginfo['totalpages'] * $init_rec;		
		if($tmptotalrecords < $pginfo['totalpages']) $pginfo['totalpages'] = $pginfo['totalpages'] + 1;
		if($init_orderby) $orderby = " order by $init_orderby $init_sort"; else $orderby = "";
		$pginfo['query'] = $query . " $orderby limit ".$pginfo['limitstart'].", ".$pginfo['limitend'] ;
		
		return $pginfo; //  totalpages , totalrec , limitstart , limitend , query , $init_search
	}

	public static function fullsiteprint($title,$extrahead,$body,$bodyclass)
	{
		
		if($bodyclass <> '')$bodyclass = 'class="'.$bodyclass.'"'; 
		$body_data  = '<body '.$bodyclass.'><div id="wrapper">';
		$body_data .= $body;
		$body_data .= '</div></body>';
		
		$head  = '<!DOCTYPE html>';
		$head	.= '<html lang="en" style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">';
		$head	.= '<head>';
		$head	.= '<meta charset="utf-8" />';
		$head	.= '<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />';
		$head	.= '<title>'.$title.'</title><link rel="shortcut icon" href="favicon.ico" >';
		$head	.= '<link rel="stylesheet" href="_css/bootstrap.min_print.css" type="text/css" media="all" />';
		$head	.= '<link rel="stylesheet" href="_css/style_print.css" type="text/css" media="all" />';
		$head	.= $extrahead;
		$head	.= '</head>';
		$head	.= $body_data;
		$head .= '</html>';
		return $head;
	}
	
	public static function fullsite($title,$extrahead,$body,$bodyclass)
	{
		
		if($bodyclass <> '')$bodyclass = 'class="'.$bodyclass.'"'; 
		$body_data  = '<body '.$bodyclass.'><div id="wrapper">';
		$body_data .= $body;
		$body_data .= '</div></body>';
		
		$head  = '<!DOCTYPE html>';
		$head	.= '<html lang="en" style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">';
		$head	.= '<head>';
		$head	.= '<meta charset="utf-8" />';
		$head	.= '<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />';
		$head	.= '<title>'.$title.'</title><link rel="shortcut icon" href="favicon.ico" >';
		$head	.= '<link rel="stylesheet" href="_css/bootstrap.min.css" type="text/css" media="all" />';
		$head	.= '<link rel="stylesheet" href="_css/style.css" type="text/css" media="all" />';
		$head	.= '<link rel="stylesheet" href="_css/jquery-ui.css" type="text/css" media="all" />';
		$head	.= '<link rel="stylesheet" href="_css/flexslider.css" type="text/css" media="all" />';
		//$head	.= '<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700' rel='stylesheet' type='text/css' />';
		$head	.= '<script src="_js/jquery-1.8.0.min.js" type="text/javascript"></script>';
		$head	.= '<!--[if lt IE 9]><script src="js/modernizr.custom.js"></script><![endif]-->';
		$head	.= '<script src="_js/jquery.flexslider-min.js" type="text/javascript"></script>';
		$head	.= '<script src="_js/bootstrap.min.js" type="text/javascript"></script>';
		$head	.= '<script src="_js/jAutoCalc.js" type="text/javascript"></script>';
		$head	.= '<script src="_js/jquery-1.10.2.js" type="text/javascript"></script>';
		$head	.= '<script src="_js/jquery-ui.js" type="text/javascript"></script>';
		$head	.= '<script src="_js/functions.js" type="text/javascript"></script>';
		$head	.= '<link rel="stylesheet" href="_css/elements.css" />';
		$head	.= '<script src="_js/popform.js"></script>';
		//$head	.= '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>';
		$head	.= '<script>function myprintFunction() { window.print();}</script>';
		$head	.= '<script>$("#status_comments_"+a).slideDown();$("#valuta").focus();</script>';
		
		$head	.= '<script type="text/javascript"><!--  $(document).ready(function() {';
		$head	.= "$('form[name=cart] tr[name=line_items]').jAutoCalc({keyEventsFire: true, decimalPlaces: 2});";
		$head	.= "$('form[name=cart]').jAutoCalc({decimalPlaces: 2});";
		$head	.= '}); //--> </script>';
		

		
		$head	.= $extrahead;
		$head	.= '</head>';
		$head	.= $body_data;
		$head .= '</html>';
		
		
		
		return $head;
	}
	
	public static function friendly_path($pathArray,$this_subsite)
	{
		$friendly_path  = '<ol class="breadcrumb">';		
		foreach($pathArray as $key => $value)
		{
  		$friendly_path .= '<li><a href="'.$value['link'].'">'.$value['name'].'</a></li>';
		}				
		$friendly_path .= '<li class="active">'.$this_subsite.'</li>';
		$friendly_path .= '</ol>';
		return $friendly_path;	
	}
	
	public static function autocomplete_script($inputArray,$inputname,$lastinput)
	{		
		$autocomplete_script = '';
		$autocomplete_script .= '<script>';
		$autocomplete_script .= '$(function() {';
		$autocomplete_script .= 'var availableTags = [';
		foreach($inputArray as $input)
		{
			$autocomplete_script .= '"'.$input.'",';
		}
		$autocomplete_script .= '"MAS"';
		$autocomplete_script .= ' ];';
		$autocomplete_script .= '    $( "#'.$inputname.'" ).autocomplete({';
		$autocomplete_script .= '      source: availableTags';
		$autocomplete_script .= '    });';
		$autocomplete_script .= '  });';
		$autocomplete_script .= '  </script>';
		return $autocomplete_script;
	}
	
	public static function path($friendly_path)
	{
		$path = '';
		$path .= '<div class="m-slider">';
		$path .= '<div class="slider-holder">';
		$path .= '<span class="slider-shadow"></span>';
		$path .= '<div class="slider flexslider">';
		$path .= '<div class="slide-cnt">';
		$path .= '<div class="toppath">';
		$path .= $friendly_path;
		$path .= '</div></div></div></div></div>';
		return $path;	
	}
	
	public static function printout($title,$extrahead,$body,$bodyclass)
	{
		$headstyle	.= '<link rel="stylesheet" href="_css/printbootstrap.min.css" type="text/css" media="all" />';
		$headstyle	.= '<link rel="stylesheet" href="_css/printstyle.css" type="text/css" media="all" />';
		$headstyle	.= '<link rel="stylesheet" href="_css/printelements.css" />';
		
		$printcontent = '';
		$printcontent .= '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>';
		$printcontent .= '<script type="text/javascript">';
		$printcontent .= '$(function(){';
		$printcontent .= "$('#printOut').click(function(e){";
		$printcontent .= 'e.preventDefault();';
		$printcontent .= 'var w = window.open();';
		$printcontent .= "var printOne = $('.contentToPrint').html();";
		$printcontent .= "var printTwo = $('.termsToPrint').html();";
		$printcontent .= "w.document.write('<html><head><title>Copy Printed</title>".$headstyle."</head><body>' + printOne + '<hr />' + printTwo) + '</body></html>';";
		$printcontent .= 'w.window.print();';
		$printcontent .= 'w.document.close();';
		$printcontent .= 'return false;';
		$printcontent .= '});';
    $printcontent .= '});';
		$printcontent .= '</script>';
		return $printcontent;	
	}
	
	public static function paneldiv($title, $content, $class)
	{
		$paneldiv = '';
		$paneldiv .= '<div class="panel panel-'.$class.'">';
		$paneldiv .= '<div class="panel-heading">';
		$paneldiv .= '<h4 class="panel-title">'.$title.'</h4>';
		$paneldiv .= '</div>';
		$paneldiv .= '<div class="panel-body">';
		$paneldiv .= $content;
		$paneldiv .= '</div>';
		$paneldiv .= '</div>';
		return $paneldiv;	
	}

	public static function autocomp($inputname, $tags)
	{
		$autocomp = '';
		
		$autocomp .= '<script> var tags = [';
		//$autocomp .= '"c++", "java", "php", "coldfusion", "javascript", "asp", "ruby"';
		$autocomp .= $tags;
		$autocomp .= ']; $( "#'.$inputname.'" ).autocomplete({ source: function( request, response ) {';
		$autocomp .= 'var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );';
		$autocomp .= 'response( $.grep( tags, function( item ){ return matcher.test( item ); }) ); } }); </script>';
		return $autocomp;	
	}	
	
	public static function nav($navArray,$page_phpfile)
	{	
		
		$nav  = '<nav id="navigation"><ul>';		
		foreach($navArray as $key => $value)
		{
  		if($value['link'] == $page_phpfile) $active_nav = 'class="active"'; else $active_nav = '';
  		$nav .= '<li ' . $active_nav .' ><a href="'.$value['link'].'">'.$value['name'].'</a></li>';
		}				

		$nav .= '</ul></nav>';
		return $nav;	
	}
	
	public static function dropdown_menu($menuArray)
	{	
		
		$dropdown_menu  = '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';		
		foreach($menuArray as $key => $value)
		{
  		if($value['link'] == 'changepwd') 
  		{ 
  			$dropdown_menu .= '<li role="presentation"><button class="btn2 btn-changepwd" data-toggle="modal" data-target=".'.$value['link'].'">';
  			$dropdown_menu .= $value['name'];
  			$dropdown_menu .= '</button></li>';
  		}
  		else
  		{
	  		$dropdown_menu .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="';
	  		$dropdown_menu .= $value['link'];
	  		$dropdown_menu .= '">';
	  		$dropdown_menu .= $value['name'];
	  		$dropdown_menu .= '</a>';
	  		$dropdown_menu .= '</li>';
	  	}
		}				

		$dropdown_menu .= '</ul>';
		return $dropdown_menu;	
	}
	
	
}

?>  
<?php
    function ltkClrString($s){
		$separator = array('_','-',' ');
		return str_replace($separator,"", $s);
	}


	//$ltkLanguage = 'en';
	$ltkTexts= array();
    try{
    	if($_COOKIE["idioma_ltk"])
    		$idioma_ltk = $_COOKIE["idioma_ltk"];
    	else if(!$idioma_ltk ){
    		
    		if(strnatcasecmp(ltkClrString(get_bloginfo('language')),'ptBR') == 0 || strnatcasecmp(ltkClrString(get_bloginfo('language')),'br') == 0 ){
    			$idioma_ltk = 'br';
    		}
    		else if(strnatcasecmp(ltkClrString(get_bloginfo('language')),'esES') == 0){
    			$idioma_ltk = 'es';
    		}
    		else{
    			$idioma_ltk = 'en';
    		}
    	}
    }catch(Exception $e){
        $idioma_ltk = 'en';
    }
	
	//if(isset($idioma_ltk)){
	if(($idioma_ltk) == 'br'){
		require_once('textsPT_BR.php');
	}
	else if(($idioma_ltk) == 'es'){
		require_once('textsES.php');
	}
	else{
		require_once('textsEN.php');
	}
	
	//else{		require_once('textsEN.php');	}
	
		function getTextLtk($term){
			//Para pegar identificar array não local da função
			global $ltkTexts;
	
			if(array_key_exists($term, $ltkTexts))
			    return $ltkTexts[$term];
			else
			    return '!'.$term;		
		}
	
	
	
/*
	 
  switch ($ltkLanguage){
	
		    case 'br':
			require_once('textsPT_BR.php');
		    break; 
			
			case 'es':
			require_once('textsES.php');
		    break; 
	 		
		    default:	
			require_once('textsEN.php');
		    break;
	 }//endSwitch
*/
?>
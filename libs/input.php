<?php

class Input{

	public function get($key=''){

		if(!empty($key)){ 

		return htmlspecialchars(filter_input(INPUT_GET, $key), ENT_COMPAT, 'UTF-8'); 

		}else{

		$values = [];

	    foreach($_GET as $key => $value){

	      $values["$key"] = htmlspecialchars(filter_input(INPUT_GET, $key), ENT_COMPAT, 'UTF-8');

	    }

	    return $values;

	    }

	}

	public function post($data = ''){
	
		if(@is_array($_POST[$data]) or empty($data)){

		function secure($val) {
		    return (is_array($val))?array_map('secure',$val):htmlspecialchars($val, ENT_COMPAT, 'UTF-8');
		}

		if(empty($data)){$array = secure($_POST);}else{$array = secure($_POST[$data]);}

		$array = filter_var_array($array, FILTER_SANITIZE_STRING); 

		return $array;
			
		}else{

		return htmlspecialchars(filter_input(INPUT_POST, $data), ENT_COMPAT, 'UTF-8'); 

		}

	}


}

	$input = new input();

?>
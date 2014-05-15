<?php

function in_multiarray($needle, $haystack){
	foreach($haystack as $item){
		if(($item == $needle) || (is_array($item) && in_multiarray($needle, $item))){
			return true;
		}
	}
	return false;
}

function user_exists($string, $array){
	$i = 1;
	$string_new = $string;
	if(in_array($string_new, array('discover', 'register', 'login', 'admin', 'pierre', 'stoffe', 'giftt', 'you', 'your', 'me', 'five', 'a', 'default', 'reset', 'add', 'edit'))){
		$string_new = $string . $i++;
	}
	while(in_multiarray($string_new, $array)){
		$string_new = $string . $i++;
	}
	return $string_new;
}

?>
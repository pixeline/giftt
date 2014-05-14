<?php

// FUNCTIONS

function searchForId($id, $array){
	foreach($array as $key => $val){
		if($val['id'] === $id){
			return $key;
		}
	}
	return null;
}

function shortUrl($string){
	$shorter = str_replace('http://', '', $string);
	$shorter = str_replace('www.', '', $shorter);
	$shorter = explode('/', $shorter);
	return $shorter[0];
}


// BASICS

if(strstr($_SERVER["HTTP_HOST"], "tfe.dev") != false){ // Local dev server
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}

require_once $root . '/_include/conn.php';

session_start();

require_once $root . '/_include/me_info.php';

?>
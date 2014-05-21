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
	$shorter = str_replace('https://', '', $string);
	$shorter = str_replace('http://', '', $string);
	$shorter = str_replace('www.', '', $shorter);
	$shorter = explode('/', $shorter);
	return $shorter[0];
}

function slugify($text){ // from http://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	$text = trim($text, '-');
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	$text = strtolower($text);
	$text = preg_replace('~[^-\w]+~', '', $text);
	if(empty($text)){
		return 'n-a';
	}
	return $text;
}


// BASICS

if(strstr($_SERVER["HTTP_HOST"], "tfe.dev") != false){ // Local dev server
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}else{
	error_reporting(0);
	ini_set('display_errors', 0);
}

require_once $root . '/_include/conn.php';

session_start();

require_once $root . '/_include/me_info.php';

?>
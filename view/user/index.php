<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/functions.php';

if(!isset($me)){

	header("Location:/");

}else{

	require $root . '/_include/user_info.php';
	require 'view.php';

}

?>
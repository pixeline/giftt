<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once$root . '/functions.php';

if(!isset($me)){

	header("Location:/");

}else{

	require_once$root . '/_include/wish_info.php';
	require_once'view.php';

}

?>
<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/functions.php';

if(!isset($me)){

	header("Location:/");

}else{

	require $root . '/_include/wish_info.php';
	require 'view.php';

}

?>
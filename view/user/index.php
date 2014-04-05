<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/functions.php';

if(!isset($user)){

	header("Location:/");

}else{

	$page_user_username = $_GET['user'];
	require 'view.php';

}

?>
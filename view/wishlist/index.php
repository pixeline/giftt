<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/functions.php';

if(!isset($user)){

	header("Location:/");

}else{

	$page_user_username = $_GET['user'];
	if(empty($page_user_username)){
		$page_user_username = $username;
	}

	require $root . '/_include/wishlist_info.php';
	require 'view.php';

}

?>
<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

if(!isset($me)){

	header("Location:/register");

}else{

	require_once $root . '/_include/wishlist_info.php';
	require_once'add.php';

}

?>
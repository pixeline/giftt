<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

if(!isset($me)){

	header("Location:/register");

}else{

	require_once $root . '/_include/wish_info.php';

	if($current_wishlist['author'] != $me['id']){
		header("Location:/" . $user['username'] . "/" . $current_wishlist['slug']);
	}
	require_once'edit.php';

}

?>
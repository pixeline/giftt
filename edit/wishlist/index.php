<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

if(!isset($me)){

	header("Location:/register");

}else{

	require_once $root . '/_include/wishlist_info.php';

	if($user['id'] != $me['id']){
		header("Location:/" . $user['username']);
	}
	require_once'edit.php';

}

?>
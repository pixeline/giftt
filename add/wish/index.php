<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/functions.php';

if(!isset($me)){

	header("Location:/");

}else{

	require_once $root . '/_include/wishlist_info.php';

	if($wishlist_author != $me_id){
		header("Location:/" . $user_username . "/" . $wishlist_slug);
	}
	require_once'add.php';

}

?>
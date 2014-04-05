<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/functions.php';

if(!isset($me)){

	header("Location:/");

}else{

	require $root . '/_include/wishlist_info.php';

	if($wishlist_author != $me_id){
		header("Location:/" . $user_username . "/" . $wishlist_slug);
	}
	require 'add.php';

}

?>
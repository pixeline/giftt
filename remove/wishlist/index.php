<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

if(!isset($me)){

	header("Location:/");

}else{

	require_once $root . '/_include/wishlist_info.php';

	if($user_id != $me_id){
		header("Location:/" . $user_username);
	}
	require_once'remove_do.php';

}

?>
<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

if(!isset($me)){

	header("Location:/register");

}else{

	require_once $root . '/_include/wish_info.php';

	if($user['id'] == $me['id']){
		header("Location:/" . $user['username']);
	}else{
		require_once'shotgun.php';
	}

}

?>
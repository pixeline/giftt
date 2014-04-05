<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/functions.php';

if(!isset($user)){

	require $root . '/landing.php';

}else{

	require $root . '/_include/user_info.php';
	$page_user_username = $username;
	require $root . '/view/user/view.php';

}

?>
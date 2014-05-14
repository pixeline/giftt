<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

if(!isset($me)){

	require_once $root . '/landing.php';

}else{

	require_once $root . '/_include/user_info.php';
	require_once $root . '/view/wishlist/view.php';

}

?>
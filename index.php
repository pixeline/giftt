<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

if(isset($_GET['discover'])){

	require_once $root . '/landing.php';

}

if(!isset($me)){

	header("Location:/discover");

}else{

	require_once $root . '/_include/user_info.php';
	require_once $root . '/view/wishlist/view.php';

}

?>
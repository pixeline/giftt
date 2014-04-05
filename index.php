<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/functions.php';

if(!isset($me)){

	require $root . '/landing.php';

}else{

	require $root . '/_include/user_info.php';
	require $root . '/view/user/view.php';

}

?>
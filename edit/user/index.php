<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

if(!isset($me)){

	header("Location:/");

}else{

	require_once 'settings.php';

}

?>
<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

if(!isset($me)){

	require_once 'reset.php';

}else{

	header("Location:/");

}

?>
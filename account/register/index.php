<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

if(!isset($me)){

	require_once 'functions.php';
	require_once 'add.php';

}else{

	header("Location:/");

}

?>
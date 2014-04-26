<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';
require_once 'functions.php';

include $_SERVER['DOCUMENT_ROOT'] . '/_include/facebook/facebook.php';

if(isset($_GET['me'])){
	

}else{
	header("Location:/404.php");
}

?>
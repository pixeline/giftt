<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/functions.php';

if(isset($_SESSION['user'])){
	$user = $_SESSION['user'];
}

if(!isset($user)){

header("Location:/");

}else{

require 'add.php';

}

?>
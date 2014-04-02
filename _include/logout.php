<?php

$root = $_SERVER['DOCUMENT_ROOT'];
include $root . '/functions.php';

// LOG OUT

if(isset($_POST['logout'])){

	session_destroy();

}

?>
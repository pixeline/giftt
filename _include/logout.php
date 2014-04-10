<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

// LOG OUT

if(isset($_POST['logout'])){

	session_destroy();

}

?>
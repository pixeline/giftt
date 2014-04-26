<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

// LOG OUT

session_destroy();

header("Location:/");

?>
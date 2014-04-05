<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/functions.php';

if(!isset($user)){

header("Location:/");

}else{

require 'add.php';

}

?>
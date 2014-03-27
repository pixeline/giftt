<?php

$hostname = 'localhost';
$database = 'final';
$username = 'root';
$password = 'root';
 
try{
	$db = new PDO("mysql:host=$hostname; dbname=$database", $username,$password);
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}

catch(Exception $e){
	die("Erreur : ".$e -> getMessage());
}

?>
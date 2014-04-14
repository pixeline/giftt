<?php

$dev = 1;

if($dev == 1){
	$hostname = 'localhost';
	$database = 'final';
	$username = 'root';
	$password = 'root';
}else{
	$hostname = 'pierrestoffe.com';
	$database = 'pierr359_final';
	$username = 'pierr359_pierre';
	$password = 'V6yGc2aHhV';
}
 
try{
	$db = new PDO("mysql:host=$hostname; dbname=$database", $username,$password);
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}

catch(Exception $e){
	die("Erreur : ".$e -> getMessage());
}

?>
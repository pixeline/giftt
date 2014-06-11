<?php

if(strstr($_SERVER["HTTP_HOST"], "tfe.dev") != false){ // Local dev server
	$hostname = 'localhost';
	$database = 'final';
	$username = 'root';
	$password = 'root';
}else{
	$hostname = '#';
	$database = '#';
	$username = '#';
	$password = '#';
}
 
try{
	$db = new PDO("mysql:host=$hostname; dbname=$database", $username,$password);
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}

catch(Exception $e){
	die("Erreur : ".$e -> getMessage());
}

?>
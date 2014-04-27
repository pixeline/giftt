<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

// REGISTER

if(isset($_POST['reset'])){

	$email = htmlspecialchars($_POST['email']);
	$token = bin2hex(openssl_random_pseudo_bytes(22));
	$hashed_token = crypt($email, '$2x$12$' . $token);

	$email = "pierre.stoffe@gmail.com"; 
	$subject ="Reset your Giftt password"; 
	$header = "from: no-reply@giftt.me"; 
	$body = "Your password is " . $token;  
	mail($email, $subject, $header, $body);  
	echo "an email containning the password has been sent to you";

}

?>
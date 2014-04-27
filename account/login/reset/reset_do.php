<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

// RESET LINK

if(isset($_POST['reset'])){

	$email = htmlspecialchars($_POST['email']);

	if(empty($email)){
		$message['email'] = "You must provide your email";
	}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$message['email'] = "You must provide a valid email address";
	}

	if(!isset($message)){
		$query = $db->prepare("SELECT reset FROM users WHERE email = :email");
		$query->execute(array(
			':email' => $email
		));
		if(!$query->rowCount() > 0){
			$message['email'] = "This email address is not registered on Giftt";
		}
	}

	if(!isset($message)){
		$token = bin2hex(openssl_random_pseudo_bytes(22));
		$hashed_token = crypt($email, '$2x$12$' . $token);

		$query = $db->prepare("UPDATE users SET reset = :reset WHERE email = :email LIMIT 1");
		$query->execute(array(
			':reset' => $token,
			':email' => $email
		));

		$link = '<a href="http://giftt.me/reset/index.php?email=' . $email . '&token=' . $token . '"><strong>click on this link to reset your password</strong></a>';
 
		$subject ="Reset your Giftt password"; 
		$headers = "From: pierre@giftt.me"; 
		$body = "It seems you've forgotten your Giftt password. \nIf you haven't requested a password reset, just trash this email, otherwise, " . $link . "\n\nPierre from <a href='http://giftt.me'>Giftt.me</a>";  
		mail($email, $subject, $headers, $body);

		$sent = 1;
	}

}

// SAVE NEW PASSWORD

if(isset($_POST['newpass'])){

	$email = $_GET['email'];
	$password = htmlspecialchars($_POST['password']);

	if(empty($password)){
		$message['password'] = "You must provide a password";
	}elseif(strlen($password) < 5){
		$message['password'] = "Your password should be at least 5 characters long";
	}

	if(!isset($message)){

		// SALT AND HASH PASSWORD
		$salt = bin2hex(openssl_random_pseudo_bytes(22));
		$hash = crypt($password, '$2x$12$' . $salt);

		$query = $db->prepare("UPDATE users SET password = :password, salt = :salt, reset = '' WHERE email = :email LIMIT 1");
		$query->execute(array(
			':password' => $hash,
			':salt' => $salt,
			':email' => $email
		));

		header("Location:/login");
	}

}

?>
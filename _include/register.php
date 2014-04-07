<?php

$root = $_SERVER['DOCUMENT_ROOT'];
include $root . '/functions.php';

// REGISTER

$message = "Form not sent";

if(isset($_POST['register'])){

	$username = strtolower(htmlspecialchars($_POST['username']));
	$password1 = htmlspecialchars($_POST['password']);
	$password2 = htmlspecialchars($_POST['password2']);
	$firstname = htmlspecialchars($_POST['firstname']);
	$lastname = htmlspecialchars($_POST['lastname']);
	$email = htmlspecialchars($_POST['email']);

	$query = $db->prepare("SELECT * FROM users WHERE username = :username");
	$query->execute(array(
		'username' => $username
	));

	if($query->rowCount() > 0){
		$user_exists = 1;
	}else{
		$user_exists = 0;
	}
	
	$error = 0;

	if($password1 != $password2 || $password1 == ""){
		$error = 1;
		$message = "Password doesn't match";
	}elseif($user_exists){
		$error = 1;
		$message = "This usename already exists";
	}else{
		$letters = "/^[a-zA-Z'àâéèêôëôùûçÀÂÉÈËÔÙÛÇ()\- ]+$/";

		if(!preg_match($letters, $username) || $username == ""){
			$error = 1;
			$message= "Please enter a valid username";
		}

		if(!$error){
			$query = $db->prepare("INSERT INTO users(username, password, firstname, lastname, email) VALUES(:username, :password, :firstname, :lastname, :email)");
			$query->execute(array(
				'username' => $username,
				'password' => $password1,
				'firstname' => $firstname,
				'lastname' => $lastname,
				'email' => $email
			));
			$message = "You're registered!";
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Index</title>
	<?php require $root . '/_include/head.php'; ?>
</head>
<body class="home">
	<div class="container">
		<?php 

		echo $message;

		?>
	</div>
</body>
</html>
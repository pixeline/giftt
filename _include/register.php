<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

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

	$reserved = array('register', 'login', 'admin', 'pierre', 'giftt');

	if($password1 != $password2 || $password1 == ""){
		$error = 1;
		$message = "Password doesn't match";
	}elseif($user_exists || in_array($username, $reserved)){
		$error = 1;
		$message = "This usename already exists";
	}else{
		$letters = "/^[a-zA-Z'àâéèêôëôùûçÀÂÉÈËÔÙÛÇ()\- ]+$/";

		if(!preg_match($letters, $username) || $username == ""){
			$error = 1;
			$message= "Please enter a valid username";
		}

		$salt = bin2hex(openssl_random_pseudo_bytes(22));
		$hash = crypt($password1, '$2x$12$' . $salt);

		if(!$error){
			$query = $db->prepare("INSERT INTO users(username, password, firstname, lastname, email, salt) VALUES(:username, :password, :firstname, :lastname, :email, :salt)");
			$query->execute(array(
				'username' => $username,
				'password' => $hash,
				'firstname' => $firstname,
				'lastname' => $lastname,
				'email' => $email,
				'salt' => $salt
			));
			$query = $db->prepare("SELECT * FROM users WHERE username = :username");
			$query->execute(array(
				'username' => $username
			));
			$results = $query->fetch();

			$_SESSION['me'] = array('id' => $results['id'], 'username' => $results['username'], 'firstname' => $results['firstname'], 'lastname' => $results['lastname'], 'description' => $results['description']);
			header("Location:/");
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Index</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body class="home">
	<div class="container-fluid">
		<?php 

		echo $message;

		?>
	</div>
</body>
</html>
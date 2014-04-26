<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

// LOG IN

if(isset($_POST['login'])){

	$message = array();

	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);

	$query = $db->prepare("SELECT * FROM users WHERE email = :email");
	$query->execute(array(
		'email' => $email
	));
	$results = $query->fetch();

	if($query->rowCount() > 0){
		$email_exists = 1;
	}else{
		$email_exists = 0;
	}

	if(empty($email)){
		$message[] = "You must provide your email";
	}elseif(!$email_exists){
		$message[] = "This email is not registered";
	}elseif(empty($password)){
		$message[] = "You must provide a password";
	}elseif(strlen($password) < 5){
		$message[] = "Your password should be at least 5 characters long";
	}else{
		$hash = crypt($password, '$2x$12$' . $results['salt']);
		if($hash == $results['password']){
			$_SESSION['me'] = array('id' => $results['id'], 'username' => $results['username'], 'firstname' => $results['firstname'], 'lastname' => $results['lastname'], 'description' => $results['description'], 'feed' => $results['feed']);
			header('Location:/');
		}else{
			$message[] = "The password seems to be wrong";
		}
	}
}

?>
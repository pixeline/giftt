<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

// REGISTER

if(isset($_POST['register'])){

	$message = array();

	$password = htmlspecialchars($_POST['password']);
	$firstname = htmlspecialchars($_POST['firstname']);
	$lastname = htmlspecialchars($_POST['lastname']);
	$email = htmlspecialchars($_POST['email']);

	$query = $db->prepare("SELECT * FROM users WHERE email = :email");
	$query->execute(array(
		'email' => $email
	));

	if($query->rowCount() > 0){
		$email_exists = 1;
	}else{
		$email_exists = 0;
	}

	if(empty($firstname)){
		$message[] = "You must provide your first name";
	}elseif(strlen($firstname) < 2){
		$message[] = "Your first name should be at least 2 characters long";
	}elseif(empty($lastname)){
		$message[] = "You must provide your last name";
	}elseif(strlen($lastname) < 2){
		$message[] = "Your last name should be at least 2 characters long";
	}elseif(empty($email)){
		$message[] = "You must provide your email";
	}elseif($email_exists){
		$message[] = "Someone is already registered with this email";
	}elseif(empty($password)){
		$message[] = "You must provide a password";
	}elseif(strlen($password) < 5){
		$message[] = "Your password should be at least 5 characters long";
	}else{

		// SALT AND HASH PASSWORD
		$salt = bin2hex(openssl_random_pseudo_bytes(22));
		$hash = crypt($password, '$2x$12$' . $salt);

		// CREATE USERNAME
		$username = strtolower($firstname) . strtolower($lastname);

		$query = $db->prepare("SELECT username FROM users WHERE username LIKE :username");
		$query->execute(array(
			'username' => $username . '%'
		));

		$user = array();
		$users = $query->fetchAll();

		$username = user_exists($username, $users);

		// IMAGE

		$gravatar_id = md5(trim($email));
		$gravatar = 'http://www.gravatar.com/avatar/' . $gravatar_id . '?s=200';
		$gravatar_check = 'http://www.gravatar.com/avatar/' . $gravatar_id . '?d=404';
		$response = get_headers($gravatar_check);
		if($response[0] != "HTTP/1.0 404 Not Found"){
		    $url = $gravatar;
		    $data = file_get_contents($url);
		}

		// DB STUFF

		if(!isset($message[0])){
			if(isset($url)){
				$fileName = $username . '.jpg';
				$file = fopen($root . '/_assets/images/profile/' . $fileName, 'w+');
				fputs($file, $data);
				fclose($file);
				
				$query = $db->prepare("INSERT INTO users(username, password, firstname, lastname, email, salt, picture) VALUES(:username, :password, :firstname, :lastname, :email, :salt, :picture)");
				$query->execute(array(
					'username' => $username,
					'password' => $hash,
					'firstname' => $firstname,
					'lastname' => $lastname,
					'email' => $email,
					'salt' => $salt,
					'picture' => '_assets/images/profile/' . $fileName
				));
			}else{
				$query = $db->prepare("INSERT INTO users(username, password, firstname, lastname, email, salt) VALUES(:username, :password, :firstname, :lastname, :email, :salt)");
				$query->execute(array(
					'username' => $username,
					'password' => $hash,
					'firstname' => $firstname,
					'lastname' => $lastname,
					'email' => $email,
					'salt' => $salt
				));
			}

			$query = $db->prepare("SELECT * FROM users WHERE username = :username");
			$query->execute(array(
				'username' => $username
			));
			$results = $query->fetch();

			$_SESSION['me'] = array('id' => $results['id'], 'username' => $results['username'], 'firstname' => $results['firstname'], 'lastname' => $results['lastname'], 'description' => $results['description'], 'feed' => $results['feed']);
			
			$query = $db->prepare("INSERT INTO follows(who, who2) VALUES(:who, :who2)");
			$query->execute(array(
				'who' => $results['id'],
				'who2' => 1
			));

			header("Location:/");
		}
	}
}

?>
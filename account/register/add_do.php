<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

// REGISTER

if(isset($_POST['register'])){

	$password = htmlspecialchars($_POST['password']);
	$firstname = ucfirst(htmlspecialchars($_POST['firstname']));
	$lastname = ucfirst(htmlspecialchars($_POST['lastname']));
	$email = htmlspecialchars($_POST['email']);

	$query = $db->prepare("SELECT * FROM users WHERE email = :email AND removed != 1 ORDER BY id DESC LIMIT 1");
	$query->execute(array(
		'email' => $email
	));

	if($query->rowCount() > 0){
		$email_exists = 1;
	}else{
		$email_exists = 0;
	}

	if(empty($firstname)){
		$message['firstname'] = "You must provide your first name";
	}elseif(strlen($firstname) < 2){
		$message['firstname'] = "Your first name should be at least 2 characters long";
	}
	
	if(empty($lastname)){
		$message['lastname'] = "You must provide your last name";
	}elseif(strlen($lastname) < 2){
		$message['lastname'] = "Your last name should be at least 2 characters long";
	}
	
	if(empty($email)){
		$message['email'] = "You must provide your email";
	}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$message['email'] = "You must provide a valid email address";
	}elseif($email_exists){
		$message['email'] = "Someone is already registered with this email";
	}

	if(empty($password)){
		$message['password'] = "You must provide a password";
	}elseif(strlen($password) < 5){
		$message['password'] = "Your password should be at least 5 characters long";
	}

	if(!isset($message)){

		// SALT AND HASH PASSWORD
		$salt = bin2hex(openssl_random_pseudo_bytes(22));
		$hash = crypt($password, '$2x$12$' . $salt);

		// CREATE USERNAME
		$username = strtolower($firstname) . strtolower($lastname);
		$username = unAccent($username);

		$query = $db->prepare("SELECT username FROM users WHERE username LIKE :username");
		$query->execute(array(
			'username' => $username . '%'
		));

		$user = array();
		$users = $query->fetchAll();

		$username = user_exists($username, $users);

		// IMAGE

		/*$gravatar_id = md5(trim($email));
		$gravatar = 'http://www.gravatar.com/avatar/' . $gravatar_id . '?s=200';
		$gravatar_check = 'http://www.gravatar.com/avatar/' . $gravatar_id . '?d=404';
		$response = get_headers($gravatar_check);
		if($response[0] != "HTTP/1.0 404 Not Found"){
		    $url = $gravatar;
		}*/

		// DB STUFF
		if(isset($url)){
		    $data = file_get_contents($url);
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

		$query = $db->prepare("SELECT * FROM users WHERE username = :username AND removed != 1 ORDER BY id DESC LIMIT 1");
		$query->execute(array(
			'username' => $username
		));
		$results = $query->fetch();

		$_SESSION['me'] = array('id' => $results['id'], 'username' => $results['username'], 'firstname' => $results['firstname'], 'lastname' => $results['lastname'], 'description' => $results['description'], 'picture' => $results['picture'], 'email' => $results['email']);
		
		$query = $db->prepare("INSERT INTO follows(who, who2) VALUES(:who, :who2)");
		$query->execute(array(
			'who' => $results['id'],
			'who2' => 1
		));

		header("Location:/");
	}
}

?>
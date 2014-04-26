<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';
require_once 'functions.php';

include $_SERVER['DOCUMENT_ROOT'] . '/_include/facebook/facebook.php';

if(strstr($_SERVER["HTTP_HOST"], "tfe.dev") != false){ // Local dev server
	$facebook = new Facebook(array(
		'appId'  => '240780376110000',
		'secret' => 'b085d55f5c0d2b06b22dc5bde8a364cf',
	));
}else{
	$facebook = new Facebook(array(
		'appId'  => '760804660605313',
		'secret' => 'c8255cf71dff91ba732560ee9767f611',
	));
}
/*$facebook->destroySession();*/

$user = $facebook->getUser();

if($user){
	try{
		$user_profile = $facebook->api('/me');
	}catch(FacebookApiException $e){
		echo $e;
		$user = null;
	}
}else{
	$perm = array('scope' => 'email');
	$loginUrl = $facebook->getLoginUrl($perm);
	header('Location:' . $loginUrl);
}

if($user){

	$friends = $facebook->api('/me/friends');
	$friends_list = '';
	foreach($friends['data'] as $friend){
		$friends_list .= $friend['id'] . ',';
	}

	$facebook_id = $user_profile['id'];
	$firstname = $user_profile['first_name'];
	$lastname = $user_profile['last_name'];
	$email = $user_profile['email'];

	$query = $db->prepare("SELECT * FROM users WHERE email = :email");
	$query->execute(array(
		'email' => $email
	));

	if($query->rowCount() > 0){
		$email_exists = 1;
	}else{
		$email_exists = 0;
	}

	if($email_exists){
		$query = $db->prepare("SELECT * FROM users WHERE email = :email");
		$query->execute(array(
			'email' => $email
		));
		$results = $query->fetch();
		if(empty($results['picture'])){
			$url = 'http://graph.facebook.com/' . $results['username'] . '/picture?width=200&height=200';
			$data = file_get_contents($url);
			$fileName = $results['username'] . '.jpg';
			$file = fopen($root . '/_assets/images/profile/' . $fileName, 'w+');
			fputs($file, $data);
			fclose($file);

			$query = $db->prepare("UPDATE users SET facebook_id = :id, picture = :picture WHERE email = :email");
			$query->execute(array(
				'id' => $facebook_id,
				'picture' => '_assets/images/profile/' . $fileName,
				'email' => $email
			));
		}else{
			$query = $db->prepare("UPDATE users SET facebook_id = :id WHERE email = :email");
			$query->execute(array(
				'id' => $facebook_id,
				'email' => $email
			));
		}
	}else{

		// CREATE USERNAME
		$username = strtolower($firstname) . strtolower($lastname);

		$query = $db->prepare("SELECT username FROM users WHERE username LIKE :username");
		$query->execute(array(
			'username' => $username . '%'
		));

		$user = array();
		$users = $query->fetchAll();

		$username_new = user_exists($username, $users);
		
		$url = 'http://graph.facebook.com/' . $username . '/picture?width=200&height=200';
		$data = file_get_contents($url);
		$fileName = $username_new . '.jpg';
		$file = fopen($root . '/_assets/images/profile/' . $fileName, 'w+');
		fputs($file, $data);
		fclose($file);
			
		$query = $db->prepare("INSERT INTO users(username, firstname, lastname, email, picture, facebook_id) VALUES(:username, :firstname, :lastname, :email, :picture, :id)");
		$query->execute(array(
			'username' => $username_new,
			'firstname' => $firstname,
			'lastname' => $lastname,
			'email' => $email,
			'picture' => '_assets/images/profile/' . $fileName,
			'id' => $facebook_id
		));
		
		$new = 1;
	}

	$query = $db->prepare("SELECT * FROM users WHERE email = :email");
	$query->execute(array(
		'email' => $email
	));
	$results = $query->fetch();

	$_SESSION['me'] = array('id' => $results['id'], 'username' => $results['username'], 'firstname' => $results['firstname'], 'lastname' => $results['lastname'], 'description' => $results['description'], 'feed' => $results['feed']);

	if(isset($new) && $new == 1){
		$query = $db->prepare("INSERT INTO follows(who, who2) VALUES(:who, :who2)");
		$query->execute(array(
			'who' => $results['id'],
			'who2' => 1
		));
	}

	header("Location:/register/friends?me=".$results['id']."&me_facebook=".$user_profile['id']."&friends=".$friends_list);
}

?>
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
	$friends_list = array();
	foreach($friends['data'] as $friend){
		$friends_list[] = $friend['id'];
	}

	$facebook_id = $user_profile['id'];
	$firstname = $user_profile['first_name'];
	$lastname = $user_profile['last_name'];
	$email = $user_profile['email'];

	$query = $db->prepare("SELECT * FROM users WHERE email = :email AND removed != 1 ORDER BY id DESC LIMIT 1");
	$query->execute(array(
		'email' => $email
	));

	if($query->rowCount() > 0){
		$email_exists = 1;
	}else{
		$email_exists = 0;
	}

	if($email_exists){
		$results = $query->fetch();
		if(empty($results['picture'])){
			$url = 'http://graph.facebook.com/' . $facebook_id . '/picture?width=200&height=200';
			$data = file_get_contents($url);
			$fileName = $results['username'] . '.jpg';
			$file = fopen($root . '/_assets/images/profile/' . $fileName, 'w+');
			fputs($file, $data);
			fclose($file);

			$query = $db->prepare("UPDATE users SET facebook_id = :id, picture = :picture WHERE email = :email AND removed != 1 ORDER BY id DESC LIMIT 1");
			$query->execute(array(
				'id' => $facebook_id,
				'picture' => '_assets/images/profile/' . $fileName,
				'email' => $email
			));
		}else{
			$query = $db->prepare("UPDATE users SET facebook_id = :id WHERE email = :email AND removed != 1 ORDER BY id DESC LIMIT 1");
			$query->execute(array(
				'id' => $facebook_id,
				'email' => $email
			));
		}
	}else{

		// CREATE USERNAME
		$username = strtolower($firstname) . strtolower($lastname);
		$username = unAccent($username);

		$query = $db->prepare("SELECT username FROM users WHERE username LIKE :username");
		$query->execute(array(
			'username' => $username . '%'
		));

		$user = array();
		$users = $query->fetchAll();

		$username_new = user_exists($username, $users);
		
		$url = 'http://graph.facebook.com/' . $facebook_id . '/picture?width=200&height=200';
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

	$query = $db->prepare("SELECT * FROM users WHERE email = :email AND removed != 1 ORDER BY id DESC LIMIT 1");
	$query->execute(array(
		'email' => $email
	));
	$results = $query->fetch();

	$_SESSION['me'] = array('id' => $results['id'], 'username' => $results['username'], 'firstname' => $results['firstname'], 'lastname' => $results['lastname'], 'description' => $results['description'], 'picture' => $results['picture'], 'email' => $results['email']);
	
	// FOLLOW PIERRE STOFFE BY DEFAULT
	if(isset($new) && $new == 1){
		$query = $db->prepare("INSERT INTO follows(who, who2) VALUES(:who, :who2)");
		$query->execute(array(
			'who' => $results['id'],
			'who2' => 1
		));
	}


	// FRIENDS

	$me = $results['id'];
	$me_facebook = $user_profile['id'];

	$query = $db->prepare("SELECT id, username, firstname, lastname, facebook_id FROM users WHERE facebook_id is not null AND removed != 1 ORDER BY id DESC LIMIT 1");
	$query->execute();
	$results = $query->fetchAll();

	// GET ALL USERS WHO REGISTERED WITH FACEBOOK
	
	if(!empty($results)){
		foreach($results as $result){
			if($result['facebook_id'] != $me){
				$users_facebook[] = $result;
			}
		}

		if(!empty($users_facebook)){
			
			// GET ALL FRIENDS WHO REGISTERED WITH FACEBOOK'S ID
			foreach($friends_list as $friend){
				if(in_multiarray($friend, $users_facebook)){
					$users_friends_facebook_id[] = $friend;
				}
			}

			if(!empty($users_friends_facebook_id)){

				// GET ALL FRIENDS WHO REGISTERED WITH FACEBOOK
				foreach($users_friends_facebook_id as $friend){
					foreach($users_facebook as $user){
						if($user['facebook_id'] == $friend){
							$friends_facebook[] = $user;
						}
					}
				}
				
				if(!empty($friends_facebook)){
				
					// INSERT INTO FOLLOWS DB
					foreach($friends_facebook as $friend){
						$query = $db->prepare("SELECT * FROM follows WHERE who = :who AND who2 = :who2 AND removed != 1");
						$query->execute(array(
							'who' => $me,
							'who2' => $friend['id']
						));

						if($query->rowCount() > 0){
							$query = $db->prepare("UPDATE follows SET follow = 1, date = now() WHERE who = :who AND who2 = :who2 AND removed != 1");
							$query->execute(array(
								'who' => $me,
								'who2' => $friend['id']
							));
						}else{
							$query = $db->prepare("INSERT INTO follows(who, follow, who2) VALUES(:who, :follow, :who2)");
							$query->execute(array(
								'who' => $me,
								'follow' => 1,
								'who2' => $friend['id']
							));
						}
					}
				}
			}
		}
	}

	header("Location:/");
}

?>
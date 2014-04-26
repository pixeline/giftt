<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';
require_once 'functions.php';

include $_SERVER['DOCUMENT_ROOT'] . '/_include/facebook/facebook.php';

if(isset($_GET['me'])){
	$me = $_GET['me'];
	$me_facebook = $_GET['me_facebook'];
	$friends = $_GET['friends'];
	$friends_list = explode(',', $friends);

	$query = $db->prepare("SELECT id, username, firstname, lastname, facebook_id FROM users WHERE facebook_id is not null");
	$query->execute();
	$results = $query->fetchAll();

	// GET ALL USERS WHO REGISTERED WITH FACEBOOK
	foreach($results as $result){
		if($result['facebook_id'] != $me){
			$users_facebook[] = $result;
		}
	}

	// GET ALL FRIENDS WHO REGISTERED WITH FACEBOOK'S ID
	foreach($friends_list as $friend){
		if(in_multiarray($friend, $users_facebook)){
			$users_friends_facebook_id[] = $friend;
		}
	}

	// GET ALL FRIENDS WHO REGISTERED WITH FACEBOOK
	foreach($users_friends_facebook_id as $friend){
		foreach($users_facebook as $user){
			if($user['facebook_id'] == $friend){
				$friends_facebook[] = $user;
			}
		}
	}
	
	// INSERT INTO FOLLOWS DB
	foreach($friends_facebook as $friend){
		$query = $db->prepare("SELECT * FROM follows WHERE who = :who AND who2 = :who2");
		$query->execute(array(
			'who' => $me,
			'who2' => $friend['id']
		));

		if($query->rowCount() > 0){
			$query = $db->prepare("UPDATE follows SET follow = 1, date = now() WHERE who = :who AND who2 = :who2");
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
	header("Location:/");

}else{
	header("Location:/404.php");
}

?>
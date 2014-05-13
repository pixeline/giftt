<?php

// GET USER INFOS

if(isset($_GET['user'])){
	$user = $_GET['user'];
}else{
	$user = $me_username;
}

$query = $db->prepare("SELECT * FROM users WHERE username = :username");
$query->execute(array(
	':username' => $user,
));

if($query->rowCount() == 0){
	header("Location:/404.php");
}else{
	$user = $query->fetch();
	$user_id = $user['id'];
	$user_username = $user['username'];
	$user_firstname = $user['firstname'];
	$user_lastname = $user['lastname'];
	$user_description = $user['description'];
	$user_picture = $user['picture'];
	$user_name = $user_firstname . ' ' . $user_lastname;
	$user_url = $user_username;

	if($user_id == $me_id){
		$profile = 1;
	}else{
		$profile = 0;
	}

	$query = $db->prepare("SELECT who2, follow FROM follows WHERE who = :id AND follow = 1 AND who2 != :id2");
	$query->execute(array(
		':id' => $me_id,
		':id2' => $me_id
	));

	$me_followings_id = array();
	while($follow = $query->fetch(PDO::FETCH_ASSOC)){
		$me_followings_id[] = $follow['who2'];
	}
}

?>
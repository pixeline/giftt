<?php

// GET USER INFOS

if(isset($_GET['user'])){
	$user = $_GET['user'];
}else{
	$user = $me['username'];
}

$query = $db->prepare("SELECT * FROM users WHERE username = :username");
$query->execute(array(
	':username' => $user,
));

if($query->rowCount() == 0){
	header("Location:/404.php");
}else{
	$user = $query->fetch();
	$user_name = $user['firstname'] . ' ' . $user['lastname'];

	if($user['id'] == $me['id']){
		$mine = 1;
	}else{
		$mine = 0;
	}

	$query = $db->prepare("SELECT who2, follow FROM follows WHERE who = :id AND follow = 1 AND who2 != :id2");
	$query->execute(array(
		':id' => $me['id'],
		':id2' => $me['id']
	));

	$me_followings_id = array();
	while($follow = $query->fetch(PDO::FETCH_ASSOC)){
		$me_followings_id[] = $follow['who2'];
	}
}

?>
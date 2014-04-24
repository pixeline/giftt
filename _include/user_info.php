<?php

// GET USER INFOS

if(isset($_GET['user'])){
	$user = $_GET['user'];
}else{
	$user = $me_username;
}

$query = $db->prepare("SELECT id, username, firstname, lastname, description, picture FROM users WHERE username = :username");
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
}

?>
<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

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

$user = 0;
$user = $facebook->getUser();

if($user){
	try{
		$user_profile = $facebook->api('/me');
	}catch(FacebookApiException $e){
		error_log($e);
		$user = null;
	}
}else{
	$perm = array('scope' => 'email');
	$loginUrl = $facebook->getLoginUrl($perm);
	header('Location:' . $loginUrl);
}

if($user){

	$query = $db->prepare("SELECT * FROM users WHERE facebook_id = :id");
	$query->execute(array(
		'id' => $user
	));

	$facebook_user = $query->fetch(PDO::FETCH_ASSOC);

	if(isset($facebook_user['id'])){
		$_SESSION['me'] = array('id' => $facebook_user['id'], 'username' => $facebook_user['username'], 'firstname' => $facebook_user['firstname'], 'lastname' => $facebook_user['lastname'], 'description' => $facebook_user['description'], 'picture' => $facebook_user['picture'], 'email' => $facebook_user['email']);
		header("Location:/");
	}else{
		header("Location:/login?nofacebook");
	}
}else{
	echo "Something went wrong with Facebook";
}

?>
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

$facebook_id = $user_profile['id'];

$query = $db->prepare("SELECT * FROM users WHERE facebook_id = :id");
$query->execute(array(
	'id' => $facebook_id
));

if($query->rowCount() > 0){
	$account_exists = 1;
}else{
	$account_exists = 0;
}

if($account_exists){
	$query = $db->prepare("SELECT * FROM users WHERE facebook_id = :id");
	$query->execute(array(
		'id' => $facebook_id
	));
	$results = $query->fetch();	

	$_SESSION['me'] = array('id' => $results['id'], 'username' => $results['username'], 'firstname' => $results['firstname'], 'lastname' => $results['lastname'], 'description' => $results['description'], 'feed' => $results['feed']);
	header("Location:/");

}else{

	header("Location:/login?nofacebook");

}

?>
<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

// REGISTER

if(isset($_GET['id'])){

	$who2 = htmlspecialchars($_GET['id']);

	$query = $db->prepare("SELECT * FROM follows WHERE who = :who AND who2 = :who2");
	$query->execute(array(
		'who' => $me['id'],
		'who2' => $who2
	));

	if($query->rowCount() > 0){
		$query = $db->prepare("UPDATE follows SET follow = NOT follow, removed = 0, date = now() WHERE who = :who AND who2 = :who2");
		$query->execute(array(
			'who' => $me['id'],
			'who2' => $who2
		));
	}else{
		$query = $db->prepare("INSERT INTO follows(who, who2) VALUES(:who, :who2)");
		$query->execute(array(
			'who' => $me['id'],
			'who2' => $who2
		));
	}

	$query = $db->prepare("SELECT * FROM users WHERE id = :id");
	$query->execute(array(
		'id' => $_GET['id']
	));

	$user = $query->fetch();

	header("Location:/" . $user['username']);

}

?>
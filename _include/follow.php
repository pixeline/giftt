<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

// REGISTER

if($_POST['data']){

	$data = $_POST['data'];
	$who2 = htmlspecialchars($data['who2']);

	$query = $db->prepare("SELECT * FROM follows WHERE who = :who AND who2 = :who2");
	$query->execute(array(
		'who' => $me_id,
		'who2' => $who2
	));

	if($query->rowCount() > 0){
		$query = $db->prepare("UPDATE follows SET follow = NOT follow, date = now() WHERE who = :who AND who2 = :who2");
		$query->execute(array(
			'who' => $me_id,
			'who2' => $who2
		));
	}else{
		$query = $db->prepare("INSERT INTO follows(who, who2) VALUES(:who, :who2)");
		$query->execute(array(
			'who' => $me_id,
			'who2' => $who2
		));
	}

}

?>
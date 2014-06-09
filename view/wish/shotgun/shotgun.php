<?php

$query = $db->prepare("SELECT * FROM shotguns WHERE what = :what AND removed != 1");
$query->execute(array(
	':what' => $current_wish['id']
));

$current_shotgun = $query->fetch(PDO::FETCH_ASSOC);

if($query->rowCount() > 0){
	if($current_shotgun['shotgun'] == 0){
		$query = $db->prepare("UPDATE shotguns SET shotgun = 1, who = :who, date = now() WHERE what = :what AND removed = 0");
		$query->execute(array(
			':who' => $me['id'],
			':what' => $current_wish['id']
		));
	}else if($current_shotgun['who'] == $me['id']){
		$query = $db->prepare("UPDATE shotguns SET shotgun = NOT shotgun, who = :who, date = now() WHERE what = :what AND removed = 0");
		$query->execute(array(
			':who' => $me['id'],
			':what' => $current_wish['id']
		));
	}
}else{
	$query = $db->prepare("INSERT INTO shotguns(who, what) VALUES(:who, :what)");
	$query->execute(array(
		':who' => $me['id'],
		':what' => $current_wish['id']
	));
}

header("Location:/" . $user['username'] . '/' . $current_wishlist['slug'] . '/' . $current_wish['id']);

?>
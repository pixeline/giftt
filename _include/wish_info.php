<?php

require_once $root . '/_include/user_info.php';
require_once $root . '/_include/wishlist_info.php';

// GET WISHLIST INFOS

$get_wish = $_GET['wish'];

$query = $db->prepare("SELECT * FROM wishes WHERE id = :id AND wishlist = :wishlist AND removed = 0");
$query->execute(array(
	':id' => $get_wish,
	':wishlist' => $current_wishlist['id']
));

if($query->rowCount() == 0){
	header("Location:/404.php");
}else{
	$current_wish = $query->fetch(PDO::FETCH_ASSOC);
	$current_wish_date = strtotime($current_wish['date']);
	$current_wish_url = $user['username'] . "/" . $current_wishlist['slug'] . "/" . $current_wish['id'];

	$query = $db->prepare("SELECT * FROM shotguns WHERE what = :id AND shotgun = 1");
	$query->execute(array(
		':id' => $get_wish
	));

	$is_shotgun = 0;
	if($query->rowCount() > 0){
		$is_shotgun = 1;
		$shotgun = $query->fetch(PDO::FETCH_ASSOC);
		$current_shotgun_author = $shotgun['who'];
	}
}

?>
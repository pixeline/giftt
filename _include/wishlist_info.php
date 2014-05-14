<?php

require_once $root . '/_include/user_info.php';

// GET WISHLIST INFOS

if(isset($_GET['wishlist'])){
	$get_wishlist = $_GET['wishlist'];

	$query = $db->prepare("SELECT * FROM wishlists WHERE slug = :slug AND author = :author AND removed = :removed");
	$query->execute(array(
		':slug' => $get_wishlist,
		':author' => $user['id'],
		':removed' => 0
	));

	if($query->rowCount() == 0){
		header("Location:/404.php");
	}else{
		$current_wishlist = $query->fetch();
		
		$is_private = 0;
		if($current_wishlist['private']){
			$is_private = 1;
		}
	}
}

?>
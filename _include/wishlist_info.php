<?php

require_once $root . '/_include/user_info.php';

// GET WISHLIST INFOS

$wishlist_slug = $_GET['wishlist'];

$query = $db->prepare("SELECT * FROM wishlists WHERE slug = :slug AND author = :author AND removed = :removed");
$query->execute(array(
	':slug' => $wishlist_slug,
	':author' => $user_id,
	':removed' => 0
));

if($query->rowCount() == 0){
	header("Location:/404.php");
}else{
	$wishlist = $query->fetch();
	$current_wishlist_id = $wishlist['id'];
	$current_wishlist_author = $wishlist['author'];
	$current_wishlist_name = $wishlist['name'];
	$current_wishlist_slug = $wishlist['slug'];
	$current_wishlist_private = $wishlist['private'];
	$current_wishlist_date = strtotime($wishlist['date']);
	$current_wishlist_url = $user_username . "/" . $current_wishlist_slug;

	if($current_wishlist_private){
		$is_private = 1;
		if($current_wishlist_author != $me_id){
			$current_wishlist_access = 0;
		}
	}else{
		$is_private = 0;
	}
}

?>
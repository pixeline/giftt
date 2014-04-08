<?php

require_once $root . '/_include/user_info.php';

// GET WISHLIST INFOS

$wishlist_slug = $_GET['wishlist'];

$query = $db->prepare("SELECT * FROM wishlists WHERE slug = :slug AND author = :author");
$query->execute(array(
	':slug' => $wishlist_slug,
	':author' => $user_id
));

if($query->rowCount() == 0){
	header("Location:/404.php");
}else{
	$wishlist = $query->fetch();
	$wishlist_id = $wishlist['id'];
	$wishlist_author = $wishlist['author'];
	$wishlist_name = $wishlist['name'];
	$wishlist_slug = $wishlist['slug'];
	$wishlist_description = $wishlist['description'];
	$wishlist_private = $wishlist['private'];
	$wishlist_date = strtotime($wishlist['date']);
	$wishlist_url = $user_username . "/" . $wishlist_slug;

	if($wishlist_private){
		if($wishlist_author != $me_id){
			$wishlist_access = 0;
		}
	}
}

?>
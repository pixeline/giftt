<?php

$wishlist_user = $_GET['user'];
$wishlist_slug = $_GET['wishlist'];

if(!empty($wishlist_slug)){

	$query = $db->prepare("SELECT * FROM wishlists WHERE slug = :slug");
	$query->execute(array(
		':slug' => $wishlist_slug
	));

	if($query->rowCount() > 1){
		echo "ERROR: MORE THAN ONE WISHLIST";
		return false;
	}

	$wishlist = $query->fetch();

	$wishlist_id = $wishlist['id'];
	$wishlist_author = $wishlist['author'];
	$wishlist_name = $wishlist['name'];
	$wishlist_description = $wishlist['description'];
	$wishlist_private = $wishlist['private'];
	$wishlist_date = strtotime($wishlist['date']);

	$query = $db->prepare("SELECT * FROM users WHERE id = :id");
	$query->execute(array(
		':id' => $wishlist['author']
	));

	if($query->rowCount() == 0){
		echo "ERROR: NO AUTHOR FOUND";
	}elseif($query->rowCount() > 1){
		echo "ERROR: MORE THAN ONE AUTHOR";
		return false;
	}

	$wishlist_author = $query->fetch();

	$wishlist_author_id = $wishlist_author['id'];
	$wishlist_author_username = $wishlist_author['username'];
	$wishlist_author_firstname = $wishlist_author['firstname'];
	$wishlist_author_lastname = $wishlist_author['lastname'];

	$wishlist_author_name = $wishlist_author_firstname . ' ' . $wishlist_author_lastname;

}

?>
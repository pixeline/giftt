<?php

require $root . '/_include/user_info.php';
require $root . '/_include/wishlist_info.php';

// GET WISHLIST INFOS

$wish_id = $_GET['wish'];

$query = $db->prepare("SELECT * FROM wishes WHERE id = :id");
$query->execute(array(
	':id' => $wish_id
));

if($query->rowCount() == 0){
	header("Location:/404.php");
}else{
	$wish = $query->fetch();
	$wish_id = $wish['id'];
	$wish_author = $wish['author'];
	$wish_wishlist = $wish['wishlist'];
	$wish_name = $wish['name'];
	$wish_cover = $wish['cover'];
	$wish_description = $wish['description'];
	$wish_notes = $wish['notes'];
	$wish_price = $wish['price'];
	$wish_origin = $wish['origin'];
	$wish_date = strtotime($wish['date']);
	$wish_url = $user_username . "/" . $wishlist_slug . "/" . $wish_id;
}

?>
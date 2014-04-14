<?php

if(isset($_POST['remove'])){
	$query = $db->prepare("UPDATE wishlists SET removed=:removed WHERE id = :id");
	$query->execute(array(
		':removed' => 1,
		':id' => $wishlist_id
	));

	$query = $db->prepare("UPDATE wishes SET removed=:removed WHERE wishlist = :id");
	$query->execute(array(
		':removed' => 1,
		':id' => $wishlist_id
	));

	header("Location:/" . $me_username);
}

?>
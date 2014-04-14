<?php

if(isset($_POST['remove'])){
	$query = $db->prepare("UPDATE wishes SET removed=:removed WHERE id = :id");
	$query->execute(array(
		':removed' => 1,
		':id' => $wish_id
	));

	header("Location:/" . $wishlist_url);
}

?>
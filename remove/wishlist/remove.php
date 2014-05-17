<?php

$query = $db->prepare("UPDATE wishlists SET removed=:removed WHERE id = :id");
$query->execute(array(
	':removed' => 1,
	':id' => $current_wishlist['id']
));

$query = $db->prepare("UPDATE wishes SET removed=:removed WHERE wishlist = :id");
$query->execute(array(
	':removed' => 1,
	':id' => $current_wishlist['id']
));

header("Location:/" . $me['username']);

?>
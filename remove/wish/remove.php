<?php

$query = $db->prepare("UPDATE wishes SET removed=:removed WHERE id = :id");
$query->execute(array(
	':removed' => 1,
	':id' => $current_wish['id']
));

header("Location:/" . $me['username'] . '/' . $current_wishlist['slug']);

?>
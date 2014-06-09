<?php

$query = $db->prepare("UPDATE wishes SET removed=1 WHERE author = :author");
$query->execute(array(
	':author' => $me['id']
));

$query = $db->prepare("UPDATE wishlists SET removed=1 WHERE author = :author");
$query->execute(array(
	':author' => $me['id']
));

$query = $db->prepare("UPDATE users SET removed=1 WHERE id = :id");
$query->execute(array(
	':id' => $me['id']
));

$query = $db->prepare("UPDATE follows SET removed=1 WHERE who = :id OR who2 = :id2");
$query->execute(array(
	':id' => $me['id'],
	':id2' => $me['id']
));

$query = $db->prepare("UPDATE shotguns SET removed=1 WHERE who = :id");
$query->execute(array(
	':id' => $me['id']
));

header("Location:/logout");

?>
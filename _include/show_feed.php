<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

// SHOW FEED

$_SESSION['me']['feed'] = 1-$_SESSION['me']['feed'];
$query = $db->prepare("UPDATE users SET feed=1-feed WHERE id = :id");
$query->execute(array(
	':id' => $me_id
));

?>
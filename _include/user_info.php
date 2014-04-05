<?php

if(isset($_SESSION['user'])){

	// ME

	$user = $_SESSION['user'];

	$id = $user['id'];
	$username = $user['username'];
	$firstname = $user['firstname'];
	$lastname = $user['lastname'];
	$description = $user['description'];

	$name = $firstname . ' ' . $lastname;

}

?>
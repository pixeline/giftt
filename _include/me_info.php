<?php

if(isset($_SESSION['me'])){

	// ME

	$me = $_SESSION['me'];
	$me_id = $me['id'];
	$me_username = $me['username'];
	$me_firstname = $me['firstname'];
	$me_lastname = $me['lastname'];
	$me_description = $me['description'];
	$me_name = $me_firstname . ' ' . $me_lastname;

}

?>
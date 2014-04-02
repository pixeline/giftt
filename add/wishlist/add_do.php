<?php

$root = $_SERVER['DOCUMENT_ROOT'];
include $root . '/functions.php';

// REGISTER

$message = "Form not sent";

if(isset($_POST['add_wishlist'])){

	$id = $_SESSION['user']['id'];
	$name = htmlspecialchars($_POST['name']);
	$description = htmlspecialchars($_POST['description']);
	
	$error = 0;

	$letters = "/^[a-zA-Z0-9'àâéèêôëôùûçÀÂÉÈËÔÙÛÇ()\- ]+$/";

	if(!preg_match($letters, $name) || $name == ""){
		$error = 1;
		$message= "Please enter a valid name";
	}

	if(!$error){
		$query = $db->prepare("INSERT INTO wishlists(author, name, description) VALUES(:id, :name, :description)");
		$query->execute(array(
			'id' => $id,
			'name' => $name,
			'description' => $description
		));
		$message = "The wishlist has been created";
		header("Location:/");
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Index</title>
	<?php require $root . '/_include/head.php'; ?>
</head>
<body class="home">
	<div class="container">
		<?php 

		echo $message;

		?>
	</div>
</body>
</html>
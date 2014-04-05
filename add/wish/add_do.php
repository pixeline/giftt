<?php

$root = $_SERVER['DOCUMENT_ROOT'];
include $root . '/functions.php';

// REGISTER

$message = "Form not sent";

if(isset($_POST['add_wish'])){

	$author = $_SESSION['user']['id'];
	$wishlist = htmlspecialchars($_POST['wishlist']);
	$name = htmlspecialchars($_POST['name']);
	$description = htmlspecialchars($_POST['description']);
	$notes = htmlspecialchars($_POST['notes']);
	$price = htmlspecialchars($_POST['price']);
	$origin = htmlspecialchars($_POST['origin']);
	
	$error = 0;

	if(empty($name)){
		$error = 1;
		$message = "Please enter a name";
	}

	if($wishlist == "0"){
		$error = 1;
		$message = "Please choose a wishlist";
	}

	if(empty($description)){
		$error = 1;
		$message = "Please write a small description";
	}

	if(!$error){
		$query = $db->prepare("INSERT INTO wishes(author, wishlist, name, description, notes, price, origin) VALUES(:author, :wishlist, :name, :description, :notes, :price, :origin)");
		$query->execute(array(
			'author' => $author,
			'wishlist' => $wishlist,
			'name' => $name,
			'description' => $description,
			'notes' => $notes,
			'price' => $price,
			'origin' => $origin,
		));
		$message = "The wish has been added";

		header("Location:/" . $username);
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
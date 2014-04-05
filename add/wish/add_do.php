<?php

$message = "Form not sent";

if(isset($_POST['add_wish'])){
	
	$author = $_SESSION['user']['id'];
	$name = htmlspecialchars($_POST['name']);
	$origin = htmlspecialchars($_POST['origin']);
	$price = htmlspecialchars($_POST['price']);
	$image = $_FILES['image'];
	$wishlist = htmlspecialchars($_POST['wishlist']);
	$description = htmlspecialchars($_POST['description']);
	$notes = htmlspecialchars($_POST['notes']);

	// REQUIRED INPUTS (EXCEPT FILES)
	$required_fields = array('name', 'wishlist', 'description');
	$errors = array();

	foreach($required_fields as $field){
		if((isset($_POST[$field]) && empty($_POST[$field])) || (isset($_FILES[$field]) && empty($_FILES[$field]['name']))){
			$errors[$field] = "is required";
		}
	}

	// FILES VALIDATION
	if(isset($image) && !empty($_FILES['image']['name'])){
		if($image['size'] <= 1000000){
			$file_path = pathinfo($image['name']);
			$file_type = $file_path['extension'];
			$file_type_valid = array('jpg', 'jpeg', 'gif', 'png');

			if(in_array($file_type, $file_type_valid)){
				$image_rename = $author . '_' . $wishlist . '_' . rand() . '.' . $file_type;
				$cover = '_assets/images/wishes/' . basename($image_rename);
				move_uploaded_file($image['tmp_name'], $root . '/' . $cover);
			}else{
				$errors['image'] = "is not a valid image";
			}
		}else{
			$errors['image'] = "is too big";
		}
	}else{
		$errors['image'] = "is required";
	}

	if(!count($errors)){
		$query = $db->prepare("INSERT INTO wishes(author, wishlist, name, cover, description, notes, price, origin) VALUES(:author, :wishlist, :name, :cover, :description, :notes, :price, :origin)");
		$query->execute(array(
			'author' => $author,
			'wishlist' => $wishlist,
			'name' => $name,
			'cover' => $cover,
			'description' => $description,
			'notes' => $notes,
			'price' => $price,
			'origin' => $origin,
		));

		// GET CURRENT WISHLIST NAME
		$query = $db->prepare("SELECT slug FROM wishlists WHERE id = :id");
		$query->execute(array(
			':id' => $wishlist
		));
		$cur_wishlist = $query->fetch();
		$wishlist_slug = $cur_wishlist['slug'];

		header("Location:/" . $username . '/' . $wishlist_slug);	
	}
	
	$message = '<p>There was a problem with the following fields :</p>';
	$message .= '<ul>';
	foreach($errors as $field => $error){
		if($error){
			$message .= "<li><strong>".$field."</strong> $error<li>";
		}
	}
	$message .= '</ul>';
	echo $message;
}

?>
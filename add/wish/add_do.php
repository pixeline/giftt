<?php

$form = 1; // to load appropriate js

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
			$errors[$field] = "You must provide a " . $field;
		}
	}

	// FILES VALIDATION
	if(isset($image) && !empty($_FILES['image']['name'])){
		if($image['size'] <= 1048576){
			$file_path = pathinfo($image['name']);
			$file_type = $file_path['extension'];
			$file_type_valid = array('jpg', 'jpeg', 'gif', 'png');

			if(in_array($file_type, $file_type_valid)){
				$image_rename = $author . '_' . $wishlist . '_' . rand() . '.' . $file_type;
				$cover = '_assets/images/wishes/' . basename($image_rename);
				move_uploaded_file($image['tmp_name'], $root . '/' . $cover);
			}else{
				$errors['image'] = "The photo should be a .jpg, .png or .gif file";
			}
		}else{
			$errors['image'] = "The photo is too big";
		}
	}else{
		$errors['image'] = "You must choose a photo";
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

		/*header("Location:/" . $username . '/' . $wishlist_slug);*/
	}else{
		$message = '<p>You must correct the following fields :</p>';
		$message .= '<ul>';
		foreach($errors as $field => $error){
			if($error){
				$message .= "<li>" . $error . "</li>";
			}
		}
		$message .= '</ul>';
	}
}

?>
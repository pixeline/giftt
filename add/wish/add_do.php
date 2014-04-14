<?php

if(isset($_POST['add_wish'])){
	
	$wish_author = $me_id;
	$wish_name = htmlspecialchars($_POST['name']);
	$wish_origin = htmlspecialchars($_POST['origin']);
	$wish_price = htmlspecialchars($_POST['price']);
	$wish_image = $_FILES['image'];
	$wish_wishlist = htmlspecialchars($_POST['wishlist']);
	$wish_description = htmlspecialchars($_POST['description']);
	$wish_notes = htmlspecialchars($_POST['notes']);

	// REQUIRED INPUTS (EXCEPT FILES)
	$required_fields = array('name', 'wishlist', 'origin', 'description');
	$errors = array();

	foreach($required_fields as $field){
		if(isset($_POST[$field]) && empty($_POST[$field])){
			$errors[$field] = "You must provide a " . $field;
		}
	}

	// FILES VALIDATION
	if(isset($wish_image) && !empty($_FILES['image']['name'])){
		if($wish_image['size'] <= 1048576){
			$file_path = pathinfo($wish_image['name']);
			$file_type = $file_path['extension'];
			$file_type_valid = array('jpg', 'jpeg', 'gif', 'png');

			if(in_array($file_type, $file_type_valid)){
				$image_rename = $wish_author . '_' . $wish_wishlist . '_' . rand() . '.' . $file_type;
				$wish_cover = '_assets/images/wishes/' . basename($image_rename);
				move_uploaded_file($wish_image['tmp_name'], $root . '/' . $wish_cover);
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
			'author' => $wish_author,
			'wishlist' => $wish_wishlist,
			'name' => $wish_name,
			'cover' => $wish_cover,
			'description' => $wish_description,
			'notes' => $wish_notes,
			'price' => $wish_price,
			'origin' => $wish_origin,
		));

		// GET SELECTED WiSHLIST SLUG
		$query = $db->prepare("SELECT slug FROM wishlists WHERE id = :id");
		$query->execute(array(
			':id' => $wish_wishlist,
		));
		$sel_wishlist = $query->fetch();
		$wishlist_slug = $sel_wishlist['slug'];

		// GET CURRENT WiSH ID
		$query = $db->prepare("SELECT id FROM wishes WHERE name = :name AND wishlist = :wishlist");
		$query->execute(array(
			':name' => $wish_name,
			':wishlist' => $wish_wishlist
		));
		$cur_wish = $query->fetch();
		$wish_id = $cur_wish['id'];

		echo $wish_author;
		echo $wish_wishlist;
		echo $wishlist_slug;

		header("Location:/" . $me_username . '/' . $wishlist_slug . '/' . $wish_id);
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
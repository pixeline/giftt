<?php

if(isset($_POST['edit_wish'])){
	
	$wish_name = htmlspecialchars($_POST['name']);
	$wish_origin = htmlspecialchars($_POST['origin']);
	$wish_price = htmlspecialchars($_POST['price']);
	$wish_image = $_FILES['image'];
	$wish_wishlist = htmlspecialchars($_POST['wishlist']);
	$wish_description = htmlspecialchars($_POST['description']);
	$wish_notes = htmlspecialchars($_POST['notes']);

	// REQUIRED INPUTS (EXCEPT FILES)
	if(!isset($wish_name) || empty($wish_name)){
		$message['name'] = "You must provide your first name";
	}
	
	if(!isset($wish_wishlist) || empty($wish_wishlist)){
		$message['wishlist'] = "You must choose a wishlist";
	}
	
	if(!isset($wish_description) || empty($wish_description)){
		$message['description'] = "You must provide a description";
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
				$message['image'] = "The photo should be a .jpg, .png or .gif file";
			}
		}else{
			$message['image'] = "The photo is too big";
		}
	}

	if(!isset($message)){
		if(!empty($_FILES['image']['name'])){ // SI PAS DE CHANGEMENT D'IMAGE
			$query = $db->prepare("UPDATE wishes SET wishlist=:wishlist, name=:name, cover=:cover, description=:description, notes=:notes, price=:price, origin=:origin WHERE id=:id");
			$query->execute(array(
				'wishlist' => $wish_wishlist,
				'name' => $wish_name,
				'cover' => $wish_cover,
				'description' => $wish_description,
				'notes' => $wish_notes,
				'price' => $wish_price,
				'origin' => $wish_origin,
				'id' => $wish_id
			));
		}else{
			$query = $db->prepare("UPDATE wishes SET wishlist=:wishlist, name=:name, description=:description, notes=:notes, price=:price, origin=:origin WHERE id=:id");
			$query->execute(array(
				'wishlist' => $wish_wishlist,
				'name' => $wish_name,
				'description' => $wish_description,
				'notes' => $wish_notes,
				'price' => $wish_price,
				'origin' => $wish_origin,
				'id' => $wish_id
			));
		}

		$query = $db->prepare("SELECT slug FROM wishlists WHERE id=:id");
		$query->execute(array(
			'id' => $wish_wishlist
		));

		$results = $query->fetch();
		$wishlist_slug = $results['slug'];

		header("Location:/" . $me_username . '/' . $wishlist_slug . '/' . $wish_id);
	}else{
		echo json_encode($message);
	}
}

?>
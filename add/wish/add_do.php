<?php

if(isset($_POST['add_wish'])){
	
	$wish_author = $me['id'];
	$wish_name = htmlspecialchars($_POST['name']);
	$wish_origin = htmlspecialchars($_POST['origin']);
	$wish_price = htmlspecialchars($_POST['price']);
	$wish_currency = htmlspecialchars($_POST['currency']);
	if(!empty($wish_price)){
		if(empty($wish_currency)){
			$wish_price_full = $wish_price . "$";
		}else{
			$wish_price_full = $wish_price . $wish_currency;
		}
	}
	$wish_image = $_FILES['image'];
	if(!isset($_POST['wishlist'])){
		$_POST['wishlist'] = "";
	}
	$wish_wishlist = htmlspecialchars($_POST['wishlist']);
	$wish_description = htmlspecialchars($_POST['description']);

	// REQUIRED INPUTS (EXCEPT FILES)
	$required_fields = array('name', 'wishlist');
	$message = array();

	foreach($required_fields as $field){
		if(isset($_POST[$field]) && empty($_POST[$field])){
			$message[$field] = "You must provide a " . $field;
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
				$message['image'] = "The picture should be a .jpg, .png or .gif file";
			}
		}else{
			$message['image'] = "The picture is too big (limited to 1 mo)";
		}
	}else{
		$message['image'] = "You must provide a picture";
	}

	if(!count($message)){
		$query = $db->prepare("INSERT INTO wishes(author, wishlist, name, picture, description, price, origin) VALUES(:author, :wishlist, :name, :cover, :description, :price, :origin)");
		$query->execute(array(
			'author' => $wish_author,
			'wishlist' => $wish_wishlist,
			'name' => $wish_name,
			'cover' => $wish_cover,
			'description' => $wish_description,
			'price' => $wish_price_full,
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
		$wish = $query->fetch();

		header("Location:/" . $me['username'] . '/' . $wishlist_slug . '/' . $wish['id']);
	}
}

?>
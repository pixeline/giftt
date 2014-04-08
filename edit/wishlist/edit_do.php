<?php

$form = 1; // to load appropriate js

// SLUGIFY A TEXT
function slugify($text){ // from http://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	$text = trim($text, '-');
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	$text = strtolower($text);
	$text = preg_replace('~[^-\w]+~', '', $text);
	if(empty($text)){
		return 'n-a';
	}
	return $text;
}

if(isset($_POST['edit_wishlist'])){

	$wishlist_name = htmlspecialchars($_POST['name']);
	$wishlist_slug = slugify($wishlist_name);
	$wishlist_description = htmlspecialchars($_POST['description']);
	/*$wishlist_private = htmlspecialchars($_POST['private']);*/
	$wishlist_private = 0;

	// REQUIRED INPUTS (EXCEPT FILES)
	$required_fields = array('name', 'description');
	$errors = array();

	foreach($required_fields as $field){
		if(isset($_POST[$field]) && empty($_POST[$field])){
			$errors[$field] = "You must provide a " . $field;
		}
	}

	if(!count($errors)){
		$query = $db->prepare("UPDATE wishlists SET name=:name, slug=:slug, description=:description, private=:private WHERE id = :id");
		$query->execute(array(
			'name' => $wishlist_name,
			'slug' => $wishlist_slug,
			'description' => $wishlist_description,
			'private' => $wishlist_private,
			'id' => $wishlist_id
		));
		header("Location:/" . $me_username . '/' . $wishlist_slug);
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
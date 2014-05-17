<?php

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

if(isset($_POST)){
	$wishlist_author = $me['id'];
	$wishlist_name = htmlspecialchars($_POST['name']);
	$wishlist_slug = slugify($wishlist_name);

	if(!isset($_POST['private'])){
		$wishlist_private = 0;
	}else{
		$wishlist_private = 1;
	}

	// REQUIRED INPUTS (EXCEPT FILES)
	$required_fields = array('name');
	$errors = array();

	foreach($required_fields as $field){
		if(isset($_POST[$field]) && empty($_POST[$field])){
			$errors[$field] = "You must provide a " . $field;
		}
	}

	if(!count($errors)){
		$query = $db->prepare("INSERT INTO wishlists(author, name, slug, private) VALUES(:author, :name, :slug, :private)");
		$query->execute(array(
			'author' => $wishlist_author,
			'name' => $wishlist_name,
			'slug' => $wishlist_slug,
			'private' => $wishlist_private
		));
		header("Location:/" . $me['username'] . '/' . $wishlist_slug);
	}
}

?>
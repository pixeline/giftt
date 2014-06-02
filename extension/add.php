<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';
require_once $root . '/_include/user_info.php';

$wish_author = $me['id'];
$wish_name = htmlspecialchars($_POST['name']);
$wish_origin = htmlspecialchars($_POST['origin']);
$wish_price = htmlspecialchars($_POST['price']);
$wish_currency = htmlspecialchars($_POST['currency']);
if(empty($wish_currency)){
	$wish_currency = "$";
}

$wish_image = $_POST['image'];

$wish_wishlist = htmlspecialchars($_POST['wishlist']);
if(isset($wish_wishlist) && $wish_wishlist == "new"){
	$wishlist_author = $me['id'];
	$wishlist_name = htmlspecialchars($_POST['new_wishlist']);
	$wishlist_slug = slugify($wishlist_name);

	if(isset($_POST['new_wishlist_private'])){
		$wishlist_private = 1;
	}else{
		$wishlist_private = 0;
	}

	$new_wishlist = 1;
}

$wish_description = htmlspecialchars($_POST['description']);

// REQUIRED INPUTS (EXCEPT FILES)
$required_fields = array('name');
$message = array();

foreach($required_fields as $field){
	if(isset($_POST[$field]) && empty($_POST[$field])){
		$message[$field] = "You must provide a " . $field;
	}
}

// FILES VALIDATION
if(isset($wish_image) && !empty($wish_image)){
	$data = file_get_contents($wish_image);
	$file_type = pathinfo($wish_image, PATHINFO_EXTENSION);
	$image_rename = $wish_author . '_' . $wish_wishlist . '_' . rand() . '.' . $file_type;
	$wish_picture = '_assets/images/wishes/' . basename($image_rename);
	$file = fopen($root . '/_assets/images/wishes/' . basename($image_rename), 'w+');
	fputs($file, $data);
	fclose($file);
}else{
	$message['image'] = "You must provide a picture";
}

if(!count($message)){

	// INSERT NEW WISHLIST (MAYBE)
	if(isset($new_wishlist) && $new_wishlist == 1){
		$query = $db->prepare("INSERT INTO wishlists(author, name, slug, private) VALUES(:author, :name, :slug, :private)");
		$query->execute(array(
			'author' => $wishlist_author,
			'name' => $wishlist_name,
			'slug' => $wishlist_slug,
			'private' => $wishlist_private
		));
		$query = $db->prepare("SELECT id FROM wishlists WHERE slug = :slug");
		$query->execute(array(
			'slug' => $wishlist_slug
		));
		$results = $query->fetch(PDO::FETCH_ASSOC);
		$wish_wishlist = $results['id'];
	}

	// INSERT NEW WISH
	$query = $db->prepare("INSERT INTO wishes(author, wishlist, name, picture, description, price, currency, origin) VALUES(:author, :wishlist, :name, :picture, :description, :price, :currency, :origin)");
	$query->execute(array(
		'author' => $wish_author,
		'wishlist' => $wish_wishlist,
		'name' => $wish_name,
		'picture' => $wish_picture,
		'description' => $wish_description,
		'price' => $wish_price,
		'currency' => $wish_currency,
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

	echo "ok";
}else{
	var_dump($message);
}

?>
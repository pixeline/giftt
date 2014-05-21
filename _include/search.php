<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';
require_once $root . '/_include/user_info.php';

// SEARCH

if(isset($_POST['data'])){

	$data = $_POST['data'];
	$input = htmlspecialchars($data['search']);

	// USERS

	$query = $db->prepare("SELECT firstname, lastname, username FROM users WHERE firstname LIKE :firstname OR lastname LIKE :lastname OR username LIKE :username ORDER BY id LIMIT 15");
	$query->execute(array(
		':firstname' => '%' . $input . '%',
		':lastname' => '%' . $input . '%',
		':username' => '%' . $input . '%'
	));

	$users_results = array();
	while($result = $query->fetch(PDO::FETCH_ASSOC)){
		$users_results[] = $result;
	}

	if(isset($users_results[0])){
?>
<p class="title">People</p>
<ul>
<?php
	}

	foreach($users_results as $user){
?>
<li class="item user">
	<a href="/<?php echo $user['username'] ?>"><?php echo $user['firstname'] . " " . $user['lastname']; ?></a>
</li>
<?php
	}

	if(isset($users_results[0])){
?>
</ul>
<?php
	}


	// WISHLISTS

	$query = $db->prepare("SELECT name, slug FROM wishlists WHERE name LIKE :name AND author = :author AND removed = 0 ORDER BY id LIMIT 15");
	$query->execute(array(
		':name' => '%' . $input . '%',
		':author' => $me['id']
	));

	$wishlists_results = array();
	while($result = $query->fetch(PDO::FETCH_ASSOC)){
		$wishlists_results[] = $result;
	}

	if(isset($wishlists_results[0])){
?>
<p class="title">Your wishlists</p>
<ul>
<?php
	}

	foreach($wishlists_results as $wishlist){
?>
<li class="item wishlist">
	<a href="/<?php echo $me['username'] . '/' . $wishlist['slug'] ?>"><?php echo $wishlist['name']; ?></a>
</li>
<?php
	}

	if(isset($wishlists_results[0])){
?>
</ul>
<?php
	}


	// WISHES

	$query_wishlists = $db->prepare("SELECT * FROM wishlists WHERE author = :id AND removed = 0 ORDER BY id DESC");
	$query_wishlists->execute(array(
		':id' => $me['id']
	));

	$wishlists = array();
	while($wishlist = $query_wishlists->fetch(PDO::FETCH_ASSOC)){
		$wishlists[] = $wishlist;
	}

	$query = $db->prepare("SELECT id, name, wishlist FROM wishes WHERE (name LIKE :name OR origin LIKE :origin) AND author = :author AND removed = 0 ORDER BY id LIMIT 15");
	$query->execute(array(
		':name' => '%' . $input . '%',
		':origin' => '%' . $input . '%',
		':author' => $me['id']
	));

	$wishes_results = array();
	while($result = $query->fetch(PDO::FETCH_ASSOC)){
		$wishes_results[] = $result;
	}

	if(isset($wishes_results[0])){
?>
<p class="title">Your wishes</p>
<ul>
<?php
	}

	foreach($wishes_results as $wish){
		$wishlist_index = searchForId($wish['wishlist'], $wishlists);
?>
<li class="item wishes">
	<a href="/<?php echo $me['username'] . '/' . $wishlists[$wishlist_index]['slug'] . '/' . $wish['id']; ?>"><?php echo $wish['name']; ?></a>
</li>
<?php
	}

	if(isset($wishes_results[0])){
?>
</ul>
<?php
	}

}

?>
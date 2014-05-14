<?php

// GET WISHLISTS

if($mine){
	$query_wishlists = $db->prepare("SELECT * FROM wishlists WHERE author = :id AND removed = 0 ORDER BY id DESC");
	$query_wishlists->execute(array(
		':id' => $user['id']
	));
}else{
	$query_wishlists = $db->prepare("SELECT * FROM wishlists WHERE author = :id AND private = 0 AND removed = 0 ORDER BY id DESC");
	$query_wishlists->execute(array(
		':id' => $user['id']
	));
}

$wishlists = array();
while($wishlist = $query_wishlists->fetch(PDO::FETCH_ASSOC)){
	$wishlists[] = $wishlist;
}

$wishlists_id = array();
foreach($wishlists as $wishlist){
	$wishlists_id[] = $wishlist['id'];
}

if(isset($wishlists_id[0])){
	$wishlists_id = join(',', $wishlists_id);
}


// GET WISHES

$query_wishes = $db->prepare("SELECT * FROM wishes WHERE removed = 0 AND author = :id AND wishlist IN ($wishlists_id) ORDER BY id DESC");
$query_wishes->execute(array(
	':id' => $user['id']
));

$wishes = array();
while($wish = $query_wishes->fetch(PDO::FETCH_ASSOC)){
	$wishes[] = $wish;
}


// GET FOLLOWS

$query = $db->prepare("SELECT who2, follow FROM follows WHERE who = :id AND follow = 1 AND who2 != :id2");
$query->execute(array(
	':id' => $me['id'],
	':id2' => $me['id']
));

$followings_id = array();
while($follow = $query->fetch(PDO::FETCH_ASSOC)){
	$followings_id[] = $follow['who2'];
}
if(isset($followings_id[0])){
	$followings_id = join(',', $followings_id);

	$query = $db->prepare("SELECT * FROM users WHERE id IN ($followings_id)");
	$query->execute();

	$followings = array();
	while($following = $query->fetch(PDO::FETCH_ASSOC)){
		$followings[] = $following;
	}
}else{
	$followings = 0;
}


$query = $db->prepare("SELECT who, follow FROM follows WHERE who2 = :id AND follow = 1 AND who != :id2");
$query->execute(array(
	':id' => $user['id'],
	':id2' => $user['id']
));

$followers_id = array();
while($follow = $query->fetch(PDO::FETCH_ASSOC)){
	$followers_id[] = $follow['who'];
}
if(isset($followers_id[0])){
	$followers_id = join(',', $followers_id);

	$query = $db->prepare("SELECT * FROM users WHERE id IN ($followers_id)");
	$query->execute();

	$followers = array();
	while($follower = $query->fetch(PDO::FETCH_ASSOC)){
		$followers[] = $follower;
	}
}else{
	$followers = 0;
}

?>
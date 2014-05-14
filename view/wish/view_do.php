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

$query_prev_wish = $db->prepare("SELECT * FROM wishes WHERE removed = 0 AND author = :id AND id < :id2 AND wishlist IN ($wishlists_id) ORDER BY id DESC LIMIT 1");
$query_prev_wish->execute(array(
	':id' => $user['id'],
	':id2' => $current_wish['id']
));

if($query_prev_wish->rowCount() > 0){
	$prev_wish = $query_prev_wish->fetch(PDO::FETCH_ASSOC);
}else{
	$prev_wish = 0;
}


$query_next_wish = $db->prepare("SELECT * FROM wishes WHERE removed = 0 AND author = :id AND id > :id2 AND wishlist IN ($wishlists_id) ORDER BY id DESC LIMIT 1");
$query_next_wish->execute(array(
	':id' => $user['id'],
	':id2' => $current_wish['id']
));

if($query_next_wish->rowCount() > 0){
	$next_wish = $query_next_wish->fetch(PDO::FETCH_ASSOC);
}else{
	$next_wish = 0;
}



/*SELECT id, title, MIN(created) AS created_date
FROM photo
WHERE created >
  (SELECT created FROM photo WHERE id = '32kJ')
GROUP BY created
ORDER BY created ASC
LIMIT 1;*/

?>
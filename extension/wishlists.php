<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

if(isset($me)){

	$query = $db->prepare("SELECT id, name FROM wishlists WHERE author = :author AND removed = 0");
	$query->execute(array(
		':author' => $me['id']
	));

	$wishlists = array();
	while($wishlist = $query->fetch(PDO::FETCH_ASSOC)){
		$wishlists[] = $wishlist;
	}
?>

	<option value="0" disabled>Choose a wishlist...</option>

<?php

	if(isset($wishlists[0])){

		foreach($wishlists as $wishlist){
?>

		<option value="<?php echo $wishlist['id']; ?>"><?php echo $wishlist['name']; ?></option>

<?php
		}

	}
?>

	<option value="setnew">New wishlist</option>

<?php

}

?>
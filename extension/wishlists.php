<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

$query = $db->prepare("SELECT id, name FROM wishlists WHERE author = :author AND removed = 0");
$query->execute(array(
	':author' => $me['id']
));

$wishlists = array();
while($wishlist = $query->fetch(PDO::FETCH_ASSOC)){
	$wishlists[] = $wishlist;
}

if(isset($wishlists[0])){

	foreach($wishlists as $wishlist){
?>

	<option value="<?php echo $wishlist['id']; ?>"><?php echo $wishlist['name']; ?></option>

<?php
	}

}

?>
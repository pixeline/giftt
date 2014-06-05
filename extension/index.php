<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/_include/functions.php';
?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Giftt extension</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="//use.typekit.net/jmx3imb.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</head>
<body>

	<?php
		if(isset($me)){
	?>

	<div class="container">
		<form action="#" method="POST" enctype="multipart/form-data">
			<input type="text" id="origin" name="origin" />
			<div class="sep">
				<span id="image">Drop a picture here...</span>
				<input type="text" id="picture" name="image" />
			</div>

			<div class="sep">
				<label for="name">Name</label>
				<input type="text" id="name" name="name" />
			</div>

			<div class="sep">
				<label for="price">Price</label>
				<input type="text" id="price" name="price" />
				<input type="text" id="currency" name="currency" value="$" />
			</div>

			<div class="sep">
				<label for="wishlist">Wishlist</label>
				<select id="wishlist" name="wishlist">
					<?php

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
				</select>
			</div>

			<div class="sep fade">
				<label for="description">Description</label>
				<textarea id="description" name="description" noresize></textarea>
			</div>

			<div class="sep submit">
				<input type="submit" id="submit" value="Add to Giftt" />
			</div>

		</form>
	</div>

	<?php }else{ ?>

	<p>Hello</p>

	<?php } ?>

	<script src="https://code.jquery.com/jquery-2.0.3.min.js"></script>
	<script src="script.js"></script>

</body>
</html>
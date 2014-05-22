<?php require_once 'edit_do.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Edit your wish</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>

<body class="wish edit nojs">

	<section class="main">

		<?php require_once $root . '/_include/wish_header.php'; ?>

		<section class="content form">

			<div class="container">

				<h2>Edit your wish</h2>

				<form class="default" action="#" method="POST" enctype="multipart/form-data">
					
					<div class="row">
						<div class="col-sm-4">
							<label for="image"><strong>Photo</strong></label>
							<div class="file_cont<?php if(isset($message['image'])){ echo ' error'; } ?>">
								<img src="/<?php echo $current_wish['picture']; ?>" alt="<?php if(isset($current_wish['name'])) echo $current_wish['name']; ?>" <?php if(!isset($current_wish['picture'])) echo "style='display: none;'"; ?> />
								<span class="icon-picture" <?php if(isset($current_wish['picture'])) echo "style='display: none;'"; ?>></span>
								<input <?php if(isset($message['image'])){ echo 'class="error"'; } ?>id="image" type="file" name="image" required />
								<p class="error"><?php if(isset($message['image'])){ echo $message['image']; } ?></p>
							</div>
						</div>
						<div class="col-sm-8">
							<label for="name"><strong>Name</strong> (required)</label>
							<input class="first<?php if(isset($message['name'])){ echo ' error'; } ?>" id="name" type="text" name="name" value="<?php if(isset($wish_name)){ echo $wish_name; }else if(isset($current_wish['name'])) echo $current_wish['name']; ?>" placeholder="Name" required />
							<p class="error"><?php if(isset($message['name'])){ echo $message['name']; } ?></p>
							
							<label for="wishlist"><strong>Wishlist</strong> (required)</label>
							<select<?php if(isset($message['wishlist'])){ echo ' class="error"'; } ?> id="wishlist" name="wishlist" required>

								<option value="0" disabled>Choose a wishlist...</option>
										
								<?php

								$query = $db->prepare("SELECT * FROM wishlists WHERE author = :author AND removed = 0 ORDER BY id DESC");
								$query->execute(array(
									':author' => $me['id']
								));

								while($wishlist = $query->fetch(PDO::FETCH_ASSOC)){
									$wishlists[] = $wishlist;
								}

								foreach($wishlists as $wishlist){
									$name = $wishlist['name'];
									$id = $wishlist['id'];

								?>

								<option value="<?php echo $id; ?>" <?php if(isset($current_wish['wishlist']) && $current_wish['wishlist'] == $id){ echo "selected"; }else if(isset($current_wishlist['name']) && $name == $current_wishlist['name']){ echo "selected"; } ?>><?php echo $name; ?></option>

								<?php

									}

								?>

								<option value="new">New wishlist</option>

							</select>
							<p class="error"><?php if(isset($message['wishlist'])){ echo $message['wishlist']; } ?></p>
							
							<div class="row">
								<div class="col-sm-5">
									<label for="price"><strong>Price</strong></label>
									<input id="price" type="text" name="price" value="<?php if(isset($current_wish['price'])) echo $current_wish['price'] ?>" placeholder="Price" />
									<label for="currency"><strong>Currency</strong></label>
									<input id="currency" type="text" name="currency" value="<?php if(isset($current_wish['currency'])) echo $current_wish['currency']; ?>" placeholder="$" />
								</div>

								<div class="col-sm-7">
									<label for="origin"><strong>Origin</strong></label>
									<input id="origin" type="url" name="origin" value="<?php if(isset($current_wish['origin'])) echo $current_wish['origin']; ?>" placeholder="http://" />
								</div>
							</div>
							
							<label for="description"><strong>Description</strong></label>
							<textarea id="description" name="description" placeholder="Description of the item" ><?php if(isset($current_wish['description'])) echo $current_wish['description']; ?></textarea>
						</div>
						<div class="col-sm-8 col-sm-offset-4">
							<input class="text" type="submit" name="edit_wish" value="Edit your wish" />
						</div>
					</div>
				</form>

			</div>

		</section>

		<?php require_once $root . '/_include/footer.php'; ?>

	</section>

	<?php require_once $root . '/_include/feed.php'; ?>

	<?php require_once $root . '/_include/foot.php'; ?>
</body>
</html>
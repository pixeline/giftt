<?php

require_once $root . '/edit/wish/edit_do.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Edit <?php echo $wish_name; ?></title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body class="wish edit nojs">

	<section class="main">

		<?php require_once $root . '/_include/wishlist_header.php'; ?>

		<section class="content form">

			<div class="container">

				<div class="row">

					<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

						<h3>Edit <?php echo $wish_name; ?></h3>

						<form id="edit_wish" action="/<?php echo $wish_url; ?>/edit" method="POST" enctype="multipart/form-data">
							
							<?php if(isset($message)){ ?>
								<div class="error_block">
									<?php  echo $message; ?>
								</div>
							<?php } ?>
							
							<div class="row">
								<div class="col-sm-12">
									<label for="name"><strong>Name</strong> (required)</label>
								</div>
								<div class="col-sm-12">
									<input id="name" type="text" name="name" value="<?php if(isset($wish_name)) echo $wish_name ?>" required />
								</div>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-12">
											<label for="origin"><strong>Origin</strong></label>
										</div>
										<div class="col-sm-12">
											<input id="origin" type="url" name="origin" value="<?php if(isset($wish_origin)) echo $wish_origin ?>" placeholder="http://" />
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-12">
											<label for="price"><strong>Price</strong></label>
										</div>
										<div class="col-sm-12">
											<input id="price" type="text" name="price" value="<?php if(isset($wish_price)) echo $wish_price ?>" />
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="row">
										<div class="col-sm-12">
											<label for="image"><strong>Photo</strong></label>
										</div>
										<div class="col-sm-12">
											<div class="file_cont entypo picture">
												<?php if(isset($wish_cover)){ ?>
													<img src="/<?php echo $wish_cover; ?>" alt="<?php echo $wish_name; ?>" />
												<?php }else{ ?>
													<span class="icon"></span>
												<?php } ?>
												<input id="image" type="file" name="image" required />
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-8">
									<div class="row">
										<div class="col-sm-12">
											<label for="wishlist"><strong>Wishlist</strong> (required)</label>
										</div>
										<div class="col-sm-12">
											<select id="wishlist" name="wishlist" required>
												
												<?php

												$query = $db->prepare("SELECT * FROM wishlists WHERE author = :author");
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

												<option value="<?php echo $id; ?>" <?php if($name == $wishlist_name) echo "selected"; ?>><?php echo $name; ?></option>

												<?php

													}

												?>

											</select>
										</div>
										<div class="col-sm-12">
											<label for="description"><strong>Description</strong></label>
										</div>
										<div class="col-sm-12">
											<textarea id="description" name="description" required><?php if(isset($wish_description)) echo $wish_description ?></textarea>
										</div>
										<div class="col-sm-12">
											<label for="notes"><strong>Notes</strong></label>
										</div>
										<div class="col-sm-12">
											<textarea id="notes" name="notes"><?php if(isset($wish_notes)) echo $wish_notes ?></textarea>
										</div>
									</div>
								</div>
								<div class="col-sm-8 col-sm-offset-4">
									<input type="submit" name="edit_wish" value="Edit the wish" />
								</div>
							</div>
						</form>

					</div>

				</div>

			</div>

		</section>

	</section>

	<?php require_once $root . '/_include/feed.php'; ?>

	<?php require_once $root . '/_include/foot.php'; ?>
</body>
</html>
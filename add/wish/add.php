<?php

require $root . '/_include/wishlist_info.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Add a wishlist</title>
	<?php require $root . '/_include/head.php'; ?>
</head>
<body class="wish add">

	<section class="main">

		<?php require $root . '/_include/wishlist_header.php'; ?>

		<section class="content form">

			<div class="container">

				<div class="row">

					<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

						<h3><strong>Add</strong> a wish</h3>
						<form action="/add/wish/add_do.php" method="POST">
							<div class="row">
								<div class="col-sm-12">
									<label for="name"><strong>Name</strong> (required)</label>
								</div>
								<div class="col-sm-12">
									<input type="text" name="name" value="" />
								</div>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-12">
											<label for="origin"><strong>Origin</strong></lable>
										</div>
										<div class="col-sm-12">
											<input type="url" name="origin" value="http://" />
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-12">
											<label for="price"><strong>Price</strong></label>
										</div>
										<div class="col-sm-12">
											<input type="text" name="price" value="" />
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<label for="wishlist"><strong>Wishlist</strong> (required)</label>
								</div>
								<div class="col-sm-12">
									<select name="wishlist">
										
										<?php

										$query = $db->prepare("SELECT * FROM wishlists WHERE author = :author");
										$query->execute(array(
											':author' => $user['id']
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
									<textarea name="description"></textarea>
								</div>
								<div class="col-sm-12">
									<label for="notes"><strong>Notes</strong></label>
								</div>
								<div class="col-sm-12">
									<textarea name="notes"></textarea>
								</div>
								<div class="col-sm-12">
									<input class="text" type="submit" name="add_wish" value="Add the wish" />
								</div>
							</div>
						</form>

					</div>

				</div>

			</div>

		</section>

	</section>

	<aside>
		
		<div>qsdf</div>

	</aside>

	<?php require $root . '/_include/foot.php'; ?>
</body>
</html>
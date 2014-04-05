<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Add a wishlist</title>
	<?php require $root . '/_include/head.php'; ?>
</head>
<body class="wishlist add">

	<section class="main">

		<?php require $root . '/_include/user_header.php'; ?>

		<section class="content form">

			<div class="container">

				<div class="row">

					<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

						<h3><strong>Add</strong> a wishlist</h3>
						<form action="add_do.php" method="POST">
							<div class="row">
								<div class="col-sm-12">
									<label for="name"><strong>Name</strong> (required)</label>
								</div>
								<div class="col-sm-12">
									<input type="text" name="name" value="" />
								</div>
								<div class="col-sm-12">
									<label for="description"><strong>Description</strong></label>
								</div>
								<div class="col-sm-12">
									<textarea name="description"></textarea>
								</div>
								<div class="col-sm-12">
									<div class="button">
										<input class="text ready" type="submit" name="add_wishlist" value="Add the wishlist" />
									</div>
								</div>
							</div>
						</form>

					</div>

				</div>

			</div>

		</section>

	</section>

	<?php include $root . '/_include/feed.php'; ?>

	<?php require $root . '/_include/foot.php'; ?>
</body>
</html>
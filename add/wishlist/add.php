<?php

require_once $root . '/add/wishlist/add_do.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Add a wishlist</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body class="wishlist add nojs">

	<section class="main">

		<?php require_once $root . '/_include/user_header.php'; ?>

		<section class="content form">

			<div class="container-fluid">

				<div class="row">

					<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

						<h3>Add a wishlist</h3>
						<form id="add_wishlist" action="/<?php echo $me_username; ?>/wishlist/add" method="POST">

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
									<input type="text" name="name" value="<?php if(isset($wishlist_name)) echo $wishlist_name ?>" required />
								</div>
								<div class="col-sm-12">
									<label for="description"><strong>Description</strong></label>
								</div>
								<div class="col-sm-12">
									<textarea name="description" required><?php if(isset($wishlist_description)) echo $wishlist_description ?></textarea>
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

	<?php require_once $root . '/_include/feed.php'; ?>

	<?php require_once $root . '/_include/foot.php'; ?>
</body>
</html>
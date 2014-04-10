<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $wishlist_name . " | " . $user_name ?></title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body class="wishlist view nojs">

	<section class="main">

		<?php require_once $root . '/_include/wishlist_header.php'; ?>

		<section class="content">

			<div class="container">

				<div class="intro">
					<h2><?php echo $wishlist_name ?><?php if($is_private) echo "<span class='icon entypo lock'></span>"; ?></h2>
					<p class="mute">Created on <?php echo date('F jS, Y', $wishlist_date); ?></p>
					<?php if($me_username == $user_username){ ?>
					<div class="button modal_trigger" data-target="editWishlist">
						<a href="/<?php echo $wishlist_url; ?>/edit">
							<span class="title">Edit</span>
						</a>
					</div>
					<?php } ?>
				</div>

				<?php 

				if(isset($wishlist_access) && $wishlist_access == 0){

					echo "private";

				}else{

				?>

				<ul class="row wishes">

					<?php

					$query = $db->prepare("SELECT * FROM wishes WHERE wishlist = :id ORDER BY id DESC");
					$query->execute(array(
						':id' => $wishlist_id
					));

					if($query->rowCount() > 0){

						if($me_username == $user_username){

					?>

					<li class="col-xs-6 col-sm-4 col-md-3">
						<div class="wish add">
							<div class="cover entypo plus">
								<span class="icon"></span>
							</div>
							<a href="/<?php echo $me_username; ?>/<?php echo $wishlist_slug; ?>/add" class="modal_trigger" data-target="addWish"></a>
						</div>
					</li>

					<?php

						}

						while($wish = $query->fetch(PDO::FETCH_ASSOC)){
							$wishes[] = $wish;
						}

						foreach($wishes as $wish){
							$wish_id = $wish['id'];
							$wish_name = $wish['name'];
							$wish_cover = $wish['cover'];
							$wish_price = $wish['price'];
							$wish_origin = $wish['origin'];
							$wish_url = $user_username . "/" . $wishlist_slug . "/" . $wish_id;

							if(!empty($wish_origin)){
								$wish_origin = str_replace('http://', '', $wish_origin);
								$wish_origin = str_replace('www.', '', $wish_origin);
								$wish_origin = explode('/', $wish_origin);
							}

					?>

					<li class="col-xs-6 col-sm-4 col-md-3">
						<div class="wish">
							<img src="/<?php echo $wish_cover; ?>" />
							<div class="infos">
								<div class="top">
									<h4><?php echo $wish_name; ?></h4>
									<?php
										if(!empty($wish_price)){
									?>

									<p class="price"><?php echo $wish_price; ?></p>
									<?php } ?>
								</div>
								<?php
									if(!empty($wish_origin)){
								?>
								<p class="origin">from <?php echo $wish_origin[0]; ?></p>
								<?php } ?>
							</div>
							<a href="/<?php echo $wish_url ?>"></a>
						</div>
					</li>

					<?php

						}
					
					}else{

					?>

					<div class="col-sm-12">
						Nothin'
					</div>

					<?php } ?>

				</ul>

				<?php } ?>

			</div>

		</section>

	</section>

	<?php require_once $root . '/_include/modal_add_wish.php'; ?>

	<?php require_once $root . '/_include/modal_edit_wishlist.php'; ?>

	<?php require_once $root . '/_include/feed.php'; ?>

	<?php require_once $root . '/_include/foot.php'; ?>
	<script src="/_assets/js/masonry.min.js"></script>
</body>
</html>
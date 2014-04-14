<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $user_name ?></title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body class="user view nojs">

	<section class="main">

		<?php require_once $root . '/_include/user_header.php'; ?>

		<section class="content">

			<div class="container">

				<h3>
					<?php if($me_username == $user_username){ ?>
						Your wishlists
					<?php }else{ ?>
						<?php echo $user_firstname ?>'s wishlists
					<?php } ?>
				</h3>

				<ul class="row wishlists">

					<?php

					if($user_id == $me_id){
						$query = $db->prepare("SELECT * FROM wishlists WHERE author = :id AND removed = :removed");
						$query->execute(array(
							':id' => $user_id,
							':removed' => 0
						));
					}else{
						$query = $db->prepare("SELECT * FROM wishlists WHERE author = :id AND private = :private AND removed = :removed");
						$query->execute(array(
							':id' => $user_id,
							':private' => 0,
							':removed' => 0
						));
					}

					if($me_username == $user_username){

					?>

					<li class="col-xs-6 col-sm-4 col-md-3">
						<div class="wishlist add">
							<div class="cover entypo plus">
								<span class="icon"></span>
							</div>
							<a href="/<?php echo $user_url; ?>/wishlist/add" class="modal_trigger" data-target="addWishlist"></a>
						</div>
					</li>

					<?php

					}

					if($query->rowCount() > 0){

						while($wishlist = $query->fetch(PDO::FETCH_ASSOC)){
							$wishlists[] = $wishlist;
						}

						foreach($wishlists as $wishlist){
							$wishlist_ids[] = $wishlist['id'];
							$wishlist_name = $wishlist['name'];
							$wishlist_slug = $wishlist['slug'];
							$wishlist_id = $wishlist['id'];
							$wishlist_private = $wishlist['private'];
							$wishlist_url = $user_username . "/" . $wishlist_slug;

							$query = $db->prepare("SELECT cover FROM wishes WHERE wishlist = :id AND removed = :removed ORDER BY id ASC LIMIT 1");
							$query->execute(array(
								':id' => $wishlist_id,
								':removed' => 0
							));
							$wish_cover = $query->fetch();

							if($wishlist_private){
								$is_private = 1;
							}else{
								$is_private = 0;
							}

					?>

					<li class="col-xs-6 col-sm-4 col-md-3 <?php if($is_private){ echo 'private'; }else{ echo 'public'; } ?>">
						<div class="wishlist">
							<div class="cover" style="background-image: url(/<?php echo $wish_cover['cover']; ?>);"></div>
							<h4><?php echo $wishlist_name; ?></h4>
							<a href="/<?php echo $wishlist_url; ?>"></a>
							<?php if($is_private){ ?>
							<div class="entypo lock">
								<span class="icon"></span>
								<span class="title">Private</span>
							</div>
							<?php } ?>
							<?php if($me_username == $user_username){ ?>
							<!-- <div class="button edit" data-target="editWishlist">
								<a href="/<?php echo $wishlist_url; ?>/edit">
									<span class="title">Edit</span>
								</a>
							</div> -->
							<?php } ?>
						</div>
					</li>

					<?php

						}
					
					}

					?>

				</ul>

				<hr>

				<h3>
					<?php if($me_username == $user_username){ ?>
						Your latest wishes
					<?php }else{ ?>
						<?php echo $user_firstname ?>'s latest wishes
					<?php } ?>
				</h3>

				<ul class="row wishes">

					<?php

					if(isset($wishlist_ids)){
						$wishlist_ids = join(',', $wishlist_ids);
						$wishlist_ids = "11,7";
						$query = $db->prepare("SELECT * FROM wishes WHERE wishlist IN($wishlist_ids) AND removed = :removed AND author = :author ORDER BY id DESC LIMIT 25");
						$query->execute(array(
							':removed' => 0,
							':author' => $user_id
						));
					}

					if($me_username == $user_username){

					?>

					<li class="col-xs-6 col-sm-4 col-md-3">
						<div class="wish add">
							<div class="cover entypo plus">
								<span class="icon"></span>
							</div>
							<a href="/<?php echo $me_url; ?>/wish/add" class="modal_trigger" data-target="addWish"></a>
						</div>
					</li>

					<?php

					}

					if(isset($wishlist_ids) && $query->rowCount() > 0){

						while($wish = $query->fetch(PDO::FETCH_ASSOC)){
							$wishes[] = $wish;
						}

						foreach($wishes as $wish){
							$wish_id = $wish['id'];
							$wish_name = $wish['name'];
							$wish_wishlist = $wish['wishlist'];
							$wish_cover = $wish['cover'];
							$wish_price = $wish['price'];
							$wish_origin = $wish['origin'];
							$query = $db->prepare("SELECT slug FROM wishlists WHERE id = :id");
							$query->execute(array(
								':id' => $wish_wishlist
							));
							$wishlist_slug = $query->fetch();
							$wishlist_slug = $wishlist_slug['slug'];
							$wish_url = $user_username . "/" . $wishlist_slug . "/" . $wish_id;

							if(!empty($wish_origin)){
								$wish_origin = str_replace('http://', '', $wish_origin);
								$wish_origin = str_replace('www.', '', $wish_origin);
								$wish_origin = str_replace('?', '', $wish_origin);
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
					
					}

					?>

				</ul>

			</div>

		</section>

	</section>

	<?php require_once $root . '/_include/modal_add_wish.php'; ?>

	<?php require_once $root . '/_include/modal_add_wishlist.php'; ?>

	<?php require_once $root . '/_include/modal_edit_wishlist.php'; ?>

	<?php require_once $root . '/_include/feed.php'; ?>

	<?php require_once $root . '/_include/foot.php'; ?>
	<script src="/_assets/js/masonry.min.js"></script>
</body>
</html>
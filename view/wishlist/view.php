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

			<div class="container-fluid">

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

					$query = $db->prepare("SELECT * FROM wishes WHERE wishlist = :id AND removed = :removed ORDER BY id DESC");
					$query->execute(array(
						':id' => $wishlist_id,
						':removed' => 0
					));

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

					}else{

					?>

					<div class="col-sm-12">
						Nothin'
					</div>

					<?php

					}

					if($query->rowCount() > 0){

						while($temp_wish = $query->fetch(PDO::FETCH_ASSOC)){
							$temp_wishes[] = $temp_wish;
						}

						foreach($temp_wishes as $temp_wish){
							$temp_wish_id = $temp_wish['id'];
							$temp_wish_name = $temp_wish['name'];
							$temp_wish_cover = $temp_wish['cover'];
							$temp_wish_price = $temp_wish['price'];
							$temp_wish_origin = $temp_wish['origin'];
							$temp_wish_url = $user_username . "/" . $wishlist_slug . "/" . $temp_wish_id;

							if(!empty($temp_wish_origin)){
								$temp_wish_origin = str_replace('http://', '', $temp_wish_origin);
								$temp_wish_origin = str_replace('www.', '', $temp_wish_origin);
								$temp_wish_origin = explode('/', $temp_wish_origin);
							}

					?>

					<li class="col-xs-6 col-sm-4 col-md-3">
						<div class="wish">
							<img src="/<?php echo $temp_wish_cover; ?>" />
							<div class="infos">
								<div class="top">
									<h4><?php echo $temp_wish_name; ?></h4>
									<?php
										if(!empty($temp_wish_price)){
									?>

									<p class="price"><?php echo $temp_wish_price; ?></p>
									<?php } ?>
								</div>
								<?php
									if(!empty($temp_wish_origin)){
								?>
								<p class="origin">from <?php echo $temp_wish_origin[0]; ?></p>
								<?php } ?>
							</div>
							<a href="/<?php echo $temp_wish_url ?>"></a>
						</div>
					</li>

					<?php 

						}

					}

					?>

				</ul>

				<?php 

				}

				?>

			</div>

		</section>

		<?php require_once $root . '/_include/footer.php'; ?>

	</section>

	<?php require_once $root . '/_include/modal_add_wish.php'; ?>

	<?php require_once $root . '/_include/modal_edit_wishlist.php'; ?>

	<?php require_once $root . '/_include/feed.php'; ?>
	
	<?php require_once $root . '/_include/foot.php'; ?>
	<script src="/_assets/js/masonry.min.js"></script>
	<script src="/_assets/js/imagesloaded.min.js"></script>

</body>
</html>
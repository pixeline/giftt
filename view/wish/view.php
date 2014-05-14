<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $current_wish['name'] . " | " . $user_name; ?></title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>

<?php require_once $root . '/view/wish/view_do.php'; ?>

<body class="wish view nojs <?php if($me['feed'] == 1){ echo "withAside"; } ?>">

	<section class="main">

		<?php require_once $root . '/_include/wish_header.php'; ?>

		<section class="content container-fluid">

			<!-- WISH -->
			<section class="col-sm-9 heart">
				<div class="row current_wish">
					<div class="col-sm-8 col-sm-offset-4">
						<h3><?php echo $current_wish['name']; ?></h3>
						
						<?php if(isset($current_wish['price'])){ ?>
						<p class="price"><?php echo $current_wish['price']; ?></p>
						<?php } ?>
					</div>

					<div class="col-sm-4">
						<?php if(isset($current_wish['origin'])){ ?>
						<a href="<?php echo $current_wish['origin']; ?>" target="_blank">
							<img src="/<?php echo $current_wish['picture']; ?>" alt="<?php echo $current_wish['name']; ?>" />
						</a>
						<?php }else{ ?>
						<img src="/<?php echo $current_wish['picture']; ?>" />
						<?php } ?>
					</div>

					<div class="col-sm-8">
						
						<?php if(isset($current_wish['description'])){ ?>
						<p class="description"><?php echo $current_wish['description']; ?></p>
							<?php if(isset($current_wish['origin'])){ ?>
							<span class="description_more"><a href="<?php echo $current_wish['origin']; ?>" target="_blank">more information...</a></span>
							<?php } ?>
						<?php } ?>
					</div>
				</div>

				<?php if(isset($prev_wish) || isset($next_wish)){ ?>

				<!-- <div class="row wish_related">
					<div class="col-sm-12">
						<h4><?php echo $user['firstname']; ?> also wishes...</h4>
					</div>
					<ul class="wishes">
						<?php 
							foreach($wishes as $wish){
								$wishlist_index = searchForId($wish['wishlist'], $wishlists);
								$wish_url = $user['username'] . '/' . $wishlists[$wishlist_index]['slug'] . '/' . $wish['id'];
						?>
						<li class="col-sm-3">
							<div class="wish">
								<a href="/<?php echo $wish_url; ?>">
									<img src="/<?php echo $wish['picture']; ?>" alt="<?php echo $wish['name']; ?>" />
								</a>
							</div>
						</li>
						<?php } ?>
					</ul>
				</div> -->

				<div class="wish_navigation row">
					<div class="prev col-sm-6">
						<p>
							<a href="<?php echo $prev_wish['url']; ?>"><?php echo $prev_wish['name']; ?></a>
						</p>
					</div>
					<div class="next col-sm-6">
						<p>
							<a href="<?php echo $next_wish['url']; ?>"><?php echo $next_wish['name']; ?></a>
						</p>
					</div>
				</div>

				<?php } ?>
			</section>

			<!-- SIDEBAR -->
			<aside class="col-sm-3">
				<div class="pod information">
					<header>
						<h4>Information</h4>
					</header>

					<div class="cont">
						<p class="date"><?php echo date('F jS, Y', $current_wish_date); ?></p>
						<p class="author">By <a href="/<?php echo $user['username']; ?>"><?php echo $user_name; ?></a></p>
						<p class="wishlist">In <a href="/<?php echo $user['username'] . '/' . $current_wishlist['slug']; ?>"><?php echo $current_wishlist['name']; ?></a></p>
						<?php if(isset($current_wish['origin'])){ ?>
							<p class="origin">From <a href="<?php echo $current_wish['origin']; ?>" target="_blank"><?php echo shortUrl($current_wish['origin']); ?></a></p>
						<?php } ?>
					</div>
				</div>

				<div class="pod actions">
					<header>
						<h4>Actions</h4>
					</header>

					<div class="cont">
						<p><a class="green" href="#"><span href="#" class="icon icon-plus"></span>Wish it too</a></p>
						<p><a href="#"><span href="#" class="icon icon-share"></span>Share</a></p>
					</div>
				</div>

			</aside>

		</section>

		<?php require_once $root . '/_include/footer.php'; ?>

	</section>

	<?php require_once $root . '/_include/feed.php'; ?>

	<?php require_once $root . '/_include/foot.php'; ?>

</body>
</html>
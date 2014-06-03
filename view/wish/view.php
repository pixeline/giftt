<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $current_wish['name'] . " | " . $user_name . ' | Giftt'; ?></title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>

<?php require_once 'view_do.php'; ?>

<body class="wish view nojs">

	<section class="main">

		<?php require_once $root . '/_include/wish_header.php'; ?>

		<section class="content container-fluid">

			<!-- WISH -->
			<section class="col-sm-9 heart">
				<div class="row current_wish">
					<div class="title col-sm-8 col-sm-offset-4">
						<h3><?php echo $current_wish['name']; ?></h3>
						
						<?php if(!empty($current_wish['price'])){ ?>
						<p class="price"><?php if($current_wish['currency'] == "$"){ echo '$'; } echo $current_wish['price']; if($current_wish['currency'] != "$"){ echo $current_wish['currency']; } ?></p>
						<?php } ?>
					</div>

					<div class="picture col-sm-4">
						<?php if(!empty($current_wish['origin'])){ ?>
						<a href="<?php echo $current_wish['origin']; ?>" target="_blank">
							<img src="/<?php echo $current_wish['picture']; ?>" alt="<?php echo $current_wish['name']; ?>" />
						</a>
						<?php }else{ ?>
						<img src="/<?php echo $current_wish['picture']; ?>" />
						<?php } ?>
					</div>

					<div class="col-sm-8">
						
						<?php if(!empty($current_wish['description'])){ ?>
						<p class="description"><?php echo nl2br(rtrim(ltrim(htmlspecialchars_decode($current_wish['description'])))); ?></p>
							<?php if(!empty($current_wish['origin'])){ ?>
						<p class="description_more"><a href="<?php echo $current_wish['origin']; ?>" target="_blank">more information...</a></p>
							<?php } ?>
						<?php }else{ ?>
							<p class="mute">No description available...</p>
						<?php } ?>
					</div>
				</div>
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
						<?php if(!empty($current_wish['origin'])){ ?>
							<p class="origin">From <a href="<?php echo $current_wish['origin']; ?>" target="_blank"><?php echo shortUrl($current_wish['origin']); ?></a></p>
						<?php } ?>
					</div>
				</div>

				<div class="pod actions">
					<header>
						<h4>Actions</h4>
					</header>

					<div class="cont">
						<?php if($mine){ ?>
						<p class="edit"><a class="icon_cont" href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>/edit"><span class="icon icon-edit"></span>Edit wish</a></p>
						<p class="remove"><a class="icon_cont" href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>/remove"><span class="icon icon-close"></span>Remove wish</a></p>
						<?php }else{ ?>
						<p class="add"><a class="icon_cont green" href="#"><span class="icon icon-plus"></span>Wish it too</a></p>
						<?php } ?>
						<?php if(!$is_private){ ?>
						<p class="share"><a class="icon_cont" href="#"><span class="icon icon-share"></span>Share</a></p>
						<?php } ?>
					</div>
				</div>

			</aside>

			<?php if($prev_wish || $next_wish){ ?>

			<!-- NAVIGATION -->
			<div class="wish_navigation col-sm-6 col-sm-offset-3">
				<div class="row">
					<?php 
						if($prev_wish){
							$wishlist_index = searchForId($prev_wish['wishlist'], $wishlists);
							$prev_wish_url = $user['username'] . '/' . $wishlists[$wishlist_index]['slug'] . '/' . $prev_wish['id'];
					?>
					<div class="prev col-sm-6">
						<p>
							<?php $prev_wish_name = strlen($prev_wish['name']) > 25 ? substr($prev_wish['name'],0,25)."..." : $prev_wish['name']; ?>
							<a href="/<?php echo $prev_wish_url; ?>"><?php echo $prev_wish_name; ?></a>
						</p>
					</div>
					<?php 
						}
						
						if($next_wish){
							$wishlist_index = searchForId($next_wish['wishlist'], $wishlists);
							$next_wish_url = $user['username'] . '/' . $wishlists[$wishlist_index]['slug'] . '/' . $next_wish['id'];
					?>
					<div class="next col-sm-6">
						<p>
							<?php $next_wish_name = strlen($next_wish['name']) > 25 ? substr($next_wish['name'],0,25)."..." : $next_wish['name']; ?>
							<a href="/<?php echo $next_wish_url; ?>"><?php echo $next_wish_name; ?></a>
						</p>
					</div>
					<?php } ?>
				</div>
			</div>

			<?php } ?>

		</section>

		<?php require_once $root . '/_include/footer.php'; ?>

	</section>

	<?php require_once $root . '/_include/feed.php'; ?>

	<?php require_once $root . '/_include/foot.php'; ?>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $current_wishlist_name . " | " . $user_name ?></title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>

<?php require_once $root . '/view/wishlist/view_do.php'; ?>

<body class="wishlist view nojs <?php if($me_feed == 1){ echo "withAside"; } ?>">

	<section class="main">

		<?php require_once $root . '/_include/user_header.php'; ?>

		<section class="content">
			<div class="container-fluid">

				<!-- SIDEBAR -->
				<aside class="col-sm-3">
					<div class="pod wishlists">
						<header>
							<h4>Wishlists</h4>
							<?php if($profile){ ?>
								<a href="#" class="icon icon-plus"></a>
							<?php } ?>
						</header>

						<?php

							if($query_wishlists->rowCount() > 0){

						?>

						<ul>
							<li class="all"><a href="/<?php echo $user_username; ?>">All<span><?php echo count($wishes); ?></span></a></li>

							<?php
								$wishlists = array();
								$current_wishes = array();
								while($wishlist = $query_wishlists->fetch(PDO::FETCH_ASSOC)){
									$wishlists[] = $wishlist;

									$wishlist_id = $wishlist['id'];
									$wishlist_name = $wishlist['name'];
									$wishlist_slug = $wishlist['slug'];
									$wishlist_private = $wishlist['private'];
									$wishlist_url = $user_username . "/" . $wishlist_slug;

									$active_wishlist = 0;
									if($wishlist_id == $current_wishlist_id){
										$active_wishlist = 1;
									}

									$wish_count = 0;
									foreach($wishes as $wish){
										if(in_array($wishlist_id, $wish)){
											$wish_count++;
											if($active_wishlist){
												$current_wishes[] = $wish;
											}
										}
									}
							?>

							<li <?php if($active_wishlist){ echo "class='active'"; } ?>><a href="/<?php echo $wishlist_url; ?>"><?php echo $wishlist_name; ?><span><?php echo $wish_count; ?></span></a></li>

							<?php } ?>

						</ul>

						<?php } ?>
					</div>

					<div class="pod collapse following">
						<header>
							<h4>Following</h4>
							<span><?php if($followings){ echo count($followings); }else{ echo "0"; } ?></span>
						</header>

						<div class="wrapper">
							<ul>
								<?php 
									if(isset($followings)){
										foreach($followings as $following){
											$following_username = $following['username'];
											$following_name = $following['firstname'] . ' ' . $following['lastname'];
											if(isset($following['picture'])){
												$following_picture = $following['picture'];
											}else{
												$following_picture = '_assets/images/profile/default.jpg';
											}
								?>
								<li><a href="/<?php echo $following_username; ?>"><img src="<?php echo $following_picture; ?>" alt="<?php echo $follower_name; ?>" /></a></li>
								<?php
											
										}
									}else{
								?>
								<li>Nobody</li>
								<?php } ?>
							</ul>
						</div>
					</div>

					<div class="pod collapse followers">
						<header>
							<h4>Followers</h4>
							<span><?php if($followers){ echo count($followers); }else{ echo "0"; } ?></span>
						</header>
						<div class="wrapper">
							
							<ul>
								<?php 
									if(isset($followers)){
										foreach($followers as $follower){
											$follower_username = $follower['username'];
											$follower_name = $follower['firstname'] . ' ' . $follower['lastname'];
											if(isset($follower['picture'])){
												$follower_picture = $follower['picture'];
											}else{
												$follower_picture = '_assets/images/profile/default.jpg';
											}
								?>
								<li><a href="/<?php echo $follower_username; ?>"><img src="<?php echo $follower_picture; ?>" alt="<?php echo $follower_name; ?>" /></a></li>
								<?php
											
										}
									}else{
								?>
								<li>Nobody</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</aside>

				<!-- WISHES -->
				<section class="col-sm-9 mosaic">
					<div class="action row">
						<p class="col-sm-12">
							<?php
								if($profile){
							?>
							<a class="green" href="#">Make a wish<span href="#" class="icon icon-plus"></span></a>
							<?php
								}else{
									if(in_array($user_id, $me_followings_id)){
							?>
							<a href="#">Unfollow <?php echo $user_firstname; ?><span href="#" class="icon icon-minus"></span></a>
							<?php
									}else{
							?>
							<a class="green" href="#">Follow <?php echo $user_firstname; ?><span href="#" class="icon icon-plus"></span></a>
							<?php
									}
								}
							?>
						</p>
					</div>
					<div class="row wishes">
						<ul>
							<?php
								if(count($current_wishes) > 0){
									foreach($current_wishes as $wish){
										$wish_id = $wish['id'];
										$wish_name = $wish['name'];
										$wish_picture = $wish['picture'];
										$wish_origin = $wish['origin'];
										if(!empty($wish_origin)){
											$wish_short_origin = str_replace('http://', '', $wish_origin);
											$wish_short_origin = str_replace('www.', '', $wish_short_origin);
											$wish_short_origin = explode('/', $wish_short_origin);
											$wish_short_origin = $wish_short_origin[0];
										}
										$wishlist_index = searchForId($wish['wishlist'], $wishlists);

										$wish_url = $user_username . '/' . $wishlists[$wishlist_index]['slug'] . '/' . $wish_id;
							?>

							<li class="col-xs-6 col-md-4 col-lg-3">
								<div class="wish">
									<a href="/<?php echo $wish_url; ?>">
										<img src="/<?php echo $wish_picture; ?>" />
									</a>
									<div class="infos">
										<h3><a href="/<?php echo $wish_url; ?>"><?php echo $wish_name; ?></a></h3>
										<p class="origin"><a href="<?php echo $wish_origin; ?>"><?php echo $wish_short_origin; ?></a></p>
									</div>
								</div>
							</li>

							<?php
									}
								}else{
									echo "nothing";
								}
							?>
						</ul>
					</div>
				</section>
			</div>
		</section>

		<?php require_once $root . '/_include/footer.php'; ?>

	</section>

	<?php require_once $root . '/_include/feed.php'; ?>
	<?php require_once $root . '/_include/foot.php'; ?>
	<script src="/_assets/js/masonry.min.js"></script>
	<script src="/_assets/js/imagesloaded.min.js"></script>

</body>
</html>
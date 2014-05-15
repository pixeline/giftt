<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>
		<?php 
			if(isset($get_wishlist)){
				echo $current_wishlist['name'] . " | ";
			}
			echo $user_name; 
		?>
	</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>

<?php require_once 'view_do.php'; ?>

<body class="wishlist view nojs <?php if($me['feed'] == 1){ echo "withAside"; } ?>">

	<section class="main">

		<?php require_once $root . '/_include/wishlist_header.php'; ?>

		<section class="content container-fluid">

			<!-- SIDEBAR -->
			<aside class="col-sm-3">
				<div class="pod wishlists">
					<header>
						<h4>Wishlists</h4>
						<?php if($mine){ ?>
							<a href="#" class="icon icon-plus" data-target="add_wishlist"></a>
						<?php } ?>
					</header>

					<ul>
						<li class="all wishlist<?php if(!isset($get_wishlist)){ echo " active"; }?>">
							<a href="/<?php echo $user['username']; ?>">All
								<span><?php echo count($wishes); ?></span>
							</a>
						</li>

						<?php if($mine){ ?>

						<li class="add">
							<form action="/wishlist/add" method="POST">
								<input type="text" id="name" name="name" placeholder="Name" />
								<div class="private_checkbox">
									<input type="checkbox" id="private" name="private" />
									<label for="private" class="icon-lock" title="Make this wishlist secret"></label>
								</div>
							</form>
						</li>

						<?php
							}

							if(isset($wishlists[0])){

								$current_wishes = array();
								foreach($wishlists as $wishlist){
									$wishlist_url = $user['username'] . "/" . $wishlist['slug'];
									$active_wishlist = 0;
									if(isset($current_wishlist['id'])){
										if($wishlist['id'] == $current_wishlist['id']){
											$active_wishlist = 1;
										}
									}
									$wish_count = 0;
									foreach($wishes as $wish){
										if(in_array($wishlist['id'], $wish)){
											$wish_count++;
											if($active_wishlist){
												$current_wishes[] = $wish;
											}
										}
									}

						?>

						<li class="wishlist<?php if($active_wishlist){ echo " active"; } ?>">
							<a href="/<?php echo $wishlist_url; ?>"><?php echo $wishlist['name']; ?>
								<span><?php echo $wish_count; ?></span>
							</a>
						</li>

						<?php 
								}
							}
						?>

					</ul>

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
										$following_name = $following['firstname'] . ' ' . $following['lastname'];
										if(!isset($following['picture'])){
											$following['picture'] = '_assets/images/profile/default.jpg';
										}
							?>
							<li><a href="/<?php echo $following['username']; ?>"><img src="/<?php echo $following['picture']; ?>" alt="<?php echo $following_name; ?>" /></a></li>
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
										$follower_name = $follower['firstname'] . ' ' . $follower['lastname'];
										if(!isset($follower['picture'])){
											$follower['picture'] = '_assets/images/profile/default.jpg';
										}
							?>
							<li><a href="/<?php echo $follower['username']; ?>"><img src="/<?php echo $follower['picture']; ?>" alt="<?php echo $follower_name; ?>" /></a></li>
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
			<section class="col-sm-9 heart">
				<div class="action row">
					<p class="col-sm-12">
						<?php
							if($mine){
						?>
						<a class="icon_cont green" href="/<?php echo $user['username'] . '/'; if(isset($current_wishlist['slug'])){ echo $current_wishlist['slug'] . '/'; } ?>add">Make a wish<span href="#" class="icon icon-plus"></span></a>
						<?php
							}else{
								if(in_array($user['id'], $me_followings_id)){
						?>
						<a class="follow" href="#" data-who="<?php echo $user['id']; ?>">Unfollow <?php echo $user['firstname']; ?><span href="#" class="icon icon-minus"></span></a>
						<?php
								}else{
						?>
						<a class="green follow" href="#" data-who="<?php echo $user['id']; ?>">Follow <?php echo $user['firstname']; ?><span href="#" class="icon icon-plus"></span></a>
						<?php
								}
							}
						?>
					</p>
				</div>
				<div class="row wishes">
					<ul>
						<?php
							if(isset($get_wishlist)){
								$wishes = $current_wishes;
							}
							if(count($wishes) > 0){
								foreach($wishes as $wish){
									if(!empty($wish['origin'])){
										$wish_short_origin = shortUrl($wish['origin']);
									}
									$wishlist_index = searchForId($wish['wishlist'], $wishlists);
									$wish_url = $user['username'] . '/' . $wishlists[$wishlist_index]['slug'] . '/' . $wish['id'];
						?>

						<li class="col-xs-6 col-md-4 col-lg-3">
							<div class="wish">
								<a href="/<?php echo $wish_url; ?>">
									<img src="/<?php echo $wish['picture']; ?>" />
								</a>
								<div class="infos">
									<h3><a href="/<?php echo $wish_url; ?>"><?php echo $wish['name']; ?></a></h3>
									<?php if(!empty($wish['origin'])){ ?>
									<p class="origin"><a href="<?php echo $wish['origin']; ?>" target="_blank"><?php echo $wish_short_origin; ?></a></p>
									<?php } ?>
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

		</section>

		<?php require_once $root . '/_include/footer.php'; ?>

	</section>

	<?php require_once $root . '/_include/feed.php'; ?>
	<?php require_once $root . '/_include/foot.php'; ?>
	<script src="/_assets/js/masonry.min.js"></script>
	<script src="/_assets/js/imagesloaded.min.js"></script>

</body>
</html>
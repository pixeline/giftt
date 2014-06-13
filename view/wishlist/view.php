<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>
		<?php
			if(isset($get_wishlist)){
				echo $current_wishlist['name'] . " | ";
			}
			echo $user_name . ' | Giftt';
		?>
	</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>

<?php require_once 'view_do.php'; ?>

<body class="wishlist view nojs">

	<section class="main">

		<?php require_once $root . '/_include/wishlist_header.php'; ?>

		<section class="content container-fluid">

			<!-- SELECT FOR MOBILE -->
			<div class="select">
				<select onchange="location = this.options[this.selectedIndex].value;">
					<option value="/<?php echo $user['username']; ?>">All wishlists</option>
					<?php
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
									if($wishlist['id'] == $wish['wishlist']){
										$wish_count++;
										if($active_wishlist){
											$current_wishes[] = $wish;
										}
									}
								}
					?>
					<option value="/<?php echo $user['username'] . '/' . $wishlist['slug']; ?>"<?php if($active_wishlist){ echo " selected"; } ?>><?php echo $wishlist['name']; if($wishlist['private']){ echo " (private)"; } ?></option>
					<?php
							}
						}
					?>
				</select>
			</div>

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
								<span class="number"><?php echo count($wishes); ?></span>
							</a>
						</li>

						<?php if($mine){ ?>

						<li class="add">
							<form action="/wishlist/add" method="POST">
								<input type="submit" class="hidden" />
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
										if($wishlist['id'] == $wish['wishlist']){
											$wish_count++;
											if($active_wishlist){
												$current_wishes[] = $wish;
											}
										}
									}

						?>

						<li class="wishlist<?php if($active_wishlist){ echo " active"; } if($mine){ echo " mine"; } if($wishlist['private']){ echo " private"; } ?>">
							<a href="/<?php echo $wishlist_url; ?>">
								<?php
									if($wishlist['private']){
								?>
								<span class="icon icon-lock"></span>
								<?php
									}

									$wishlist_name = strlen($wishlist['name']) > 22 ? substr($wishlist['name'],0,22)."..." : $wishlist['name'];
									echo $wishlist_name;
								?>
								<span class="number"><?php echo $wish_count; ?></span>
							</a>
							<a class="icon icon-edit" href="/<?php echo $wishlist_url; ?>/edit"></a>
						</li>

						<?php
									if($mine){
						?>

						<li class="edit">
							<form action="/<?php echo $wishlist_url; ?>/edit" method="POST">
								<input type="submit" class="hidden" />
								<input type="text" id="name" name="name" placeholder="Name" value="<?php echo $wishlist['name']; ?>" />
								<div class="private_checkbox">
									<input type="checkbox" id="private_<?php echo $wishlist['id']; ?>" name="private" <?php if($wishlist['private']){ echo "checked"; } ?>/>
									<label for="private_<?php echo $wishlist['id']; ?>" class="icon-lock<?php if($wishlist['private']){ echo " active"; } ?>" title="Make this wishlist secret"></label>
								</div>
								<a href="/<?php echo $wishlist_url; ?>/remove" class="remove icon icon-close"></a>
							</form>
						</li>

						<?php
									}
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
								if(isset($followings[0])){
									foreach($followings as $following){
										$following_name = $following['firstname'] . ' ' . $following['lastname'];
										if(!isset($following['picture']) || empty($following['picture'])){
											$following['picture'] = '_assets/images/profile/default.jpg';
										}
							?>
							<li>
								<a href="/<?php echo $following['username']; ?>">
									<div class="img-crop">
										<img src="/<?php echo $following['picture']; ?>" alt="<?php echo $following_name; ?>" />
									</div>
								</a>
							</li>
							<?php
										
									}
								}else{
							?>
							<li class="nobody">You're not following anybody</li>
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
								if(isset($followers[0])){
									foreach($followers as $follower){
										$follower_name = $follower['firstname'] . ' ' . $follower['lastname'];
										if(!isset($follower['picture']) || empty($follower['picture'])){
											$follower['picture'] = '_assets/images/profile/default.jpg';
										}
							?>
							<li>
								<a href="/<?php echo $follower['username']; ?>">
									<div class="img-crop">
										<img src="/<?php echo $follower['picture']; ?>" alt="<?php echo $follower_name; ?>" />
									</div>
								</a>
							</li>
							<?php
										
									}
								}else{
							?>
							<li class="nobody">Nobody follows you yet</li>
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
						<a class="icon_cont green" href="/<?php echo $user['username'] . '/'; if(isset($current_wishlist['slug'])){ echo $current_wishlist['slug'] . '/'; } ?>add">Add a wish<span href="#" class="icon icon-plus"></span></a>
						<?php
							}else{
								if(in_array($user['id'], $me_followings_id)){
						?>
						<a class="icon_cont follow" href="/follow/<?php echo $user['id']; ?>">Unfollow <?php echo $user['firstname']; ?><span href="#" class="icon icon-minus"></span></a>
						<?php
								}else{
						?>
						<a class="icon_cont green follow" href="/follow/<?php echo $user['id']; ?>">Follow <?php echo $user['firstname']; ?><span href="#" class="icon icon-plus"></span></a>
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

								if($mine){ ?>
						<a class="nothing col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3" href="/<?php echo $user['username'] . '/'; if(isset($current_wishlist['slug'])){ echo $current_wishlist['slug'] . '/'; } ?>add">
							You haven't added any wish<?php if(isset($current_wishlist['slug'])){ echo ' in ' . $current_wishlist['name']; } ?> yet.<br /><span>Make your first wish now</span>
						</a>
						<?php 	}else{ ?>
						<div class="nothing col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3" href="/<?php echo $user['username'] . '/'; if(isset($current_wishlist['slug'])){ echo $current_wishlist['slug'] . '/'; } ?>add">
							<?php echo $user['firstname']; ?> hasn't added any wish<?php if(isset($current_wishlist['slug'])){ echo ' in ' . $current_wishlist['name']; } ?> yet.
						</div>
						<?php
								}
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
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<?php $current_wish_name = strlen($current_wish['name']) > 40 ? substr($current_wish['name'],0,40)."..." : $current_wish['name']; ?>
	<title><?php echo $current_wish_name . " | " . $user_name . ' | Giftt'; ?></title>
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
						<?php if($is_shotgun && !$mine){ ?>
						<p class="shotgun">(<?php if($current_shotgun_author == $me['id']){ echo "you are secretly "; }else{ echo "someone is already " ; } ?>offering <?php echo $user['firstname']; ?> this gift)</p>
						<?php } ?>
					</div>

					<div class="picture col-sm-4">
						<?php if(!empty($current_wish['origin'])){ ?>
						<a href="<?php echo $current_wish['origin']; ?>" target="_blank">
							<img src="/<?php echo $current_wish['picture']; ?>" alt="<?php echo $current_wish['name']; ?>" />
							<p>view on <?php echo shortUrl($current_wish['origin']); ?></p>
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
				<?php if(isset($me)){ ?>
				<div class="pod actions">
					<header>
						<h4>Actions</h4>
					</header>

					<div class="cont">
						<?php $current_wish_url = $user['username'] . '/' . $current_wishlist['slug'] . '/' . $current_wish['id']; ?>
						<?php if($mine){ ?>
						<p class="edit"><a class="icon_cont" href="/<?php echo $current_wish_url; ?>/edit"><span class="icon icon-edit"></span>Edit wish</a></p>
						<p class="remove"><a class="icon_cont" href="/<?php echo $current_wish_url; ?>/remove"><span class="icon icon-close"></span>Remove wish</a></p>
						<?php }else{ ?>
						<p class="add"><a class="icon_cont green" href="#"><span class="icon icon-plus"></span>Wish it too</a></p>
							<?php if(!$is_shotgun){ ?>
						<p class="shotgun"><a class="icon_cont" href="/<?php echo $user['username'] . '/' . $current_wishlist['slug'] . '/' . $current_wish['id'] ?>/shotgun"><span class="icon icon-flag"></span>Offering it ?</a></p>
							<?php }else if($current_shotgun_author == $me['id']){ ?>
						<p class="shotgun unshotgun"><a class="icon_cont" href="/<?php echo $user['username'] . '/' . $current_wishlist['slug'] . '/' . $current_wish['id'] ?>/shotgun"><span class="icon icon-flag"></span>Not offering it ?</a></p>
							<?php } ?>
						<?php } ?>
						<?php if(!$is_private){ ?>
						<p class="share"><a class="icon_cont" href="#"><span class="icon icon-share"></span>Share</a></p>
						<div class="share_box">
							<ul>
								<li class="twitter">
									<a href="https://twitter.com/share?
										url=https%3A%2F%2Fgiftt.me%2F<?php echo $current_wish_url; ?>
										&text=<?php echo $current_wish_name . ' on Giftt'; ?>
										&lang=en_US
										&hashtags=wishes
									" target="_blank" class="icon-twitter"><span>Twitter</span></a>
								</li>
								<li class="facebook">
									<a href="#" class="icon-facebook" onclick="sharefb();"><span>Facebook</span></a>
								</li>
								<li class="google">
									<a href="https://plus.google.com/share?url=<?php echo "'https://" . $_SERVER['HTTP_HOST'] . "/" . $current_wish_url . "'"; ?>" target="_blank" class="icon-google"><span>Google+</span></a>
								</li>
								<li class="mail">
									<a href="<?php echo "mailto:?subject=I'm sharing a wish with you&body=Hi! %0D%0A%0D%0AI'd like you to take a look at this wish: https://" . $_SERVER['HTTP_HOST'] . "/" . $current_wish_url; ?>" class="icon-mail"><span>Email</span></a>
								</li>
							</ul>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>

			</aside>

			<?php if(($prev_wish || $next_wish) && isset($me)){ ?>

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

	<script>
		window.fbAsyncInit = function(){
			FB.init({
				appId: '736942236328874',
				status: true,
				cookie: true,
				xfbml: true,
				version: 'v2.0'
			});
		};

		function sharefb(){
			FB.ui(
				{
					method: 'feed',
					name: <?php echo "'" . $og_title . "'"; ?>,
					picture: <?php echo "'" . $og_picture . "'"; ?>,
					link: <?php echo "'https://" . $_SERVER['HTTP_HOST'] . "/" . $current_wish_url . "'"; ?>,
					caption: <?php echo "'A wish by " . $user_name . "'"; ?>,
					description: (<?php echo "'" . $og_description . "'"; ?>),
					message: 'Facebook Dialogs are easy!'
				}
			);
		}

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
    </script>
    <div id="fb-root"></div>

</body>
</html>
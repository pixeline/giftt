<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $wish_name . " | " . $user_name ?></title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body class="wish view nojs">

	<section class="main">

		<?php require_once $root . '/_include/wish_header.php'; ?>

		<section class="content">

			<div class="container">
				<div class="intro">
					<h2><?php echo $wish_name ?></h2>
					<p class="mute">Added on <?php echo date('F jS, Y', $wish_date); ?></p>
					<?php if($me_username == $user_username){ ?>
					<div class="button modal_trigger" data-target="editWish">
						<a href="/<?php echo $wish_url; ?>/edit">
							<span class="title">Edit</span>
						</a>
					</div>
					<?php }else{ ?>
					<div class="button modal_trigger" data-target="addWish">
						<a href="#">
							<span class="title">I want it too</span>
						</a>
					</div>
					<?php } ?>
				</div>

				<div class="row details">
					<div class="col-md-10 col-md-offset-1">
						<div class="row">
							<div class="col-sm-4">
								<div class="photo">
									<a href="<?php echo $wish_origin; ?>" target="_blank">
										<img src="/<?php echo $wish_cover; ?>" />
									</a>
									<a href="<?php echo $wish_origin; ?>" target="_blank" class="price"><?php echo $wish_price; ?></a>
								</div>
							</div>

							<div class="col-sm-8">
								<div class="description">
									<h5>Description</h5>
									<p><?php echo $wish_description; ?></p>
								</div>
								<?php if(!empty($wish_notes)){ ?>
								<div class="notes">
									<h5><?php echo $user_firstname; ?> also wants you to know...</h5>
									<p><?php echo $wish_notes; ?></p>
								</div>
								<?php } ?>
								<div class="share">
									<div class="facebook">
										<div class="fb-share-button" data-href="<?php echo $wish_url; ?>" data-type="button"></div>
									</div>
									<div class="twitter">
										<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-dnt="true">Tweet</a>
									</div>
									<div class="google">
										<div class="g-plusone" data-size="medium" data-annotation="none"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php

			$query = $db->prepare("SELECT * FROM wishes WHERE wishlist = :id ORDER BY RAND() DESC LIMIT 4");
			$query->execute(array(
				':id' => $wishlist_id
			));

			while($sibling = $query->fetch(PDO::FETCH_ASSOC)){
				$siblings[] = $sibling;
			}

			if(count($siblings) > 0){

			?>

			<div class="siblings">
				<div class="container">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="row">
								<div class="col-sm-12">
									<h4>Also in <?php echo $user_firstname; ?>'s <a href="/<?php echo $wishlist_url; ?>"><?php echo $wishlist_name; ?></a> wishlist</h4>
								</div>
							</div>

							<div class="row">

								<?php

								foreach($siblings as $sibling){
									$sibling_id = $sibling['id'];
									$sibling_name = $sibling['name'];
									$sibling_cover = $sibling['cover'];
									$sibling_price = $sibling['price'];
									$sibling_origin = $sibling['origin'];
									$sibling_url = $user_username . "/" . $wishlist_slug . "/" . $sibling_id;

									if($wish_id != $sibling_id){

								?>

								<div class="col-sm-3">
									<div class="wish">
										<img src="/<?php echo $sibling_cover; ?>" />
										<div class="infos">
											<div class="top">
												<h5><?php echo $sibling_name; ?></h5>
												<?php
													if(!empty($sibling_price)){
												?>
												<p class="price"><?php echo $sibling_price; ?></p>
												<?php } ?>
											</div>
										</div>
										<a href="/<?php echo $sibling_url ?>"></a>
									</div>
								</div>

								<?php

									}

								}

								?>

							</div>
						</div>
					</div>
				</div>
			</div>

			<?php 

			}

			?>

		</section>

		<?php require_once $root . '/_include/footer.php'; ?>

	</section>

	<?php require_once $root . '/_include/modal_add_wish.php'; ?>

	<?php require_once $root . '/_include/modal_edit_wish.php'; ?>

	<?php require_once $root . '/_include/feed.php'; ?>

	<?php require_once $root . '/_include/foot.php'; ?>
	<!-- SHARE -->
	<div id="fb-root"></div>
	<script>
		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>

	<script>
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
	</script>

	<script type="text/javascript">
		(function(){
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/platform.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		})();
	</script>

	<script type="text/javascript">
		//analytics
	</script>
</body>
</html>
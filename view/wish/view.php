<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $wish_name . " | " . $user_name ?></title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body class="wish view nojs <?php if($me_feed == 1){ echo "withAside"; } ?>">

	<section class="main">

		<?php require_once $root . '/_include/wish_header.php'; ?>

		<section class="content">

			<form id="edit_wish" action="/<?php echo $wish_url; ?>/edit" method="POST" enctype="multipart/form-data">

				<div class="container-fluid">
					<div class="intro">
						<h2 class="hide_edit"><?php echo $wish_name ?></h2>
						<input id="name" class="show_edit" type="text" name="name" value="<?php if(isset($wish_name)) echo $wish_name; ?>" required />
						<p class="mute">Added 
							<span class="hide_edit"> on <?php echo date('F jS, Y', $wish_date); ?></span>
							<span class="show_edit"> in 
								<select id="wishlist" name="wishlist" required>
									<option>Choose a wishlist</option>
											
									<?php

									$query = $db->prepare("SELECT * FROM wishlists WHERE author = :author AND removed = :removed");
									$query->execute(array(
										':author' => $me['id'],
										':removed' => 0
									));

									$wishlists = array();
									while($wishlist = $query->fetch(PDO::FETCH_ASSOC)){
										$wishlists[] = $wishlist;
									}

									foreach($wishlists as $wishlist){
										$name = $wishlist['name'];
										$id = $wishlist['id'];

									?>

									<option value="<?php echo $id; ?>" <?php if($name == $wishlist_name) echo "selected"; ?>><?php echo $name; ?></option>

									<?php

										}

									?>

								</select>
							</span>
						</p>
						<?php if($me_username == $user_username){ ?>
						<div class="button">
							<a class="hide_edit" href="/<?php echo $wish_url; ?>/edit">
								<span class="title">Edit</span>
							</a>
							<button class="show_edit" type="submit" name="edit_wish">Save</button>
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
										<a id="link" class="file_cont" href="<?php echo $wish_origin; ?>" target="_blank">
											<img src="/<?php echo $wish_cover; ?>" />
										</a>
										<a href="<?php echo $wish_origin; ?>" target="_blank" class="price hide_edit"><?php echo $wish_price; ?></a>
										<input id="price" class="show_edit" type="text" name="price" value="<?php if(isset($wish_price)) echo $wish_price; ?>" />
										<input id="image" class="hidden" type="file" name="image" required />
									</div>
									<input id="origin" class="show_edit" type="url" name="origin" value="<?php if(isset($wish_origin)) echo $wish_origin; ?>" placeholder="http://" required />
								</div>

								<div class="col-sm-8">
									<div class="description">
										<h5>Description</h5>
										<p class="hide_edit"><?php echo $wish_description; ?></p>
										<textarea id="description" class="show_edit" name="description" required><?php if(isset($wish_description)) echo $wish_description; ?></textarea>
									</div>
									<div class="notes show_edit" <?php if(!empty($wish_notes)){ ?>style="display: block !important;"<?php } ?>>
										<h5><?php echo $user_firstname; ?> also wants you to know...</h5>
										<p class="hide_edit"><?php echo $wish_notes; ?></p>
										<textarea id="notes" class="show_edit" name="notes"><?php if(isset($wish_notes)) echo $wish_notes; ?></textarea>
									</div>
									<div class="share hide_edit">
										<div class="facebook">
											<div class="fb-share-button" data-href="/<?php echo $wish_url; ?>" data-type="button"></div>
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

			</form>

			<?php

			$query = $db->prepare("SELECT * FROM wishes WHERE wishlist = :id AND removed = :removed ORDER BY RAND() DESC LIMIT 4");
			$query->execute(array(
				':id' => $wishlist_id,
				':removed' => 0
			));

			while($sibling = $query->fetch(PDO::FETCH_ASSOC)){
				$siblings[] = $sibling;
			}

			if(count($siblings) > 1){ // 1 = the currently viewed one

			?>

			<div class="siblings">
				<div class="container-fluid">
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
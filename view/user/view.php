<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $user_name ?></title>
	<?php require $root . '/_include/head.php'; ?>
</head>
<body class="user view">

	<section class="main">

		<?php require $root . '/_include/user_header.php'; ?>

		<section class="content">

			<div class="container">

				<h3>
					<?php if($me_username == $user_username){ ?>
						Your wishlists
					<?php }else{ ?>
						<?php echo $user_firstname ?>'s wishlists
					<?php } ?>
				</h3>

				<?php if($me_username == $user_username){ ?>
				<div class="menu">
					<ul>
						<li id="public" class="active">Public wishlists</li>
						<li id="private">Private wishlists</li>
					</ul>
				</div>
				<?php } ?>

				<ul class="row wishlists">

					<?php

					if($user_id == $me_id){
						$query = $db->prepare("SELECT * FROM wishlists WHERE author = :id");
						$query->execute(array(
							':id' => $user_id
						));
					}else{
						$query = $db->prepare("SELECT * FROM wishlists WHERE author = :id AND private = 0");
						$query->execute(array(
							':id' => $user_id
						));
					}

					if($query->rowCount() > 0){

						if($me_username == $user_username){

					?>

					<li class="col-xs-6 col-sm-4 col-md-3">
						<div class="add">
							<div class="cover entypo plus">
								<span class="icon"></span>
							</div>
							<a href="/<?php echo $user_url; ?>/wishlist/add"></a>
						</div>
					</li>

					<?php

						}

						while($wishlist = $query->fetch(PDO::FETCH_ASSOC)){
							$wishlists[] = $wishlist;
						}

						foreach($wishlists as $wishlist){
							$wishlist_name = $wishlist['name'];
							$wishlist_slug = $wishlist['slug'];
							$wishlist_id = $wishlist['id'];
							$wishlist_private = $wishlist['private'];
							$wishlist_url = $user_username . "/" . $wishlist_slug;

							$query = $db->prepare("SELECT cover FROM wishes WHERE wishlist = :id ORDER BY id ASC LIMIT 1");
							$query->execute(array(
								':id' => $wishlist_id
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
							<div class="button">
								<a href="/<?php echo $wishlist_url; ?>/edit">
									<span class="title">Edit</span>
								</a>
							</div>
							<?php } ?>
						</div>
					</li>

					<?php

						}
					
					}else{

					?>

					<div class="col-sm-12">
						Nothin'
					</div>

					<?php

					}

					?>

				</ul>

			</div>

		</section>

	</section>

	<?php include $root . '/_include/feed.php'; ?>

	<?php require $root . '/_include/foot.php'; ?>
</body>
</html>
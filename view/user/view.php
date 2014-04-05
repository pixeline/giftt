<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $name ?></title>
	<?php require $root . '/_include/head.php'; ?>
</head>
<body class="user view">

	<section class="main">

		<?php require $root . '/_include/user_header.php'; ?>

		<section class="content">

			<div class="container">

				<h3>Your wishlists</h3>

				<div class="menu">
					<ul>
						<li id="public" class="active">Public wishlists</li>
						<li id="private">Private wishlists</li>
					</ul>
				</div>

				<ul class="row wishlists">

					<?php

					$query = $db->prepare("SELECT * FROM wishlists WHERE author = :id");
					$query->execute(array(
						':id' => $id
					));

					if($query->rowCount() > 0){

					?>

					<li class="col-xs-6 col-sm-4 col-md-3">
						<div class="add">
							<div class="cover entypo plus">
								<span class="icon"></span>
							</div>
							<a href="/<?php echo $username; ?>/wishlist/add"></a>
						</div>
					</li>

					<?php

						while($wishlist = $query->fetch(PDO::FETCH_ASSOC)){
							$wishlists[] = $wishlist;
						}

						foreach($wishlists as $wishlist){
							$name = $wishlist['name'];
							$slug = $wishlist['slug'];
							$id = $wishlist['id'];
							$private = $wishlist['private'];

							if($private){
								$is_private = 'private';
							}else{
								$is_private = 'public';
							}

					?>

					<li class="col-xs-6 col-sm-4 col-md-3 <?php echo $is_private; ?>">
						<div class="wishlist">
							<div class="cover" style="background-image: url(/_assets/images/birthday.jpg);"></div>
							<h4><?php echo $name ?></h4>
							<a href="/<?php echo $page_user_username ?>/<?php echo strtolower($slug) ?>"></a>
							<div class="button">
								<a href="/<?php echo $page_user_username ?>/<?php echo strtolower($slug) ?>/edit">
									<span class="title">Edit</span>
								</a>
							</div>
						</div>
					</li>


					<!-- <li class="col-xs-6 col-sm-4 col-md-3 private">
						<div class="wishlist">
							<div class="cover" data-img="/_assets/images/clothes.jpg"></div>
							<h4>Birthday 2014</h4>
							<div class="entypo lock">
								<span class="icon"></span>
								<span class="title">Private</span>
							</div>

							<a href="#"></a>
							<div class="button">
								<a href="#">
									<span class="title">Edit</span>
								</a>
							</div>
						</div>
					</li> -->

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

	<aside>
		
		<div>qsdf</div>

	</aside>

	<?php require $root . '/_include/foot.php'; ?>
</body>
</html>
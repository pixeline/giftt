<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $wishlist['name'] . " | " . $wishlist_author_name ?></title>
	<?php require $root . '/_include/head.php'; ?>
</head>
<body class="wishlist view">

	<section class="main">

		<?php require $root . '/_include/wishlist_header.php'; ?>

		<section class="content">

			<div class="container">

				<div class="intro">
					<h2><?php echo $wishlist_name ?></h2>
					<?php if(!empty($wishlist_description)) echo "<p>" . $wishlist_description . "</p>"; ?>
					<div class="button edit">
						<a href="#">
							<span class="title">Edit</span>
						</a>
					</div>
				</div>

				<ul class="row">

					<?php

					$query = $db->prepare("SELECT * FROM wishes WHERE wishlist = :id");
					$query->execute(array(
						':id' => $wishlist['id']
					));

					if($query->rowCount() > 0){

					?>

					<li class="col-xs-6 col-sm-4 col-md-3">
						<div class="wishlist add">
							<div class="cover entypo plus">
								<span class="icon"></span>
							</div>
							<a href="/<?php echo $username; ?>/<?php echo $wishlist_slug; ?>/add"></a>
						</div>
					</li>

					<?php

						while($wishlist = $query->fetch(PDO::FETCH_ASSOC)){
							$wishlists[] = $wishlist;
						}

						foreach($wishlists as $wishlist){
							$name = $wishlist['name'];
							$id = $wishlist['id'];

					?>

					<li class="col-xs-6 col-sm-4 col-md-3">
						<div class="wishlist">
							<div class="cover" data-img="/_assets/images/birthday.jpg"></div>
							<a href="/<?php echo $page_user_username ?>/<?php echo $wishlist_slug; ?>/<?php echo strtolower($id) ?>"></a>
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

	<aside>
		
		<div>qsdf</div>

	</aside>

	<?php require $root . '/_include/foot.php'; ?>
</body>
</html>
<?php

$user = $_SESSION['user'];

$id = $user['id'];
$firstname = $user['firstname'];
$lastname = $user['lastname'];
$likes = $user['likes'];

$name = $firstname . ' ' . $lastname;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Add a wishlist</title>
	<?php require $root . '/_include/head.php'; ?>
</head>
<body id="add_wishlist" class="wishlist">

	<header>

		<div class="container">

			<div id="logo">
				<!-- <img src="/_assets/images/logo.png" alt="Titre du site" /> -->
				<a href="/"><span class="wait_logo"></span></a>
			</div>

			<nav>
				<div class="button">
					<a href="#">
						<span class="title">Activity</span>
						<span class="number">2</span>
					</a>
				</div>
			</nav>

			<div id="tools">
				<ul>
					<li class="button">
						<a href="#" class="entypo search">
							<span class="icon"></span>
							<span class="title">Search</span>
						</a>
					</li>
					<li class="button">
						<a href="#" class="entypo cog disconnect">
							<span class="icon"></span>
							<span class="title">Settings</span>
						</a>
					</li>
				</ul>
			</div>

		</div>

	</header>

	<section class="subheader">

		<div class="container">

			<div class="heading">
				<img src="/_assets/images/profile.jpg" alt="John Smith" />
				<div class="infos">
					<h2><?php echo $name ?></h2>
					<p>You like</p>
					<ul class="tags">

						<?php

						$likes2 = explode(";", $likes);

						foreach($likes2 as $like){
							echo "<li><a href='/tags/" . $like . "'>" . $like . "</a></li>";
						}

						?>

						<!-- <li><a href="/tags">minimalism</a></li>
						<li><a href="/tags">design</a></li>
						<li><a href="/tags">wood</a></li>
						<li><a href="/tags">mugs</a></li>
						<li><a href="/tags">technology</a></li> -->
					</ul>
				</div>
			</div>

			<div class="actions">
				<!-- <div class="button">
					<a href="#">
						<span class="title">Follow</span>
						<span class="number">25</span>
					</a>
				</div> -->
				<div class="button">
					<a href="#">
						<span class="title">Edit profile</span>
					</a>
				</div>
				<div class="button">
					<a href="#" class="entypo user">
						<span class="number">25</span>
					</a>
				</div>
			</div>

		</div>

	</section>

	<section class="content form">

		<div class="container">

			<div class="row">

				<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

					<h3><strong>Add</strong> a wishlist</h3>
					<form action="add_do.php" method="POST">
						<div class="row">
							<div class="col-sm-12">
								<label for="name"><strong>Name</strong> (required)</label>
							</div>
							<div class="col-sm-12">
								<input type="text" name="name" value="" />
							</div>
							<div class="col-sm-12">
								<label for="description"><strong>Description</strong></label>
							</div>
							<div class="col-sm-12">
								<textarea name="description"></textarea>
							</div>
							<div class="col-sm-12">
								<div class="button">
									<input class="text ready" type="submit" name="add_wishlist" value="Add the wishlist" />
								</div>
							</div>
						</div>
					</form>

				</div>

			</div>

		</div>

	</section>

	<?php require $root . '/_include/foot.php'; ?>
</body>
</html>
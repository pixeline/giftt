<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Discover Giftt</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body id="landing">

	<header>
		<div class="container">
			<div class="row">
				<div class="col-sm-6 logo">
					<a href="/"><img src="/_assets/images/logo_square.png" alt="Giftt" /></a>
				</div>
				<div class="col-sm-6 actions">
					<a class="register button" href="/register">Join Giftt</a>
					<a class="login button" href="/login">Log in</a>
				</div>
			</div>
		</div>
	</header>

	<section id="content">
		<div class="container intro">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<h2>Amazing slogan about wishlists</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam augue ipsum, pellentesque nec pretium eu, elementum quis nibh. Aenean dictum sapien nulla.</p>
				</div>
				<a class="register button" href="/register">Create your first wishlist</a>
			</div>
		</div>

		<img class="cover" src="/_assets/images/landing/cover.jpg" alt="Discover Giftt" />

		<div class="container features">
			<div class="row">
				<div class="col-sm-12">
					<h3>Giftt.me a reason...</h3>
				</div>
				<ul>
					<li class="col-xs-12 col-sm-4">
						<img src="/_assets/images/landing/feature1.jpg" alt="Make wishes, share wishes" />
						<h4>Make wishes, share wishes</h4>
						<p>Create wishlists for you, your friends, your family, and <strong>share them instantly</strong> with everyone that matters.</p>
					</li>

					<li class="col-xs-12 col-sm-4">
						<img src="/_assets/images/landing/feature2.jpg" alt="Keep your wishlists safe" />
						<h4>Keep your wishlists safe</h4>
						<p>Browse the Internet for gift ideas and keep them safe in a <strong>private wishlist</strong>. You can be sure nobody but you will see this wishlist.</p>
					</li>

					<li class="col-xs-12 col-sm-4">
						<img src="/_assets/images/landing/feature3.jpg" alt="Browser extension" />
						<h4>Browser extension</h4>
						<p>With the <strong>Giftt browser extension</strong>, saving gift ideas into one of your Giftt wishlists only takes a second.</p>
					</li>
				</ul>
			</div>
			
			<a class="register button" href="/register">Create your first wishlist</a>
		</div>
	</section>

	<footer class="container">
		<ul class="row">
			<li class="col-xs-6">
				<p>© 2014, <a href="/">Giftt.me</a> | <a href="#">Terms</a></p>
			</li>
			<li class="col-xs-6">
				<p><a href="#">Email us</a> | <a href="http://twitter.com/gifttme" target="_blank">Tweet us</a></p>
			</li>
		</ul>
	</footer>

	<?php require_once $root . '/_include/foot.php'; ?>
</body>
</html>
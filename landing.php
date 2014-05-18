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
					<a href="/"><img src="/_assets/images/logo.png" alt="Giftt" /></a>
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
					<h2>Make wishes, share wishlists</h2>
					<p>With Giftt, be sure to remember every gift idea you have, whether it's for you or a friend. <br />Add wishes, manage wishlists and share them with friends, all in a single place.</p>
				</div>
				<a class="register button" href="/register">Create your first wishlist</a>
			</div>
		</div>

		<img class="cover" src="/_assets/images/landing/cover.jpg" alt="Discover Giftt" />

		<div class="container features">
			<div class="row">
				<div class="col-sm-12">
					<h3>This makes Giftt unique</h3>
				</div>
				<ul>
					<li class="col-xs-12 col-sm-4">
						<img src="/_assets/images/landing/feature1.jpg" alt="Share your wishlists" />
						<h4>Share your wishlists</h4>
						<p>Create wishlists for you, your friends and your family, and <strong>share them instantly</strong> with everyone that matters.</p>
					</li>

					<li class="col-xs-12 col-sm-4">
						<img src="/_assets/images/landing/feature1.jpg" alt="Keep your wishlists safe" />
						<h4>Keep your wishlists safe</h4>
						<p>Browse the Internet for gift ideas and keep them safe in a <strong>private wishlist</strong>. You can be sure you alone will see this wishlist.</p>
					</li>

					<li class="col-xs-12 col-sm-4">
						<img src="/_assets/images/landing/feature1.jpg" alt="Browser extension" />
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
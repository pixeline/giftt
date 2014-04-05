<header>

	<?php require $root . '/_include/menu.php'; ?>

	<div class="container">
		
		<a href="/<?php echo $username; ?>"><img src="/_assets/images/profile.jpg" alt="John Smith" /></a>
		<h2><?php echo $name ?></h2>
		<p><?php echo $description ?></p>
		<div class="button">
			<a href="#">
				<span class="title">25 followers</span>
			</a>
		</div>
		
		<div class="button edit">
			<a href="#">
				<span class="title">Edit</span>
			</a>
		</div>
		
	</div>

</header>
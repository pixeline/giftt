<header>

	<?php require_once $root . '/_include/menu.php'; ?>

	<div class="container-fluid">
		
		<a class="user" href="/<?php echo $user['username']; ?>">
			<div class="img-crop">
				<img src="/<?php echo $user['picture']; ?>" alt="<?php echo $user_name; ?>" />
			</div>
		</a>

	</div>

</header>
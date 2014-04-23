<header>

	<?php require_once $root . '/_include/menu.php'; ?>

	<div class="container-fluid">
		
		<a class="user" href="/<?php echo $user_url ?>"><img src="<?php if(isset($user_picture)){ echo "/" . $user_picture; }else{ echo '/_assets/images/profile.jpg';} ?>" alt="<?php echo $user_name; ?>" /></a>

	</div>

</header>
<header>

	<?php require_once $root . '/_include/menu.php'; ?>

	<div class="container-fluid">
		
		<a class="user" href="/<?php echo $user_username; ?>"><img src="/<?php if(isset($user_picture)){ echo $user_picture; }else{ echo '_assets/images/profile/default.jpg';} ?>" alt="<?php echo $user_name; ?>" /></a>
		<h3><a href="/<?php echo $wishlist_url; ?>"><?php echo $wishlist_name; ?></a></h3>

	</div>

</header>
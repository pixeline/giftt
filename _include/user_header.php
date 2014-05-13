<header>

	<?php require_once $root . '/_include/menu.php'; ?>

	<div class="container-fluid">
		
		<a class="user" href="/<?php echo $user_url; ?>"><img src="/<?php if(!empty($user_picture)){ echo $user_picture; }else{ echo '_assets/images/profile/default.jpg';} ?>" alt="<?php echo $user_name; ?>" /></a>
		<h2><?php echo $user_name; ?></h2>
		<?php if(!empty($user_description)){ ?>
			<p class="description"><?php echo $user_description; ?></p>
		<?php } ?>
		
	</div>

</header>
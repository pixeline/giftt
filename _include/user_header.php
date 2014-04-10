<header>

	<?php require_once $root . '/_include/menu.php'; ?>

	<div class="container">
		
		<a class="user" href="/<?php echo $user_url; ?>"><img src="/_assets/images/profile.jpg" alt="<?php echo $user_name; ?>" /></a>
		<h2><?php echo $user_name; ?></h2>
		<p><?php echo $user_description; ?></p>
		<?php if($me_username == $user_username){ ?>
		<div class="button follow">
			<a href="#">
				<span class="title">25 followers</span>
			</a>
		</div>
		<?php }else{ ?>	
		<div class="button follow">
			<a href="#" data-who2="1">
				<span class="title">Follow</span>
				<span class="number">25</span>
			</a>
		</div>
		<?php } ?>
		<?php if($me_username == $user_username){ ?>
		<div class="button edit">
			<a href="/<?php echo $me_url; ?>/settings">
				<span class="title">Settings</span>
			</a>
		</div>
		<?php } ?>
		
	</div>

</header>
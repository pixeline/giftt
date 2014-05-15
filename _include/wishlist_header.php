<header>

	<?php require_once $root . '/_include/menu.php'; ?>

	<div class="container-fluid">
		
		<a class="user" href="/<?php echo $user['username']; ?>"><img src="/<?php if(!empty($user['picture'])){ echo $user['picture']; }else{ echo '_assets/images/profile/default.jpg';} ?>" alt="<?php echo $user_name; ?>" /></a>
		<h2><?php echo $user_name; ?></h2>
		<?php if(!empty($user['description'])){ ?>
			<p class="description"><?php echo $user['description']; ?></p>
		<?php } ?>
		<?php if($mine){ ?>
			<a class="settings" href="#">Edit my profile</a>
		<?php } ?>

	</div>

</header>
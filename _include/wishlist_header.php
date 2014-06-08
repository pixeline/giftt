<header>

	<?php require_once $root . '/_include/menu.php'; ?>

	<div class="container-fluid">
		
		<a class="user" href="/<?php echo $user['username']; ?>"><img src="/<?php echo $user['picture']; ?>" alt="<?php echo $user_name; ?>" /></a>
		<h2><?php echo $user_name; ?></h2>
		<?php if(!empty($user['description'])){ ?>
			<p class="description"><?php echo $user['description']; ?></p>
		<?php } ?>
		<?php if($mine){ ?>
			<a class="settings" href="/settings"><span>Settings</span></a><a class="logout" href="/logout">Logout</a>
		<?php } ?>

	</div>

</header>
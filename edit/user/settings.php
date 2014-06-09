<?php require_once 'settings_do.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Settings | Giftt</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>

<body class="settings nojs">

	<section class="main">

		<header>

			<?php require_once $root . '/_include/menu.php'; ?>

		</header>

		<section class="content container-fluid">

			<div class="row">
				<div class="col-sm-12">
					<h2>Settings</h2>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">

					<h3>Edit your information</h3>
					<p>These info <strong>(except your email)</strong> will appear on your profile.</p>

					<form class="default" action="/settings" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-4 image">
								<label for="image"><strong>Photo</strong></label>
								<div class="file_cont<?php if(isset($message['image'])){ echo ' error'; } ?>">
									<img src="/<?php echo $me['picture']; ?>" alt="<?php if(isset($me['name'])) echo $me['name']; ?>" <?php if(empty($me['picture'])) echo "style='display: none;'"; ?> />
									<span class="icon-picture" <?php if(!empty($me['picture'])) echo "style='display: none;'"; ?>></span>
									<input <?php if(isset($message['image'])){ echo 'class="error"'; } ?>id="image" type="file" name="image" />
									<p class="error"><?php if(isset($message['image'])){ echo $message['image']; } ?></p>
								</div>
							</div>
							<div class="col-sm-8">
								<label for="firstname">First name</label>
								<input class="first<?php if(isset($message['firstname'])){ echo ' error'; } ?>" type="text" name="firstname" autocorrect="off" autocapitalize="on" spellcheck="false" placeholder="First name" value="<?php echo $me['firstname']; ?>" required />
								<p class="error"><?php if(isset($message['firstname'])){ echo $message['firstname']; } ?></p>
								<label for="lastname">Last name</label>
								<input <?php if(isset($message['lastname'])){ echo 'class="error"'; } ?> type="text" name="lastname" autocorrect="off" autocapitalize="on" spellcheck="false" placeholder="Last name" value="<?php echo $me['lastname']; ?>" required />
								<p class="error"><?php if(isset($message['lastname'])){ echo $message['lastname']; } ?></p>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<label for="email">Email</label>
								<input <?php if(isset($message['email'])){ echo 'class="error"'; } ?> type="email" name="email" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Email address" value="<?php echo $me['email']; ?>" required />
								<p class="error"><?php if(isset($message['email'])){ echo $message['email']; } ?></p>
								<label for="email">Description</label>
								<textarea id="description" name="description" placeholder="A short description of yourself" ><?php if(isset($me['description'])) echo $me['description']; ?></textarea>
								<p class="error"><?php if(isset($message['email'])){ echo $message['email']; } ?></p>

								<input type="submit" name="edit_profile" value="Save profile" />
							</div>
						</div>
					</form>



					<h3>Change your password</h3>
					<p><strong>Use only if you want to change your password</strong>. <br />Leave empty otherwise.</p>

					<form class="default" action="/settings" method="POST">

						<div class="row">
							<div class="col-sm-12">
								<label for="password">New password</label>
								<input class="first<?php if(isset($message['password'])){ echo ' error'; } ?>" type="password" name="password" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="New password" value="" />
								<p class="error"><?php if(isset($message['password'])){ echo $message['password']; } ?></p>

								<input type="submit" name="new_password" value="Save new password" />
							</div>
						</div>
					</form>

					<p class="deactivate"><a href="/remove" onclick="if(!confirm('Are you sure you want to remove your Giftt account? There is no way back...')) return false;">Remove your account?</a></p>

				</div>
			</div>

		</section>

		<?php require_once $root . '/_include/footer.php'; ?>

	</section>

	<?php require_once $root . '/_include/feed.php'; ?>
	<?php require_once $root . '/_include/foot.php'; ?>

</body>
</html>
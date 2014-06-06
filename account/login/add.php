<?php

require_once 'add_do.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Log into Giftt</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body id="login">

	<header>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 logo">
					<a href="/"><img src="/_assets/images/logo.png" alt="Giftt" /></a>
				</div>
			</div>
		</div>
	</header>

	<section class="content">

		<div class="container-fluid">

			<div class="row">
				<div class="col-sm-12">
					<h2>Log into your Giftt account</h2>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

					<a class="facebook" href="/login/facebook"><span class="text">Log in with <strong>Facebook</strong></span></a>

					<p class="sep"><span>or</span></p>

					<form class="default" action="/login" method="POST">
						<label for="email">Email</label>
						<input class="first<?php if(isset($message['email'])){ echo ' error'; } ?>" type="email" name="email" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Email address" value="<?php if(isset($email)){ echo $email; } ?>" />
						<p class="error"><?php if(isset($message['email'])){ echo $message['email']; } ?></p>
						<label for="password">Password</label>
						<input <?php if(isset($message['password'])){ echo 'class="error"'; } ?> type="password" name="password" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Password" value="" />
						<p class="error"><?php if(isset($message['password'])){ echo $message['password']; } echo '. <a href="/reset/index.php'; if(isset($email) && !empty($email)){ echo "?email=" . $email; } echo '">Did you forget your password?</a>'; ?></p>

						<input type="submit" name="login" value="Log in" />
					</form>

					<p class="change"><a href="/register">Not registered yet?</a></p>

				</div>
			</div>

		</div>

	</section>

	<?php require_once $root . '/_include/footer.php'; ?>

	<?php 

	if(isset($_GET['nofacebook'])){
		echo "<script>alert('We've never heard of your Facebook account. Please register with it first.')</script>";
	}

	?>

</body>
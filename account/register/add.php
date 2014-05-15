<?php

require_once 'add_do.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Join Giftt</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body id="register">

	<section class="main">

		<?php require_once $root . '/_include/account_header.php'; ?>

		<section class="content">

			<div class="container-fluid">

				<div class="row">
					<div class="col-sm-12">
						<h2>Join the Giftt community <small>...it's free</small></h2>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

						<a class="facebook" href="/register/facebook"><span class="text">Register with <strong>Facebook</strong></span></a>

						<p class="sep"><span>or</span></p>

						<form class="default" action="/register" method="POST">
							<label for="firstname">First name</label>
							<input class="first<?php if(isset($message['firstname'])){ echo ' error'; } ?>" type="text" name="firstname" autocorrect="off" autocapitalize="on" spellcheck="false" placeholder="First name" value="<?php if(isset($firstname)){ echo $firstname; } ?>" />
							<p class="error"><?php if(isset($message['firstname'])){ echo $message['firstname']; } ?></p>
							<label for="lastname">Last name</label>
							<input <?php if(isset($message['lastname'])){ echo 'class="error"'; } ?> type="text" name="lastname" autocorrect="off" autocapitalize="on" spellcheck="false" placeholder="Last name" value="<?php if(isset($lastname)){ echo $lastname; } ?>" />
							<p class="error"><?php if(isset($message['lastname'])){ echo $message['lastname']; } ?></p>
							<label for="email">Email</label>
							<input <?php if(isset($message['email'])){ echo 'class="error"'; } ?> type="email" name="email" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Email address" value="<?php if(isset($email)){ echo $email; } ?>" />
							<p class="error"><?php if(isset($message['email'])){ echo $message['email']; } ?></p>
							<label for="password">Password</label>
							<input <?php if(isset($message['password'])){ echo 'class="error"'; } ?> type="password" name="password" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Password" value="" />
							<p class="error"><?php if(isset($message['password'])){ echo $message['password']; } ?></p>

							<input type="submit" name="register" value="Register" />
						</form>

						<p class="change"><a href="/login">Already registered?</a></p>

					</div>
				</div>

			</div>

		</section>

		<?php require_once $root . '/_include/footer.php'; ?>

	</section>

</body>
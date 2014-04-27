<?php

require_once 'reset_do.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Forgot your Giftt password</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body id="login">

	<section class="main">

		<?php require_once $root . '/_include/account_header.php'; ?>

		<section class="content">

			<div class="container-fluid">

				<div class="row">
					<div class="col-sm-12">
						<h2>Did you forget your Gifft password?</h2>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

						<?php
							if(isset($_GET['email'])){
								$email = $_GET['email'];
							}
						?>

						<form action="/login/reset" method="POST">
							<p class="intro">We'll send you an email with all the information you need to reset your password.</p>
							<label for="email">Email</label>
							<input <?php if(isset($message['email'])){ echo 'class="error"'; } ?> type="email" name="email" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Email address" value="<?php if(isset($email)){ echo $email; } ?>" />
							<p class="error"><?php if(isset($message['email'])){ echo $message['email']; } ?></p>

							<input type="submit" name="reset" value="Reset my password" />
						</form>

						<p class="change"><a href="/register">Not registered yet?</a></p>

					</div>
				</div>

			</div>

		</section>

		<?php require_once $root . '/_include/footer.php'; ?>

	</section>

	<?php 

	if(isset($_GET['nofacebook'])){
		echo "<script>alert('Sorry, your Facebook account is not registered on Giftt')</script>";
	}

	?>

</body>
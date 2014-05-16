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
<body id="login" class="reset">

	<section class="main">

		<?php require_once $root . '/_include/account_header.php'; ?>

		<section class="content">

			<div class="container-fluid">

				<?php 
					// SI DEPUIS UN EMAIL
					if(isset($_GET['email']) && isset($_GET['token'])){
						$email = $_GET['email'];
						$token = $_GET['token'];
						$hashed_token = crypt($email, '$2x$12$' . $token);

						$query = $db->prepare("SELECT reset FROM users WHERE email = :email");
						$query->execute(array(
							':email' => $email
						));
						$results = $query->fetchAll();
						
						$reset = $results[0]['reset'];
						$hashed_reset = crypt($email, '$2x$12$' . $reset);

						// SI TOKEN CORRECT
						if($hashed_token == $hashed_reset){
				?>

				<div class="row">
					<div class="col-sm-12">
						<h2 style="margin-bottom: 40px;">Choose a new password</h2>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

						<form action="#" method="POST">
							<label for="password">Password</label>
							<input <?php if(isset($message['password'])){ echo 'class="error"'; } ?> type="password" name="password" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Password" value="" />
							<p class="error"><?php if(isset($message['password'])){ echo $message['password']; } ?></p>

							<input type="submit" name="newpass" value="Save my new password" />
						</form>

				<?php
						// SI TOKEN INCORRECT
						}else{
				?>

				<div class="row">
					<div class="col-sm-12">
						<h2>Did you forget your Gifft password?</h2>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

						<p style="text-align: center; padding: 0 6px; margin-top: 50px;">The link you've followed is incorrect<br /><a href="/reset">Ask for a new one</a></p>

				<?php
						}

					// SI PAS ENCORE ENVOYE EMAIL
					}else{
	
						if(isset($_GET['email'])){
							$email = $_GET['email'];
						}
				?>

				<div class="row">
					<div class="col-sm-12">
						<h2>Did you forget your Gifft password?</h2>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
						
						<?php
							if(isset($sent) && $sent == 1){
						?>
						<p class="intro">An email was just sent to <?php echo $email ?>.</p>
						
						<?php
							}else{

						?>

						<p class="intro">We'll send you an email with all the information you need to reset your password.</p>
						<form class="default" action="/reset" method="POST">
							<label for="email">Email</label>
							<input <?php if(isset($message['email'])){ echo 'class="error"'; } ?> type="email" name="email" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Email address" value="<?php if(isset($email)){ echo $email; } ?>" />
							<p class="error"><?php if(isset($message['email'])){ echo $message['email']; } ?></p>

							<input type="submit" name="reset" value="Reset my password" />
						</form>

						<p class="change"><a href="/register">Not registered yet?</a></p>
						<?php } ?>

				<?php } ?>

					</div>
				</div>

			</div>

		</section>

		<?php require_once $root . '/_include/footer.php'; ?>

	</section>

</body>
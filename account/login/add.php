<?php

require_once 'add_do.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Login</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body id="login">

	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-6">

				<?php
					if(isset($message[0])){
						echo $message[0];
					}
				?>

				<form action="/login" method="POST">
					<label for="email">Email</label>
					<input type="text" name="email" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" value="<?php if(isset($email)){ echo $email; } ?>" />
					<label for="password">Password</label>
					<input type="password" name="password" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" value="" />

					<input type="submit" name="login" value="Submit" />
				</form>

				<a href="/login/facebook" style="margin-top: 50px;">Facebook</a>

			</div>

		</div>

	</div>

</body>
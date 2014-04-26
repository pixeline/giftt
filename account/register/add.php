<?php

require_once 'add_do.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Register</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body id="register">

	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-6">

				<?php
					if(isset($message[0])){
						echo $message[0];
					}
				?>

				<form action="/register" method="POST">
					<label for="firstname">First name</label>
					<input type="text" name="firstname" autocorrect="off" autocapitalize="on" spellcheck="false" value="<?php if(isset($firstname)){ echo $firstname; } ?>" />
					<label for="lastname">Last name</label>
					<input type="text" name="lastname" autocorrect="off" autocapitalize="on" spellcheck="false" value="<?php if(isset($lastname)){ echo $lastname; } ?>" />
					<label for="email">Email</label>
					<input type="email" name="email" autocorrect="off" autocapitalize="on" spellcheck="false" value="<?php if(isset($email)){ echo $email; } ?>" />
					<label for="password">Password</label>
					<input type="password" name="password" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" value="" />

					<input type="submit" name="register" value="Submit" />
				</form>

				<a href="/register/facebook" style="margin-top: 50px;">Facebook</a>

			</div>

		</div>

	</div>

</body>
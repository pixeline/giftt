<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Register</title>
	<?php require $root . '/_include/head.php'; ?>
</head>
<body id="register_login">

	<div class="container">

		<div class="row">

			<div class="col-sm-6 register">
				<h1>Register</h1>
				<form action="<?php $root ?>/_include/register.php" method="POST">
					<label for="username">Username</label>
					<input type="text" name="username" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" value="" />
					<label for="password">Password</label>
					<input type="password" name="password" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" value="final" />
					<label for="password2">Password again</label>
					<input type="password" name="password2" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" value="final" />
					<label for="firstname">First name</label>
					<input type="text" name="firstname" autocorrect="off" autocapitalize="on" spellcheck="false" value="Pierre" />
					<label for="lastname">Last name</label>
					<input type="text" name="lastname" autocorrect="off" autocapitalize="on" spellcheck="false" value="Stoffe" />
					<label for="email">Email</label>
					<input type="email" name="email" autocorrect="off" autocapitalize="on" spellcheck="false" value="pierre.stoffe@gmail.com" />

					<input type="submit" name="register" value="Submit" />
				</form>
			</div>

			<div class="col-sm-6 login">
				<h1>Login</h1>
				<form action="<?php $root ?>/_include/login.php" method="POST">
					<label for="username">Username</label>
					<input type="text" name="username" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" value="pierrestoffe" />
					<label for="password">Password</label>
					<input type="password" name="password" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" value="final" />

					<input type="submit" name="login" value="Submit" />
				</form>
			</div>

		</div>
	</div>

	<?php require $root . '/_include/foot.php'; ?>
</body>
</html>
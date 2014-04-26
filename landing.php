<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Discover Giftt</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body id="landing">

	<div class="container-fluid">

		<div class="row">
		
			<?php if(strstr($_SERVER["HTTP_HOST"], "tfe.dev") == false){ ?>
			<div class="beta">
				<p>This is the alpha version of an upcoming wishlist platform. Only <a href="http://pierrestoffe.be/notes/" target="_blank">a few functionnalities</a> have been implemented. <br />Please send your feedback to <a href="mailto:bonjour@pierrestoffe.be?subject=Feedback for Giftt.me">bonjour@pierrestoffe.be</a>.</p>
			</div>
			<?php } ?>

			<div class="col-sm-6 register">
				<div class="button">
					<a href="/register">
						<span class="title">Register</span>
					</a>
				</div>
			</div>

			<div class="col-sm-6 login">
				<div class="button">
					<a href="/login">
						<span class="title">Login</span>
					</a>
				</div>
			</div>

		</div>
	</div>

	<?php require_once $root . '/_include/foot.php'; ?>
</body>
</html>
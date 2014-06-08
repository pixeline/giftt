<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/_include/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Download the browser extension | Giftt</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body id="extension" class="minimal">

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
					<h2 style="margin-bottom: 40px;">Browser extension</h2>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">

					<div class="row">
						<div class="col-sm-6">
							<p>Are you looking for a way to add wishes faster? Then we are 100% sure you're going to love the Giftt browser extension.</p>
							<p>With it, you can add wishes from Amazon, Etsy, Target and every other online store without even leaving their website. Click the extension, make sure the information are correct and click ‘Add to Giftt’. That’s it.</p>
							<p>Currently available for <a href="https://www.google.com/chrome/browser/" target="_blank">Chrome</a> only.</p>

							<div class="download">
							</div>
						</div>
						<div class="col-sm-6">
							<img src="/_assets/images/extension_demo.gif" alt="Extension Demo" />
						</div>
					</div>

				</div>
			</div>

		</div>

	</section>

	<?php require_once $root . '/_include/footer.php'; ?>

	<?php require_once $root . '/_include/foot.php'; ?>

</body>
<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/_include/functions.php';

	if(isset($_POST['sendurl'])){
		$email = "Pierre Stoffe<pierre@giftt.me>";
		$subject ="New favourite from giftt.me"; 
		$headers = "From: " . $me['firstname'] . " " . $me['lastname'] . "<" . $me['email'] .">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$body = "<html><body>";
		$body .= "<p>" . $me['firstname'] . " sent a new favourite online store: " . htmlspecialchars($_POST['url']) . "</p>";
		$body .= "</body></html>";
		mail($email, $subject, $body, $headers);

		$sent = 1;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>404 | Giftt</title>
	<?php require_once $root . '/_include/head.php'; ?>
</head>
<body id="p404" class="minimal">

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
					<h2 style="margin-bottom: 40px;">[404]</h2>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

					<p>You’ve reached the page nobody likes to see. <br />It probably means you’ve followed an old link, or typed a wrong address. <a href="/">So no, there is nothing here!</a></p>
					<p>But to make it worth the trip, would you care to help Giftt grow by sending us the address of your favourite online store?</p>
					<form class="default mini" action="#" method="POST">
						<label for="url">Url</label>
						<input type="url" name="url" autocapitalize="off" spellcheck="false" placeholder="http://" value="" />

						<input type="submit" name="sendurl" value="Send" />
					</form>
					<?php if(isset($sent)){ ?>
					<p>Thanks!</p>
					<?php } ?>

					<p class="home"><a href="/">Go back to the real world »</a></p>

				</div>
			</div>

		</div>

	</section>

	<?php require_once $root . '/_include/footer.php'; ?>

</body>
<?php

$root = $_SERVER['DOCUMENT_ROOT'];
include $root . '/functions.php';

// LOG IN

$message = "Form not sent";

if(isset($_POST['login'])){

	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);

	$query = $db->prepare("SELECT * FROM users WHERE username = :username");
	$query->execute(array(
		'username' => $username
	));
	$results = $query->fetch();

	if($query->rowCount() > 0){
		$user_exists = 1;
	}else{
		$user_exists = 0;
	}

	if(!$user_exists){
		$message = "This usename doesn't exist";
	}else{
		if($password == $results['password']){
			$_SESSION['user'] = array('id' => $results['id'], 'firstname' => $results['firstname'], 'lastname' => $results['lastname'], 'likes' => $results['likes']);
			header('Location:/');
		}else{
			$message = "The password seems to be wrong";
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Index</title>
	<?php require $root . '/_include/head.php'; ?>
</head>
<body class="home">
	<div class="container">
		<?php 

		echo $message;

		?>
	</div>
</body>
</html>
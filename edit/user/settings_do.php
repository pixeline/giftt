<?php


if(isset($_POST['edit_profile'])){

	$me_firstname = htmlspecialchars($_POST['firstname']);
	$me_lastname = htmlspecialchars($_POST['lastname']);
	$me_email = htmlspecialchars($_POST['email']);
	$me_description = htmlspecialchars($_POST['description']);
	$me_image = $_FILES['image'];

	// REQUIRED INPUTS (EXCEPT FILES)
	$required_fields = array('firstname', 'lastname', 'email');
	$message = array();

	foreach($required_fields as $field){
		if(isset($_POST[$field]) && empty($_POST[$field])){
			if($field != "email"){
				$message[$field] = "You must provide a " . $field;
			}else{
				$message[$field] = "You must provide an email address";
			}
		}
	}

	$query = $db->prepare("SELECT * FROM users WHERE email = :email AND id != :id");
	$query->execute(array(
		'email' => $me_email,
		'id' => $me['id']
	));

	if($query->rowCount() > 0){
		$email_exists = 1;
	}else{
		$email_exists = 0;
	}

	if(!filter_var($me_email, FILTER_VALIDATE_EMAIL)){
		$message['email'] = "You must provide a valid email address";
	}elseif($email_exists){
		$message['email'] = "Someone else is already using this email address";
	}

	// FILES VALIDATION
	if(isset($me_image['name']) && !empty($me_image['name'])){
		if($me_image['size'] <= 1048576){
			$file_path = pathinfo($me_image['name']);
			$file_type = $file_path['extension'];
			$file_type_valid = array('jpg', 'jpeg', 'gif', 'png');

			if(in_array($file_type, $file_type_valid)){
				$image_rename = $me['username'] . '.' . $file_type;
				$me_picture = '_assets/images/profile/' . basename($image_rename);
				move_uploaded_file($me_image['tmp_name'], $root . '/' . $me_picture);
			}else{
				$message['image'] = "Only .jpg, .png or .gif files";
			}
		}else{
			$message['image'] = "Max. 1 mo";
		}
	}

	if(!count($message)){
		if(!empty($me_image['name'])){ // SI PAS DE CHANGEMENT D'IMAGE
			$query = $db->prepare("UPDATE users SET firstname=:firstname, lastname=:lastname, email=:email, description=:description, picture=:picture WHERE id=:id");
			$query->execute(array(
				'firstname' => $me_firstname,
				'lastname' => $me_lastname,
				'email' => $me_email,
				'description' => $me_description,
				'picture' => $me_picture,
				'id' => $me['id']
			));
		}else{
			$query = $db->prepare("UPDATE users SET firstname=:firstname, lastname=:lastname, email=:email, description=:description WHERE id=:id");
			$query->execute(array(
				'firstname' => $me_firstname,
				'lastname' => $me_lastname,
				'email' => $me_email,
				'description' => $me_description,
				'id' => $me['id']
			));
		}

		$_SESSION['me']['firstname'] = $me_firstname;
		$_SESSION['me']['lastname'] = $me_lastname;
		$_SESSION['me']['email'] = $me_email;
		$_SESSION['me']['description'] = $me_description;
		if(!empty($me_image['name'])){
			$_SESSION['me']['picture'] = $me_picture;
		}
		header('Location:/');
	}

}



if(isset($_POST['new_password'])){
	$new_password = htmlspecialchars($_POST['password']);

	if(empty($new_password)){
		$message['password'] = "You must provide a new password";
	}elseif(strlen($new_password) < 5){
		$message['password'] = "Your new password should be at least 5 characters long";
	}

	if(!isset($message)){

		// SALT AND HASH PASSWORD
		$salt = bin2hex(openssl_random_pseudo_bytes(22));
		$hash = crypt($new_password, '$2x$12$' . $salt);

		$query = $db->prepare("UPDATE users SET password=:password, salt=:salt WHERE id=:id");
		$query->execute(array(
			'password' => $hash,
			'salt' => $salt,
			'id' => $me['id']
		));
		header("Location:/");

	}
}

?>
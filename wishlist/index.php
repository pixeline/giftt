<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/functions.php';

$wishlist_user = $_GET['user'];
$wishlist_slug = $_GET['slug'];

$query = $db->prepare("SELECT * FROM wishlists WHERE slug = :slug");
$query->execute(array(
	':slug' => $wishlist_slug
));

if($query->rowCount() > 1){
	echo "ERROR: MORE THAN ONE WISHLIST";
	return false;
}

$wishlist = $query->fetch();

$wishlist_id = $wishlist['id'];
$wishlist_author = $wishlist['author'];
$wishlist_name = $wishlist['name'];
$wishlist_description = $wishlist['description'];
$wishlist_private = $wishlist['private'];
$wishlist_date = strtotime($wishlist['date']);

$query = $db->prepare("SELECT * FROM users WHERE id = :id");
$query->execute(array(
	':id' => $wishlist['author']
));

if($query->rowCount() == 0){
	echo "ERROR: NO AUTHOR FOUND";
}elseif($query->rowCount() > 1){
	echo "ERROR: MORE THAN ONE AUTHOR";
	return false;
}

$wishlist_author = $query->fetch();

$wishlist_author_id = $wishlist_author['id'];
$wishlist_author_username = $wishlist_author['username'];
$wishlist_author_firstname = $wishlist_author['firstname'];
$wishlist_author_lastname = $wishlist_author['lastname'];

$wishlist_author_name = $wishlist_author_firstname . ' ' . $wishlist_author_lastname;

if(isset($_SESSION['user'])){

	// ME

	$user = $_SESSION['user'];

	$id = $user['id'];
	$firstname = $user['firstname'];
	$lastname = $user['lastname'];

	$name = $firstname . ' ' . $lastname;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo $wishlist['name'] . " | " . $wishlist_author_name ?></title>
	<?php require $root . '/_include/head.php'; ?>
</head>
<body id="wishlist">

	<?php require $root .'/_include/header.php'; ?>

	<section class="subheader">

		<div class="container">

			<h2><?php echo $wishlist_name ?></h2>

			<p class="mute"><a href="/<?php echo $wishlist_author_username; ?>"><?php echo $wishlist_author_name; ?></a> | <?php echo date('jS F, Y', $wishlist_date); ?></p>

			<div class="button">
				<a href="#">
					<span class="title">12 followers</span>
				</a>
			</div>
			
			<div class="button edit">
				<a href="#">
					<span class="title">Edit</span>
				</a>
			</div>

		</div>

	</section>

	<section class="content public">

		<div class="container">

			<?php

			$query = $db->prepare("SELECT * FROM wishes WHERE wishlist = :id");
			$query->execute(array(
				':id' => $wishlist['id']
			));

			if($query->rowCount() == 0){
				echo "ERROR: NO AUTHOR FOUND";
			}elseif($query->rowCount() > 1){
				echo "ERROR: MORE THAN ONE AUTHOR";
				return false;
			}

			?>

			<ul class="row">

				<?php

				$query = $db->prepare("SELECT * FROM wishlists WHERE author = :id");
				$query->execute(array(
					':id' => $id
				));

				if($query->rowCount() > 0){

				?>

				<li class="col-xs-6 col-sm-4 col-md-3">
					<div class="wishlist add">
						<div class="cover entypo plus">
							<span class="icon"></span>
						</div>
						<a href="/add/wishlist"></a>
					</div>
				</li>

				<?php

					while($wishlist = $query->fetch(PDO::FETCH_ASSOC)){
						$wishlists[] = $wishlist;
					}

					foreach($wishlists as $wishlist){
						$name = $wishlist['name'];
						$id = $wishlist['id'];

				?>

				<li class="col-xs-6 col-sm-4 col-md-3">
					<div class="wishlist">
						<div class="cover" data-img="/_assets/images/birthday.jpg"></div>
						<h4><?php echo $name ?></h4>
						<a href="/<?php echo $page_user_username ?>/wishlist/<?php echo strtolower($id) ?>/<?php echo strtolower($name) ?>"></a>
						<div class="button">
							<a href="/<?php echo $page_user_username ?>/wishlist/<?php echo strtolower($id) ?>/<?php echo strtolower($name) ?>/edit">
								<span class="title">Edit</span>
							</a>
						</div>
					</div>
				</li>

				<?php

					}
				
				}else{

				?>

				<div class="col-sm-12">
					Nothin'
				</div>

				<?php

				}

				?>

			</ul>

		</div>

	</section>

	<section class="content private">

		<div class="container">

			<h3>Your <strong>private</strong> wishlists</h3>

			<ul class="row">
				<li class="col-xs-6 col-sm-4 col-md-3">
					<div class="wishlist add">
						<div class="cover entypo plus">
							<span class="icon"></span>
						</div>
						<a href="#"></a>
					</div>
				</li>
				<li class="col-xs-6 col-sm-4 col-md-3">
					<div class="wishlist">
						<div class="cover" data-img="/_assets/images/birthday.jpg"></div>
						<h4>Birthday 2014</h4>
						<div class="entypo lock">
							<span class="icon"></span>
							<span class="title">Private</span>
						</div>

						<a href="#"></a>
						<div class="button">
							<a href="#">
								<span class="title">Edit</span>
							</a>
						</div>
					</div>
				</li>
				<li class="col-xs-6 col-sm-4 col-md-3">
					<div class="wishlist">
						<div class="cover" data-img="/_assets/images/clothes.jpg"></div>
						<h4>Clothes</h4>
						<div class="entypo lock">
							<span class="icon"></span>
							<span class="title">Private</span>
						</div>

						<a href="#"></a>
						<div class="button">
							<a href="#">
								<span class="title">Edit</span>
							</a>
						</div>
					</div>
				</li>
				<li class="col-xs-6 col-sm-4 col-md-3">
					<div class="wishlist">
						<div class="cover" data-img="/_assets/images/wooden.jpg"></div>
						<h4>Wooden stuff</h4>
						<div class="entypo lock">
							<span class="icon"></span>
							<span class="title">Private</span>
						</div>

						<a href="#"></a>
						<div class="button">
							<a href="#">
								<span class="title">Edit</span>
							</a>
						</div>
					</div>
				</li>
			</ul>

		</div>

	</section>

	<?php require $root . '/_include/foot.php'; ?>
</body>
</html>
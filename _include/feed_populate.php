<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

require_once $root . '/_include/user_info.php';

/*$debug = 1;*/


// GET FOLLOWS LIST

$query = $db->prepare("SELECT * FROM follows WHERE who = :who AND follow = :follow AND removed != 1");
$query->execute(array(
	':who' => $me['id'],
	':follow' => 1
));
$results = $query->fetchAll();

$raw_follows = array();
if(isset($debug) && $debug == 1 && $me['id'] == 1){
	$raw_follows[] = 1;
}
foreach($results as $result){
	$raw_follows[] = $result['who2'];
}

if(!empty($raw_follows)){

	// GET LAST WISHES BASED ON $follows

	$follows = join(',', $raw_follows);

	$query = $db->prepare("SELECT * FROM wishlists WHERE author IN ($follows) AND private = 0 AND removed = :removed");
	$query->execute(array(
		':removed' => 0
	));
	$wishlists_query = $query->fetchAll();

	$wishlists = array();
	if(isset($wishlists_query) && !empty($wishlists_query)){
		foreach($wishlists_query as $wishlist){
			$wishlists[] = $wishlist['id'];
		}
	}

	if(!empty($wishlists)){

		$wishlists_list = join(',', $wishlists);

		$query = $db->prepare("SELECT * FROM wishes WHERE wishlist IN ($wishlists_list) AND removed = :removed");
		$query->execute(array(
			':removed' => 0
		));
		$wishes = $query->fetchAll();

		$data = array();
		if(isset($wishes) && !empty($wishes)){
			foreach($wishes as $wish){
				$data[] = $wish;
			}
		}
	}


	// GET LAST FOLLOWED BASED ON $follows

	$query = $db->prepare("SELECT * FROM follows WHERE who IN ($follows) AND who2 != :id AND follow = :follow AND removed != 1");
	$query->execute(array(
		':id' => $me['id'],
		':follow' => 1
	));
	$new_follows = $query->fetchAll();

	$raw_follows[] = $me['id'];

	if(isset($new_follows) && !empty($new_follows)){
		foreach($new_follows as $new_follow){
			$data[] = $new_follow;
			if(!in_array($new_follow['who2'], $raw_follows)){
				$raw_follows[] = $new_follow['who2'];
			}
		}
	}


	// GET LAST PEOPLE WHO FOLLOWED ME

	$query = $db->prepare("SELECT * FROM follows WHERE who2 = :id AND follow = :follow AND removed != 1");
	$query->execute(array(
		':id' => $me['id'],
		':follow' => 1
	));
	$new_follows = $query->fetchAll();

	if(isset($new_follows) && !empty($new_follows)){
		foreach($new_follows as $new_follow){
			$data[] = $new_follow;
			if(!in_array($new_follow['who'], $raw_follows)){
				$raw_follows[] = $new_follow['who'];
			}
		}
	}


	// GET USERS LIST

	$users_list = join(',', $raw_follows);

	$query = $db->prepare("SELECT id, username, firstname, lastname, picture FROM users WHERE id IN ($users_list)");
	$query->execute();
	$feed_users = $query->fetchAll();


	// GET WISHLISTS LIST

	$query = $db->prepare("SELECT id, slug, author, name FROM wishlists WHERE author IN ($users_list)");
	$query->execute();
	$feed_wishlists = $query->fetchAll();


	// PROCESS DATA

	if(!empty($data)){
		$date = array();
		foreach($data as $key => $row){
		    $date[$key] = $row['date'];
		}
		array_multisort($date, SORT_DESC, $data);


		// SEND TO THE RIGHT FUNCTION

		function format_wish($raw, $users, $wishlists){

			foreach($users as $feed_user){
				if($feed_user['id'] == $raw['author']){
					$author = $feed_user;
				}
			}
			$author_name = $author['firstname'] . ' ' . $author['lastname'];
			$author_picture = $author['picture'];

			foreach($wishlists as $feed_wishlist){
				if($feed_wishlist['id'] == $raw['wishlist']){
					$wishlist = $feed_wishlist;
				}
			}
			$wishlist_name = $wishlist['name'];

			$wish_name = $raw['name'];
			$wish_picture = $raw['picture'];
			$wish_link = $author['username'] . '/' . $wishlist['slug'] . '/' . $raw['id'];
?>
			<a href="/<?php echo $wish_link; ?>" class="item">
				<div class="user">
					<div class="img-crop">
						<img src="/<?php if(!empty($author_picture)){ echo $author_picture; }else{ echo "_assets/images/profile/default.jpg"; } ?>" alt="<?php echo $author_name; ?>" />
					</div>
				</div>
				<div class="content">
					<?php $current_wish_name = strlen($wish_name) > 40 ? substr($wish_name,0,40)."..." : $wish_name; ?>
					<p><strong><?php echo $author_name; ?></strong> added <strong><?php echo $current_wish_name; ?></strong></p>
					<div class="picture" style="background-image: url(/<?php echo $wish_picture; ?>);"></div>
				</div>
			</a>
<?php
		}

		function format_follow($raw, $users, $me){

			foreach($users as $feed_user){
				if($feed_user['id'] == $raw['who']){
					$follower = $feed_user;
				}
			}
			$follower_name = $follower['firstname'] . ' ' . $follower['lastname'];
			$follower_username = $follower['username'];
			$follower_picture = $follower['picture'];

			foreach($users as $feed_user){
				if($feed_user['id'] == $raw['who2']){
					$followed = $feed_user;
				}
			}
			$followed_name = $followed['firstname'] . ' ' . $followed['lastname'];
			$followed_username = $followed['username'];
?>
			<a href="/<?php if($followed_username == $me){ echo $follower_username; }else{ echo $followed_username; }?>" class="item">
				<div class="user">
					<div class="img-crop">
						<img src="/<?php if(!empty($follower_picture)){ echo $follower_picture; }else{ echo "_assets/images/profile/default.jpg"; } ?>" alt="<?php echo $follower_name; ?>" />
					</div>
				</div>
				<div class="content">
					<p><strong><?php echo $follower_name; ?></strong> followed <strong><?php if($followed_username == $me){ echo 'You'; }else{ echo $followed_name; } ?></strong></p>
				</div>
			</a>
<?php
		}

		foreach($data as $key => $row){
			if(!isset($row['name'])){
				format_follow($row, $feed_users, $me['username']);
			}else{
				format_wish($row, $feed_users, $feed_wishlists);
			}
		}
	}else{
		echo "<div class='empty'>Search for your friends, follow them and see what they are wishing</div>";
	}

}else{
	echo "<div class='empty'>Search for your friends, follow them and see what they are wishing</div>";
}

?>
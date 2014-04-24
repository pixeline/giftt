<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/_include/functions.php';

require_once $root . '/_include/user_info.php';

/*$debug = 1;*/


// GET FOLLOWS LIST

$query = $db->prepare("SELECT * FROM follows WHERE who = :who AND follow = :follow");
$query->execute(array(
	':who' => $me_id,
	':follow' => 1
));
$results = $query->fetchAll();

$raw_follows = array();
if(isset($debug) && $debug == 1 && $me_id == 1){
	$raw_follows[] = 1;
}
foreach($results as $result){
	$raw_follows[] = $result['who2'];
}

if(!empty($raw_follows)){

	// GET LAST WISHES BASED ON $follows

	$follows = join(',', $raw_follows);

	$query = $db->prepare("SELECT * FROM wishes WHERE author IN ($follows) AND removed = :removed");
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


	// GET LAST FOLLOWED BASED ON $follows

	$query = $db->prepare("SELECT * FROM follows WHERE who IN ($follows) AND follow = :follow");
	$query->execute(array(
		':follow' => 1
	));
	$new_follows = $query->fetchAll();

	if(isset($new_follows) && !empty($new_follows)){
		foreach($new_follows as $new_follow){
			/*if($new_follow['who2'] != $me_id){*/
				$data[] = $new_follow;
			/*}*/
			if(!in_array($new_follow['who2'], $raw_follows)){
				$raw_follows[] = $new_follow['who2'];
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


		// SEND TO RIGHTFUL FUNCTION

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
			$wish_picture = $raw['cover'];
			$wish_link = $author['username'] . '/' . $wishlist['slug'] . '/' . $raw['id'];
?>
			<a href="/<?php echo $wish_link; ?>" class="item">
				<div class="user">
					<img src="/<?php echo $author_picture; ?>" alt="<?php echo $author_name; ?>" />
				</div>
				<div class="content">
					<p><strong><?php echo $author_name; ?></strong> added <strong><?php echo $wish_name; ?></strong> to <strong><?php echo $wishlist_name; ?></strong></p>
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
			$follower_picture = $follower['picture'];

			foreach($users as $feed_user){
				if($feed_user['id'] == $raw['who2']){
					$followed = $feed_user;
				}
			}
			$followed_name = $followed['firstname'] . ' ' . $followed['lastname'];
			$followed_username = $followed['username'];
?>
			<a href="/<?php echo $followed_username; ?>" class="item">
				<div class="user">
					<img src="/<?php echo $follower_picture; ?>" alt="<?php echo $follower_name; ?>" />
				</div>
				<div class="content">
					<p><strong><?php echo $follower_name; ?></strong> followed <strong><?php if($followed_name == $me){ echo You; }else{ echo $followed_name; } ?></strong></p>
				</div>
			</a>
<?php
		}

		foreach($data as $key => $row){
			if(isset($row['name'])){
				format_wish($row, $feed_users, $feed_wishlists);
			}else{
				format_follow($row, $feed_users, $feed_wishlists, $me_username);
			}
		}
	}else{
		echo "<a href='/" . $me_username . "/settings/#friends' class='item empty'><div class='user'>+</div><div class='content'>Follow your friends to see what they're wishing</div></div>";
	}

}else{
	echo "follows no one";
}

?>
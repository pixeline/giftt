<header>

	<?php require_once $root . '/_include/menu.php'; ?>

	<?php

		$query = $db->prepare("SELECT who2, follow FROM follows WHERE who = :id AND follow = 1 AND who2 != :id2");
		$query->execute(array(
			':id' => $me_id,
			':id2' => $me_id
		));

		$following = 0;
		$following_list = array();
		while($follow = $query->fetch(PDO::FETCH_ASSOC)){
			$following++;
			$following_list[] = $follow['who2'];
		}

		$query2 = $db->prepare("SELECT who, follow FROM follows WHERE who2 = :id AND follow = 1 AND who != :id2");
		$query2->execute(array(
			':id' => $user_id,
			':id2' => $user_id
		));

		$followers = 0;
		$followers_list = array();
		while($follow = $query2->fetch(PDO::FETCH_ASSOC)){
			$followers++;
			$followers_list[] = $follow['who'];
		}

	?>

	<div class="container-fluid">
		
		<a class="user" href="/<?php echo $user_url; ?>"><img src="/<?php if(!empty($user_picture)){ echo $user_picture; }else{ echo '_assets/images/profile/default.jpg';} ?>" alt="<?php echo $user_name; ?>" /></a>
		<h2><?php echo $user_name; ?></h2>
		<?php if(!empty($user_description)){ ?>
			<p class="description"><?php echo $user_description; ?></p>
		<?php } ?>
		<?php if($me_username == $user_username){ ?>
			<p class="follow_stats"><a href="#"><?php echo $followers; ?> followers</a> | <a href="#"><?php echo $following; ?> following</a></p>
		<?php }else{ ?>	

			<?php if(in_array($user_id, $following_list)){ ?>
				<div class="button follow canfollow following">
					<a href="#" data-who2="<?php echo $user_id; ?>">
						<span class="title">Unfollow</span>
					</a>
				</div>
			<?php }else{ ?>
				<div class="button follow canfollow">
					<a href="#" data-who2="<?php echo $user_id; ?>">
						<span class="title">Follow</span>
					</a>
				</div>
			<?php } ?>

		<?php } ?>
		
	</div>

</header>
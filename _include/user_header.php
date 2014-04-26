<header>

	<?php require_once $root . '/_include/menu.php'; ?>

	<?php

		$query = $db->prepare("SELECT who2, follow FROM follows WHERE who = :id AND follow = 1");
		$query->execute(array(
			':id' => $me_id
		));

		$following = array();
		while($follow = $query->fetch(PDO::FETCH_ASSOC)){
			$following[] = $follow['who2'];
		}

		$query2 = $db->prepare("SELECT who FROM follows WHERE who2 = :id AND follow = 1 AND who != :id2");
		$query2->execute(array(
			':id' => $user_id,
			':id2' => $user_id
		));

		$followers = 0;
		while($follower = $query2->fetch(PDO::FETCH_ASSOC)){
			if(isset($follower['who'])){
				$followers++;
			}
		}

	?>

	<div class="container-fluid">
		
		<a class="user" href="/<?php echo $user_url; ?>"><img src="/<?php if(isset($user_picture)){ echo $user_picture; }else{ echo '_assets/images/profile/default.jpg';} ?>" alt="<?php echo $user_name; ?>" /></a>
		<h2><?php echo $user_name; ?></h2>
		<p><?php echo $user_description; ?></p>
		<?php if($me_username == $user_username){ ?>
		<div class="button follow">
			<a href="#" onclick="alert('You cannot see your followers yet.'); return false;">
				<span class="title"><?php echo $followers; ?> followers</span>
			</a>
		</div>
		<?php }else{ ?>	

			<?php if(in_array($user_id, $following)){ ?>
				<div class="button follow canfollow following">
					<a href="#" data-who2="<?php echo $user_id; ?>">
						<span class="title">Following</span>
						<span class="number"><?php echo $followers; ?></span>
					</a>
				</div>
			<?php }else{ ?>
				<div class="button follow canfollow">
					<a href="#" data-who2="<?php echo $user_id; ?>">
						<span class="title">Follow</span>
						<span class="number"><?php echo $followers; ?></span>
					</a>
				</div>
			<?php } ?>

		<?php } ?>
		<?php if($me_username == $user_username){ ?>
		<div class="button edit">
			<a href="/<?php echo $me_url; ?>/settings" onclick="alert('You cannot edit your settings yet.'); return false;">
				<span class="title">Settings</span>
			</a>
		</div>
		<?php } ?>
		
	</div>

</header>
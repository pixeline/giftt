<?php

// FOLLOW

/*$query = $db->prepare("SELECT who2, follow FROM follows WHERE who = :id");
$query->execute(array(
	':id' => $user['id']
));

while($follow = $query->fetch(PDO::FETCH_ASSOC)){
	$follows[] = $follow;
}

foreach($follows as $follow){
	if($follow['follow'] == 1){
		$following[] = $follow['who2'];
	}
}*/

?>

<div class="container-fluid">

	<div class="row">

		<div class="col-sm-6 logout">
			<h1>Logout</h1>
			<form action="<?php $root ?>/_include/logout.php" method="POST">
				<label>Are you sure?</label>
				<input type="submit" name="logout" value="Yes, I'm sure" />
			</form>
		</div>

	</div>

	<div class="row">

		<div class="col-sm-2">
			<?php if(in_array("1", $following)) : ?>
				<a class="button follow following" data-who2="1" href="#">Following</a>
			<?php else : ?>
				<a class="button follow" data-who2="1" href="#">Follow</a>
			<?php endif; ?>
		</div>

		<div class="col-sm-2">
			<?php if(in_array("2", $following)) : ?>
				<a class="button follow following" data-who2="2" href="#">Following</a>
			<?php else : ?>
				<a class="button follow" data-who2="2" href="#">Follow</a>
			<?php endif; ?>
		</div>

		<div class="col-sm-2">
			<?php if(in_array("3", $following)) : ?>
				<a class="button follow following" data-who2="3" href="#">Following</a>
			<?php else : ?>
				<a class="button follow" data-who2="3" href="#">Follow</a>
			<?php endif; ?>
		</div>

		<div class="col-sm-2">
			<?php if(in_array("4", $following)) : ?>
				<a class="button follow following" data-who2="4" href="#">Following</a>
			<?php else : ?>
				<a class="button follow" data-who2="4" href="#">Follow</a>
			<?php endif; ?>
		</div>

		<div class="col-sm-2">
			<?php if(in_array("5", $following)) : ?>
				<a class="button follow following" data-who2="5" href="#">Following</a>
			<?php else : ?>
				<a class="button follow" data-who2="5" href="#">Follow</a>
			<?php endif; ?>
		</div>

		<div class="col-sm-2">
			<?php if(in_array("6", $following)) : ?>
				<a class="button follow following" data-who2="6" href="#">Following</a>
			<?php else : ?>
				<a class="button follow" data-who2="6" href="#">Follow</a>
			<?php endif; ?>
		</div>

		<div class="col-sm-2">
			<?php if(in_array("7", $following)) : ?>
				<a class="button follow following" data-who2="7" href="#">Following</a>
			<?php else : ?>
				<a class="button follow" data-who2="7" href="#">Follow</a>
			<?php endif; ?>
		</div>

		<div class="col-sm-2">
			<?php if(in_array("8", $following)) : ?>
				<a class="button follow following" data-who2="8" href="#">Following</a>
			<?php else : ?>
				<a class="button follow" data-who2="8" href="#">Follow</a>
			<?php endif; ?>
		</div>

		<div class="col-sm-2">
			<?php if(in_array("9", $following)) : ?>
				<a class="button follow following" data-who2="9" href="#">Following</a>
			<?php else : ?>
				<a class="button follow" data-who2="9" href="#">Follow</a>
			<?php endif; ?>
		</div>

		<div class="col-sm-2">
			<?php if(in_array("10", $following)) : ?>
				<a class="button follow following" data-who2="10" href="#">Following</a>
			<?php else : ?>
				<a class="button follow" data-who2="10" href="#">Follow</a>
			<?php endif; ?>
		</div>

	</div>

</div>
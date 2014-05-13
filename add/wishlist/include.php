<section class="add_wishlist slide_container">
	<div class="wrapper">
		<h4>New wishlist</h4>
		<form action="/<?php echo $me_username; ?>/wishlist/add" method="POST">
			<input type="text" id="name" name="name" placeholder="Name" />
			<div class="radio">
				<ul>
					<label for="public" class="active">Public</label>
					<label for="private">Secret</label>
				</ul>
				<input type="radio" id="public" name="private" value="0" checked="checked" />
				<input type="radio" id="private" name="private" value="1" />
			</div>
			<button type="submit" name="add_wishlist">Add wishlist</button>
		</form>
		<div class="icon-close"><span>Close</span></div>
	</div>
</section>
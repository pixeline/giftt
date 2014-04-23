<section class="modal addWishlist">
	<div class="v_align">
		<form class="container-fluid" id="add_wishlist" action="/<?php echo $user_url; ?>/wishlist/add" method="POST" enctype="multipart/form-data">
			<button type="submit" name="add_wishlist" class="hidden"></button>
			<header class="row">
				<div class="col-sm-6 title">
					<h3>Add a wishlist</h3>
				</div>
				<div class="col-sm-6 actions">
					<button type="reset" class="close">Close</button>
				</div>
			</header>
			<div class="wrapper">
				<div class="row">
					<!-- <div class="col-sm-4">
						<label for="image">Cover <span>(required)</span></label>
						<div class="file_cont entypo picture">
							<img src="/<?php echo $wishlist_cover; ?>" alt="<?php echo $wishlist_name; ?>" />
							<input id="image" type="file" name="image" required />
							<span class="message">Please select a .jpg, .png or .gif file. <br />Maximum 1 Mo.</span>
						</div>
					</div> -->
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-10">
								<label for="name">Name <span>(required)</span></label>
								<input id="name" type="text" name="name" value="" required />
							</div>
							<div class="col-sm-2">
								<label for="private">Private</label>
								<input id="private" type="checkbox" name="private" value="1" />
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<button type="submit" name="add_wishlist">Create wishlist</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
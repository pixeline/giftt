<?php if($me_id == $user_id){ ?>
<section class="modal editWishlist">
	<div class="v_align">
		<form class="container" id="edit_wishlist" action="/<?php echo $wishlist_url; ?>/edit" method="POST" enctype="multipart/form-data">
			<button type="submit" name="edit_wishlist" class="hidden"></button>
			<header class="row">
				<div class="col-sm-6 title">
					<h3>Edit your wishlist</h3>
				</div>
				<div class="col-sm-6 actions">
					<button type="submit" formaction="/<?php echo $wishlist_url; ?>/remove" formmethod="post" name="remove" class="remove">Remove</button>
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
								<input id="name" type="text" name="name" value="<?php if(isset($wishlist_name)) echo $wishlist_name ?>" required />
							</div>
							<div class="col-sm-2">
								<label for="private">Private</label>
								<input id="private" type="checkbox" name="private" value="1" <?php if(isset($wishlist_private) && $wishlist_private == 1) echo "checked"; ?>/>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<button type="submit" name="edit_wishlist">Save changes</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
<?php } ?>
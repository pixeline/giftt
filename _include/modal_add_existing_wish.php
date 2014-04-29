<?php if($me_id == $user_id){ ?>
<section class="modal addWish">
	<div class="v_align">
		<form class="container" id="add_wish" action="/<?php echo $me_url; ?>/wish/add" method="POST" enctype="multipart/form-data">
			<button type="submit" name="add_wish" class="hidden"></button>
			<header class="row">
				<div class="col-sm-6 title">
					<h3>Make a wish</h3>
				</div>
				<div class="col-sm-6 actions">
					<button type="reset" class="close">Close</button>
				</div>
			</header>
			<div class="wrapper">
				<div class="row">
					<div class="col-sm-3">
						<label for="image">Photo <span>(required)</span></label>
						<div class="file_cont entypo picture">
							<img src="<?php if(isset($wish_cover)) echo '/' . $wish_cover; ?>" alt="Placeholder image" <?php if(!isset($wish_cover)) echo "style='display: none'"; ?> />
							<span class="icon" <?php if(isset($wish_cover)) echo "style='display: none'"; ?>></span>
							<input id="image" type="file" name="image" required />
							<span class="message">Please select a .jpg, .png or .gif file. <br />Maximum 1 Mo.</span>
						</div>
					</div>
					<div class="col-sm-9">
						<div class="row">
							<div class="col-sm-8">
								<label for="name">Name <span>(required)</span></label>
								<input id="name" type="text" name="name" value="<?php if(isset($wish_name)) echo $wish_name; ?>" required />
							</div>
							<div class="col-sm-4">
								<label for="wishlist">Wishlist <span>(required)</span></label>
								<select id="wishlist" name="wishlist" required>
									<option>Choose a wishlist</option>
											
									<?php

									$query = $db->prepare("SELECT * FROM wishlists WHERE author = :author AND removed = :removed");
									$query->execute(array(
										':author' => $me['id'],
										':removed' => 0
									));

									$wishlists = [];
									while($wishlist = $query->fetch(PDO::FETCH_ASSOC)){
										$wishlists[] = $wishlist;
									}

									foreach($wishlists as $wishlist){
										$name = $wishlist['name'];
										$id = $wishlist['id'];

									?>

									<option value="<?php echo $id; ?>" <?php if($name == $wishlist_name) echo "selected"; ?>><?php echo $name; ?></option>

									<?php

										}

									?>

								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-8">
								<label for="origin">Origin</label>
								<input id="origin" type="url" name="origin" value="<?php if(isset($wish_origin)) echo $wish_origin[0]; ?>" placeholder="http://" required />
							</div>
							<div class="col-sm-4">
								<label for="price">Price</label>
								<input id="price" type="text" name="price" value="<?php if(isset($wish_price)) echo $wish_price; ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<label for="description">Description from the website <span>(required)</span></label>
								<textarea id="description" name="description" required><?php if(isset($wish_description)) echo $wish_description; ?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<label for="notes">Additional notes</label>
								<textarea id="notes" name="notes"><?php if(isset($wish_notes)) echo $wish_notes; ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<button type="submit" name="add_wish">Add your wish</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
<?php } ?>
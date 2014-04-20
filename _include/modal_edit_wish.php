<section class="modal editWish">
	<div class="v_align">
		<form class="container" id="edit_wish" action="/<?php echo $wish_url; ?>/edit" method="POST" enctype="multipart/form-data">
			<button type="submit" name="edit_wish" class="hidden"></button>
			<header class="row">
				<div class="col-sm-6 title">
					<h3>Edit your wish</h3>
				</div>
				<div class="col-sm-6 actions">
					<button type="submit" formaction="/<?php echo $wish_url; ?>/remove" formmethod="post" name="remove" class="remove">Remove</button>
					<button type="reset" class="close">Close</button>
				</div>
			</header>
			<div class="wrapper">
				<div class="row">
					<div class="col-sm-3">
						<label for="image">Photo <span>(required)</span></label>
						<div class="file_cont entypo picture">
							<img src="/<?php echo $wish_cover; ?>" alt="<?php echo $wish_name; ?>" />
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

									$wishlists = array();
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
								<input id="origin" type="url" name="origin" value="<?php if(isset($wish_origin)) echo $wish_origin; ?>" placeholder="http://" required />
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
						<button type="submit" name="edit_wish">Save changes</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
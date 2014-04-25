<section class="modal addWish">
	<div class="v_align">
		<form class="container" id="add_wish" action="/<?php echo $me_url; ?>/wish/add" method="POST" enctype="multipart/form-data">
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
							<img src="" alt="Placeholder image" style="display: none" />
							<span class="icon"></span>
							<input id="image" type="file" name="image" required />
							<span class="message">Please select a .jpg, .png or .gif file. <br />Maximum 1 Mo.</span>
						</div>
					</div>
					<div class="col-sm-9">
						<div class="row">
							<div class="col-sm-8">
								<label for="name">Name <span>(required)</span></label>
								<input id="name" type="text" name="name" value="" required />
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

									<option value="<?php echo $id; ?>"><?php echo $name; ?></option>

									<?php

										}

									?>

								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-8">
								<label for="origin">Origin</label>
								<input id="origin" type="url" name="origin" value="" placeholder="http://" required />
							</div>
							<div class="col-sm-4">
								<label for="price">Price</label>
								<input id="price" type="text" name="price" value="" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<label for="description">Description from the website <span>(required)</span></label>
								<textarea id="description" name="description" required></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<label for="notes">Additional notes</label>
								<textarea id="notes" name="notes"></textarea>
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
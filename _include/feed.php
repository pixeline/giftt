<?php if(isset($me)){ ?>
<aside class="alter">
	<div class="container">
		
		<form class="search" action="#" method="POST">
			<label for="search">Search</label>
			<input id="search" name="search" autocomplete="off" autocapitalize="off" placeholder="Search..." />
			<img src="/_assets/images/preloader.gif" />
		</form>

		<div class="wrapper">
			<div class="feed">
				<!-- TO BE FILLED WITH AN AJAX REQUEST -->
			</div>
			<div class="results">
				<!-- TO BE FILLED WITH AN AJAX REQUEST -->
			</div>
		</div>
		
		<!-- <div class="logout">
			<a href="/logout" class="icon icon-logout"></a>
		</div> -->

	</div>
</aside>
<?php } ?>
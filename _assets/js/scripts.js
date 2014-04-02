(function(){

	// FOLLOW

	$('.follow').on('click', function(){
		button = $(this);
		who2 = button.data('who2');
		follow(who2, button);
		return false;
	})

	function follow(who2, button){
		var followData = {'who2': who2};

		$.ajax({
			url: '/_include/follow.php',
			type: 'POST',
			data: {data:followData},
			dataType: 'json',
			error: function(){
				return false;
			},
			complete: function(){
				content = button.text();
				button.toggleClass('active');
				if(content == 'Following'){
					button.text('Follow');
				}else{
					button.text('Following');
				}
			}
		});
	}


	// LOGOUT

	$('#tools .disconnect').on('click', function(){
		logout();
		return false;
	})

	function logout(){

		$.ajax({
			url: '/_include/logout.php',
			type: 'POST',
			data: 'logout=yes',
			success: function(){
				window.location = '/';
			},
			error: function(){
				return false;
			}
		});
	}


	// COVER

	$('.cover').each(function(){
		img = $(this).data('img');
		if(img){
			$(this).css({'background-image': 'url('+img+')'});
		}
	})


	// THUMBNAILS

	$('.wishlist > a').hover(function(){
		$(this).siblings('h4').css({'text-decoration': 'underline'});
	}, function(){
		$(this).siblings('h4').css({'text-decoration': 'none'});
	})

})();
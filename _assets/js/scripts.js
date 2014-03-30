(function(){

	$('.follow').on('click', function(){
		button = $(this);
		who2 = button.data('who2');
		follow(who2, button);
		/*followAfter(button)*/
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
				button.toggleClass('following');
				if(content == 'Following'){
					button.text('Follow');
				}else{
					button.text('Following');
				}
			}
		});
	}

})();
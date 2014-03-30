(function(){

	$('.follow').on('click', function(){
		button = $(this);
		who2 = button.data('who2');
		follow(who2, button);
		/*followAfter(button)*/
	})

	function follow(who2, button){
		var followData = {'who2': who2};
		button = button;

		$.ajax({
			url: '/_include/follow.php',
			type: 'POST',
			data: {data:followData},
			dataType: 'json',
			complete: function(){
				content = button.html();
				button.toggleClass('following');
				if(content == 'Following'){
					button.html('Follow');
				}else{
					button.html('Following');
				}
			}
		});
	}

	function followAfter(button){
		
	}

})();
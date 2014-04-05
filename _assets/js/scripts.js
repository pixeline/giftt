(function(){

	/////////////////////////////////////
	// VARIABLES ////////////////////////
	/////////////////////////////////////

	body = $('body');










	/////////////////////////////////////
	// AESTHETICS ///////////////////////
	/////////////////////////////////////

	// INIT

	function init(){

		initMasonry();

	}

	init();

	function initMasonry(){
		if(body.hasClass('wishlist') && body.hasClass('view')){
			setTimeout(function(){
				masContainer = $('.wishes');
				masContainer.masonry({
					columnWidth: '.wishes li:nth-child(2)',
					itemSelector: '.wishes li'
				});
			}, 50);
		}
	}










	/////////////////////////////////////
	// NAVIGATION ///////////////////////
	/////////////////////////////////////

	// MENU

	$('.menu li').on('click', function(){
		menu($(this));
	})

	function menu(el){
		if(el.hasClass('active')){
			return false;
		}
		id = el.attr('id');
		el.siblings('li').removeClass('active');
		el.addClass('active');
		wishlists = $('.wishlists');
		wishlistsAll = wishlists.find('.public, .private');
		wishlistsAll.fadeOut(200);
		setTimeout(function(){
			wishlists.find('li.'+id).fadeIn(200);
		}, 200);
	}


	// SHOW ASIDE

	$('#showAside').on('click', function(){
		showAside();
		return false;
	})

	function showAside(){
		aside = $('aside');
		main = $('.main');
		aside.toggleClass('show');
		main.toggleClass('withAside');
	}










	/////////////////////////////////////
	// FORMS ////////////////////////////
	/////////////////////////////////////

	// ADD SIZE METHOD TO VALIDATION PLUGIN

	/*$.validator.addMethod('filesize', function(value, element, param){
		return this.optional(element) || (element.files[0].size <= param);
	});*/

	// ADD WISHLIST

	/*form = $('#add_wishlist form');
	inputName = form.find('input[name=name]');
	inputSubmit = form.find('input[type=submit]');
	inputSubmit.removeClass('ready');

	form.on('keyup', function(){
		error = 1;
		
		if(inputName.val().length > 0){
			error = 0;
		}

		if(error == 0){
			inputSubmit.addClass('ready');
		}else{
			inputSubmit.removeClass('ready');
		}
	})

	form.submit(function(){
		if($(this).hasClass('ready')){
			alert('ok');
		}
		return false;
	})*/

	// ADD WISH

	/*$('#add_wish').validate({
		rules: {
			image: {
				extension: "jpg,png,jpeg,gif",
				filesize: 1048576,
			}
		},
		errorPlacement: function(error, element){
			//nowhere
		},
		highlight: function(element, errorClass){
			id = element.id;
			$("#" + id).addClass(errorClass);
		},
		unhighlight: function(element, errorClass){
			id = element.id;
			$("#" + id).removeClass(errorClass);
		},
		errorClass: "error"
	});*/










	/////////////////////////////////////
	// AJAX REQUESTS ////////////////////
	/////////////////////////////////////

	// FOLLOW

	$('.follow a').on('click', function(){
		button = $(this);
		who2 = button.data('who2');
		follow(who2, button);
		return false;
	})

	function follow(who2, button){
		followData = {'who2': who2};

		$.ajax({
			url: '/_include/follow.php',
			type: 'POST',
			data: {data:followData},
			dataType: 'json',
			error: function(){
				return false;
			},
			complete: function(){
				content = button.find('.title');
				button.toggleClass('active');
				if(content.text() == 'Following'){
					content.text('Follow');
				}else{
					content.text('Following');
				}
			}
		});
	}


	// LOGOUT

	$('#logout').on('click', function(){
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

})();
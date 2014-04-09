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

		smallStuff();
		initMasonry();

	}

	init();

	function smallStuff(){
		body.removeClass('nojs');
	}

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

	// VALIDATION

	form = $('form');
	form.submit(function(){
		fields = $(this).find('input, textarea, select, radio');
		errors = {};
		form.find('label, input, select, textarea').removeClass('error');
		fields.each(function(){
			validate($(this));
		})
		$.each(errors, function(key, value){
			form.find('label[for='+key+']').addClass('error');
			form.find(value+'[id='+key+']').addClass('error');
		})
		if(!$.isEmptyObject(errors)){
			return false;
		}
	})

	function validate(el){
		tag = el.prop('tagName').toLowerCase();
		type = el.prop('type').toLowerCase();
		if(tag == 'input'){
			isRequired(el, tag);
			if(type == 'file'){
				isImage(el);
				isNotTooBig(el);
			}
		}else if(tag == 'select'){
			isRequired(el, tag);
		}else if(tag == 'textarea'){
			isRequired(el, tag);
		}
	}

	function isRequired(el){
		if(!!el.attr('required')){
			if(tag == "input"){
				if(type == "file"){
					if(!el.val().length && !el.siblings('img').length){
						name = el.attr('id');
						errors[name] = tag;
					}
				}else{
					if(!el.val().length){
						name = el.attr('id');
						errors[name] = tag;
					}
				}
			}else if(tag == "select"){
				bar = el.find('option:selected').attr('value');
				if(!bar){
					name = el.attr('id');
					errors[name] = tag;
				}
			}else if(tag == "textarea"){
				if(!el.val().length){
					name = el.attr('id');
					errors[name] = tag;
				}
			}
		}
	}

	function isImage(el){
		ext = el.val().substring(el.val().lastIndexOf('.') + 1);
		if(el.val().length){
			if(ext != "jpg" && ext != "jpeg" && ext != "png" && ext != "gif"){
				name = 'image';
				errors[name] = tag;
			}
		}
	}

	function isNotTooBig(el){
		file = el[0].files[0];
		if(file){
			if(file.size > 1000000 || el.fileSize > 1000000){
				name = 'image';
				errors[name] = tag;
			}
		}
	}


	// MODALS

	var target;
	var modal = false;

	$('.button.edit').on('click', function(){
		target = $(this).data('target');
		openModal(target);
		return false;
	});

	function openModal(type){
		$('.modal.'+type).fadeIn(200).addClass('show');
		modal = true;
	}

	$('button.close').on('click', function(){
		closeModal(target);
	});

	$('.modal .container').on('click', function(e){
		e.stopPropagation();
	});

	$('.modal').on('click', function(){
		closeModal(target);
	});

	$(document).keydown(function(e){
		if(e.keyCode == 27){
			if(modal){
				closeModal(target);
				e.preventDefault();
			}
		}
	});

	function closeModal(type){
		$('.modal.'+type).fadeOut(200, function(){
			$(this).removeClass('show');
			$(this).find('label, input, select, textarea, radio').removeClass('error');
		});
		modal = false;
	}


	// SHOW UPLOADED IMAGE

	$("#image").change(function(){
		readURL(this);
	});

	function readURL(input){
		if(input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function(e){
				$('form .file_cont img').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}










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
		button.find('.title').text('Following');
		followData = {'who2': who2};

		/*$.ajax({
			url: '/_include/follow.php',
			type: 'POST',
			data: {data:followData},
			dataType: 'json',
			error: function(){
				return false;
			},
			success: function(){
				content = button.find('.title');
				button.toggleClass('active');
				if(content.text() == 'Following'){
					content.text('Follow');
				}else{
					content.text('Following');
				}
			}
		});*/
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
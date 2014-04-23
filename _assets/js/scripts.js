/*!
 * Giftt.me 1.0 beta
 * Pierre Stoffe
 * @PierreStoffe
 */

 (function(){

	/////////////////////////////////////
	// VARIABLES ////////////////////////
	/////////////////////////////////////

	body = $('body');
	var masContainer;










	/////////////////////////////////////
	// AESTHETICS ///////////////////////
	/////////////////////////////////////


	// RESIZE

	$(window).on('resize', function(){
		resizeStuff();
	})

	function resizeStuff(){
		wh = $(window).innerHeight();
		$('.main').height(wh);
	}


	// INIT

	function init(){

		resizeStuff();
		smallStuff();
		initMasonry();

	}

	init();

	function smallStuff(){
		body.removeClass('nojs');
	}

	function initMasonry(){
		if((body.hasClass('wishlist') && body.hasClass('view')) || (body.hasClass('user') && body.hasClass('view'))){
			setTimeout(function(){
				masContainer = $('.wishes');
				if(masContainer.find('.wish').not('.add').length > 0){
					masContainer.imagesLoaded(function(){
						masContainer.masonry({
							columnWidth: '.wishes li:nth-child(2)',
							itemSelector: '.wishes li'
						})
					})
				}
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
		aside();
		return false;
	});

	function aside(){
		body.toggleClass('withAside');
		showFeed();
		setTimeout(function(){
			masContainer.masonry();
		}, 250);
		$('aside').find('.wrapper').height(wh-80);
	}










	/////////////////////////////////////
	// FORMS ////////////////////////////
	/////////////////////////////////////

	// VALIDATION

	form = $('form');
	form.submit(function(){
		thisForm = $(this);
		fields = $(this).find('input, textarea, select, radio');
		errors = {};
		thisForm.find('label, input, select, textarea').removeClass('error');
		fields.each(function(){
			validate($(this));
		})
		$.each(errors, function(key, value){
			thisForm.find('label[for='+key+']').addClass('error');
			thisForm.find(value+'[id='+key+']').addClass('error');
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
					if(!el.val().length && el.siblings('img').attr('src') == '/'){
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

	$('.modal_trigger').on('click', function(){
		target = $(this).data('target');
		openModal(target);
		return false;
	});

	function openModal(type){
		$('.modal.'+type).fadeIn(200).addClass('show');
		modal = true;
		init_img = $('.modal.'+target).find('img').attr('src');
	}

	$('button.close').on('click', function(){	
		$('.modal.'+target).fadeOut(200, function(){
			$(this).removeClass('show');
			$(this).find('label, input, select, textarea, radio').removeClass('error');
			imgCont = $(this).find('.file_cont');
			if(target.indexOf('add') >= 0){
				imgCont.find('img').attr('src', '/').hide();
				imgCont.find('span.icon').show();
			}else if(target.indexOf('edit') >= 0){
				imgCont.find('img').attr('src', init_img);
			}
		});
		modal = false;
	});

	$('.modal .container').on('click', function(e){
		e.stopPropagation();
	});

	$('.modal').on('click', function(){
		closeModal();
	});

	$(document).keydown(function(e){
		if(e.keyCode == 27){
			if(modal){
				closeModal();
				e.preventDefault();
			}
		}
	});

	function closeModal(){
		$('.modal.'+target).find('button.close').click();
	}


	// INLINE FORM

	$('.wish.view').find('.button .hide_edit').on('click', function(){
		$('.hide_edit').hide();
		$('.show_edit').show();
		edit = 1;
		return false;
	})

	$('#link').on('click', function(){
		if(edit == 1){
			$('input#image').click();
			return false;
		}
	})


	// SHOW UPLOADED IMAGE

	$("#image").change(function(){
		readURL(this);
	});

	function readURL(input){
		if(input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function(e){
				$('form .file_cont img').attr('src', e.target.result).css({'display': 'block'});
				$('form .file_cont span').hide();
			}
			reader.readAsDataURL(input.files[0]);
		}
	}










	/////////////////////////////////////
	// AJAX REQUESTS ////////////////////
	/////////////////////////////////////

	// FOLLOW

	$('.button.canfollow a').on('click', function(){
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
			dataType: 'text',
			error: function(){
				return false;
			},
			success: function(){
				title = button.find('.title');
				number = button.find('.number');
				button.parents('.follow').toggleClass('following');
				if(title.text() == 'Following'){
					title.text('Follow');
					number.text(parseInt(number.text())-1);
				}else{
					title.text('Following');
					number.text(parseInt(number.text())+1);
				}
			}
		});
	}


	// LOGOUT

	/*$('#logout').on('click', function(){
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
			}
		});
	}*/


	// SHOW FEED

	function showFeed(){

		$.ajax({
			url: '/_include/show_feed.php',
			type: 'POST'
		});
	}










	/////////////////////////////////////
	// DEV //////////////////////////////
	/////////////////////////////////////


	// MESSAGE HEAD

	$('.beta').find('.close').on('click', function(){
		$(this).parents('.beta').slideUp();
	})

})();
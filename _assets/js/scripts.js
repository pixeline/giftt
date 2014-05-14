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
		$('.feed').find('.wrapper').height(wh-80);
	}


	// INIT

	function init(){

		resizeStuff();
		smallStuff();
		initMasonry();
		populateFeed();

	}

	init();

	function smallStuff(){
		body.removeClass('nojs');
	}

	function initMasonry(){
		if((body.hasClass('user') || body.hasClass('wishlist')) && body.hasClass('view')){
			setTimeout(function(){
				masContainer = $('.wishes');
				if(masContainer.find('.wish').length > 0){
					masContainer.imagesLoaded(function(){
						masContainer.masonry({
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

	// SHOW SETTINGS

	$('#settings').on('click', function(){
		showSettings();
		return false;
	});

	$('.main').on('click', function(){
		if($('.settings-list').hasClass('show')){
			showSettings();
		}
	})

	function showSettings(){
		$('.settings-list').toggleClass('show');
	}


	// SHOW ASIDE

	$('#show_hide').on('click', function(){
		aside();
		return false;
	});

	function aside(){
		body.toggleClass('withAside');
		showFeed();
		if((body.hasClass('user') || body.hasClass('wishlist')) && body.hasClass('view')){
			setTimeout(function(){
				masContainer.masonry();
			}, 250);
		}
	}


	// PODS SHOW/HIDE

	$('.pod.collapse header').on('click', function(){
		$(this).siblings('.wrapper').slideToggle(200);
	})










	/////////////////////////////////////
	// FORMS ////////////////////////////
	/////////////////////////////////////

	// VALIDATION

	/*form = $('form');
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
					if(!el.val().length && (el.siblings('img').attr('src') == '' || el.siblings('img').attr('src') == '/')){
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
	}*/


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
		body.addClass('edit');
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


	// RADIO TRICK

	$('.radio label').on('click', function(){
		$(this).siblings('label').removeClass('active');
		$(this).addClass('active');
	});


	// CLOSE SLIDE CONTAINER

	$('.icon-close').on('click', function(){
		$(this).parents('.slide_container').slideUp(200);
		$('.form-trigger').slideDown(200);
	});

	$('.form-trigger a').on('click', function(){
		cont = $(this).parent('.form-trigger');
		target = cont.data('target');
		$('.slide_container.'+target).slideDown(200, function(){
			$(this).find('input').first().focus();
		});
		cont.slideUp(200);
		return false;
	})


	// INPUT FOCUS

	$('.slide_container').find('input[type=text], textarea').on('focus', function(){
		$(this).addClass('active');
	}).on('blur', function(){
		$(this).removeClass('active');
	})


	// ADD WISHLISt

	$('a.icon-plus').on('click', function(){
		target = $(this).data('target');
		if(target == 'add_wishlist'){
			$('.wishlists li.add').toggle();
			$('.wishlists form input').first().focus();
		}

		$('.wishlists form').submit(function(e){
			thisForm = $(this);
			inputName = thisForm.find('#name');
			errors = {};
			if(!inputName.val()){
				errors['name'] = "Please give it a name";
			}
			thisForm.find('input').removeClass('error');
			thisForm.find('#name').attr('placeholder', 'Name');
			$.each(errors, function(key, value){
				thisForm.find('input[name='+key+']').addClass('error').attr('placeholder', value);
				e.preventDefault();
			})
		})
	})










	/////////////////////////////////////
	// AJAX REQUESTS ////////////////////
	/////////////////////////////////////

	// FOLLOW

	$('.follow').on('click', function(){
		button = $(this);
		who = button.data('who');
		follow(who, button);
		return false;
	})

	function follow(who, button){
		followData = {'who2': who};

		$.ajax({
			url: '/_include/follow.php',
			type: 'POST',
			data: {data:followData},
			dataType: 'text',
			error: function(){
				return false;
			},
			success: function(){
				location.reload();
			}
		});
	}


	// SHOW FEED

	function showFeed(){

		$.ajax({
			url: '/_include/feed_show.php',
			type: 'POST'
		});
	}


	// POPULATE FEED

	function populateFeed(){

		$.ajax({
			url: '/_include/feed_populate.php',
			type: 'POST',
			success: function(data){
				$('.feed .wrapper').append(data);
			}
		})
	}


	// TEST

	$('.wish.view form').submit(function(){
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

	function editWish(){
		data = $("#edit_wish").serializeArray();
		$.ajax({
			url: '/edit/wish/edit_do.php',
			type: 'POST',
			data: data,
			success: function(data){
				results = $.parseJSON(data);
				showErrors(results);
			}
		})
	}

	function showErrors(data){
		console.log(data);
	}










	/////////////////////////////////////
	// DEV //////////////////////////////
	/////////////////////////////////////


	// MESSAGE HEAD

	$('.beta').find('.close').on('click', function(){
		$(this).parents('.beta').slideUp();
	})

})();
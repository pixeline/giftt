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

	i = 0;
	function resizeStuff(){
		wh = $(window).innerHeight();
		fix = 3;
		if(i == 0){
			fix = 0;
		}
		$('.main').height(wh-fix);
		$('.alter').find('.wrapper').height(wh-84-60);
		i++;
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
		if(body.hasClass('wishlist')){
			setTimeout(function(){
				masContainer = $('.wishes');
				runMasonry();
			}, 50);
		}
	}

	function runMasonry(){
		if(masContainer.find('li').length > 0){
			masContainer.imagesLoaded(function(){
				masContainer.masonry({
					itemSelector: '.wishes li'
				})
			})
		}
	}










	/////////////////////////////////////
	// NAVIGATION ///////////////////////
	/////////////////////////////////////


	// SHOW ASIDE

	$('#show_hide').on('click', function(){
		$('.main').one('click', function(){
			if(body.hasClass('withAside')){
				aside();
			}
		})

		aside();
		return false;
	});

	function aside(){
		body.toggleClass('withAside');
		showFeed();
		if(body.hasClass('wishlist')){
			runMasonry();
		}
	}


	// PODS SHOW/HIDE

	$('.pod.collapse header').on('click', function(){
		$(this).siblings('.wrapper').slideToggle(200);
	})


	// SEARCH

	feedHidden = 0;
	$('.search input').on('keyup', function(e){
		input = $(this);
		alter = $('.alter');
		feed = alter.find('.feed');
		results = alter.find('.results');
		
		if(feedHidden == 0){
			feed.hide();
			results.show();
			feedHidden = 1;
		}

		if(input.val() == ""){
			feed.show();
			results.hide();
			feedHidden = 0;
		}
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


	// SHOW UPLOADED IMAGE

	$("#image").change(function(){
		readURL(this);
	});

	function readURL(input){
		if(input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function(e){
				$('form .file_cont img').attr('src', e.target.result).show();
				$('form .file_cont span').hide();
			}
			reader.readAsDataURL(input.files[0]);
		}
	}


	// RADIO TRICK (add [secret] wishlist)

	$('.wishlist label').on('click', function(){
		$(this).toggleClass('active');
		$(this).siblings('input').prop("checked", !checkBoxes.prop("checked"));
	});


	// ADD WISHLIST

	$('.wishlist a.icon-plus').on('click', function(){
		target = $(this).data('target');
		elem = $('.wishlists li.add');
		if(target == 'add_wishlist'){
			elem.toggle();
			elem.find('form input').first().focus();
		}

		elem.find('form').find('#name').removeClass('error').attr('placeholder', 'Name');
		elem.find('form').submit(function(e){
			thisForm = $(this);
			inputName = thisForm.find('#name');
			errors = {};
			if(!inputName.val()){
				errors['name'] = "Please give it a name";
			}
			thisForm.find('#name').removeClass('error').attr('placeholder', 'Name');
			$.each(errors, function(key, value){
				thisForm.find('input[name='+key+']').addClass('error').attr('placeholder', value);
				e.preventDefault();
			})
		})
		
		elem.on('click', function(e){
			e.stopPropagation();
		})

		$('html').one('click', function(){
			elem.hide();
			$('.wishlist').show();
		})

		return false;
	})


	// EDIT WISHLIST

	$('.wishlist a.icon-edit').on('click', function(){
		parent = $(this).parent('li');
		parent.hide();
		parent.next().show();

		parent.next().find('form').submit(function(e){
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
		
		parent.next().on('click', function(e){
			e.stopPropagation();
		})

		$('html').one('click', function(){
			$('.wishlists .edit').hide();
			$('.wishlist').show();
		})

		return false;
	})


	// REMOVE WISHLIST

	$('li.edit .remove').on('click', function(){
		$(this).submit();
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
				$('.alter .feed').append(data);
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

})();
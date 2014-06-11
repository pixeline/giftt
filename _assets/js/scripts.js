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
		ww = $(window).innerWidth();
		fix = 3;
		if(i == 0){
			fix = 0;
		}
		$('.main').height(wh-fix);
		$('.alter').find('.wrapper').height(wh-84);
		i++;
	}


	// INIT

	function init(){

		resizeStuff();
		smallStuff();
		initMasonry();
		populateFeed();
		FastClick.attach(document.body);

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

	countAside = 0;
	function aside(){
		body.toggleClass('withAside');
		if(ww > 600){
			searchInput = $('.alter .search').find('input');
			if(countAside%2 == 0){
				searchInput.focus();
			}else{
				searchInput.blur();
			}
		}
		countAside++;
	}


	// PODS SHOW/HIDE

	$('.pod.collapse header').on('click', function(){
		$(this).siblings('.wrapper').slideToggle(200);
	})


	// SEARCH

	feedHidden = 0;
	$('.search').on('submit', function(e){
		e.preventDefault();
	}).find('input').on('keyup', function(e){
		input = $(this);
		alter = $('.alter');
		feed = alter.find('.feed');
		results = alter.find('.results');

		if(input.val() == ""){
			feed.show();
			results.hide();
			feedHidden = 0;
			return false;
		}
		
		if(feedHidden == 0){
			feed.hide();
			results.empty().show();
			feedHidden = 1;
		}

		if(e.which == 13){
			window.location.href = results.find('a').first().attr('href');
		}

		$(this).siblings('img').show();
		doSearch($(this).val());
	})


	// ARROWS TO NAVIGATE BETWEEN WISHES AND SHOW/HIDE SIDEBAR

	$(document).keydown(function(e){
		if(!$('.add').find('#name').is(':focus')){
			if(e.keyCode == 37){
				if(body.hasClass('wish view')){
					target = $('.wish_navigation').find('.prev').find('a').attr('href');
					if(target != "undefined" && target != null){
						location.href = target;
					}
					return false;
				}else if(body.hasClass('wishlist view')){
					$('#show_hide').click();
				}
			}else if(e.keyCode == 39){
				if(body.hasClass('wish view')){
					target = $('.wish_navigation').find('.next').find('a').attr('href');
					if(target != "undefined" && target != null){
						location.href = target;
					}
					return false;
				}else if(body.hasClass('wishlist view')){
					$('#show_hide').click();
				}
			}
		}
	});


	// SHARE

	$('p.share').on('click', function(){
		$('.share_box').toggleClass('show');
		$(body).one('click', function(){
			$('.share_box').removeClass('show');
		})
		return false;
	})










	/////////////////////////////////////
	// FORMS ////////////////////////////
	/////////////////////////////////////


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
		$(this).parents('.private_checkbox').siblings('input[type=text]').focus();
	});


	// ADD WISHLIST

	$('.wishlist a.icon-plus').on('click', function(){
		target = $(this).data('target');
		elem = $('.wishlists li.add');
		elem.toggle();
		elem.find('#name').focus().removeClass('error').attr('placeholder', 'Name');
		
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
		parent.next().find('form').find('#name').focus();

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


	// ADD WISH

	$('.wish.add, .wish.edit').find('form').on('submit', function(){
		formName = $(this).find('input#name');
		formWishlist = $(this).find('select#wishlist');
		formImage = $(this).find('input#image');
		formImageExtension = formImage.val().split('.').pop().toLowerCase();

		$('p.error').remove();
		formName.removeClass('error');
		formWishlist.removeClass('error');
		$('.file_cont').removeClass('error');
		errors = {};
		if(formName.val() == ""){
			errors['name'] = "You must provide a name";
		}
		if(formWishlist.val() == null){
			errors['wishlist'] = "You must select a wishlist";
		}
		if(formImage.val() == "" && formImage.siblings('img').attr('src') == "/"){
			errors['image'] = "You must provide a picture";
		}else if(formImage.val() != "" && formImage[0].files[0].size > 1048576){
			errors['image'] = "The picture is too big (limited to 1 mo)";
		}else if(formImage.val() != "" && $.inArray(formImageExtension, ['gif','png','jpg','jpeg']) == -1){
			errors['image'] = "The picture should be a .jpg, .png or .gif file";
		}

		if(errors['name']){
			formName.addClass('error').after('<p class="error">' + errors['name'] + '</p>').siblings('.error').show();
		}
		if(errors['wishlist']){
			formWishlist.addClass('error').after('<p class="error">' + errors['wishlist'] + '</p>').siblings('.error').show();
		}
		if(errors['image']){
			$('.file_cont').addClass('error').find('input').after('<p class="error">' + errors['image'] + '</p>').siblings('.error').show();
		}

		if(errors['name'] || errors['wishlist'] || errors['image']){
			return false;
		}
	})

	$('.wish.add, .wish.edit').find('select[name=wishlist]').on('change', function(){
		if($(this).val() == "setnew"){
			new_wishlist_name = prompt("Please give this wishlist a name");
			if(new_wishlist_name != "" && new_wishlist_name != "null"){
				$('input[id=new_wishlist]').remove();
				$(this).after('<input id="new_wishlist" type="text" name="new_wishlist" value="' + new_wishlist_name + '" required />').siblings('#new_wishlist').hide();
				$(this).children().last().before('<option value="new">' + new_wishlist_name + '</option>').prev().prop('selected', true);
			}else{
				$(this).children().first().prop('selected', true);
			}
		}
	})










	/////////////////////////////////////
	// AJAX REQUESTS ////////////////////
	/////////////////////////////////////


	// POPULATE FEED

	function populateFeed(){
		$('.alter').show();

		$.ajax({
			url: '/_include/feed_populate.php',
			type: 'POST',
			success: function(data){
				$('.alter .feed').empty().append(data);
			}
		})
	}


	// SEARCH

	function doSearch(value){
		searchData = {search: value};

		$.ajax({
			url: '/_include/search.php',
			type: 'POST',
			data: {data:searchData},
			error: function(){
				return false;
			},
			success: function(data){
				console.log(data);
				$('.alter .results').empty().append(data);
				$('.alter .search').find('img').hide();
			}
		});
	}








	/////////////////////////////////////
	// OTHER STUFF //////////////////////
	/////////////////////////////////////


	// EXTENSION DOWNLOAD BUTTON

	if(body.attr('id') == "extension"){

		is_chrome = /chrome/i.test(navigator.userAgent);
		is_safari = /safari/i.test(navigator.userAgent);
		is_firefox = /firefox/i.test(navigator.userAgent);
		is_opera = /presto/i.test(navigator.userAgent);

		if(is_chrome){
			$('.download').addClass('valid').append('<a class="button" href="https://chrome.google.com/webstore/detail/giftt-extension/ejjoaofkpcegclnaknkfdbbjhcdclpdh" target="_blank">Download for Chrome</a>');
		}else if(is_safari && !is_chrome){
			$('.download').append('<a class="button" href="#">Soon for Safari...</a>');
		}else if(is_firefox){
			$('.download').append('<a class="button" href="#">Soon for Firefox...</a>');
		}else if(is_opera){
			$('.download').append('<a class="button" href="#">Soon for Opera...</a>');
		}else if(is_ie){
			$('.download').append('<a class="button" href="#">Not available for Internet Explorer</a>');
		}else{
			$('.download').append('<a class="button" href="#">Not available for your browser</a>');
		}
	}

})();
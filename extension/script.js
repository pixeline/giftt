(function(){

	// FUNCTIONS

	function getUrlParameter(sParam){
		sPageURL = window.location.search.substring(1);
		sURLVariables = sPageURL.split('&');
		for(i = 0; i < sURLVariables.length; i++){
			sParameterName = sURLVariables[i].split('=');
			if(sParameterName[0] == sParam){
				return sParameterName[1];
			}
		}
	}

	function br2rn(str) {
		str = str.replace(/<br\s*\/?>/mg, "\r\n");
		str = str.replace(/[\r\n]+$/, "");
		return str;
	}


	// FILL IN THE INPUTS
	
	container = $('.container');
	form = $('form');
	formImage = form.find('#image');
	formPicture = form.find('#picture'); // hidden field
	formOrigin = form.find('#origin'); // hidden field
	formName = form.find('#name');
	formPrice = form.find('#price');
	formCurrency = form.find('#currency');
	formWishlist = form.find('#wishlist');
	formDescription = form.find('#description');
	formSubmit = form.find('#submit');


	// NEW WISHLIST

	$('select[name=wishlist]').on('change', function(){
		if($(this).val() == "setnew"){
			new_wishlist_name = prompt("Please give this wishlist a name");
			if(new_wishlist_name != "" && new_wishlist_name != null){
				$('input[id=new_wishlist]').remove();
				$(this).after('<input id="new_wishlist" type="text" name="new_wishlist" value="' + new_wishlist_name + '" required />').siblings('#new_wishlist').hide();
				$(this).children().last().before('<option value="new">' + new_wishlist_name + '</option>').prev().prop('selected', true);
			}else{
				$(this).children().first().prop('selected', true);
			}
		}
	})


	// POST MESSAGE LISTENER

	domain = 0;
	function respond(e){
		if(e.data.indexOf('drop=') > -1){
			imageSrc = e.data.replace('drop=', '');
			formPicture.val(imageSrc);
			formImage.empty().css({'background-image': 'url(' + imageSrc + ')'}).addClass('found').removeClass('hover').removeClass('error');
		}else if(e.data == "enter"){
			formImage.addClass('hover');
		}else if(e.data == "leave"){
			formImage.removeClass('hover');
		}else if(e.data == "start"){
			formImage.addClass('start');
		}else if(e.data == "end"){
			formImage.removeClass('start');
		}else if(e.data.indexOf('name=') > -1){
			theName = e.data.replace('name=', '');
			if(theName){
				formName.val(theName);
			}
		}else if(e.data.indexOf('price=') > -1){
			thePrice = e.data.replace('price=', '');
			if(thePrice != "" && thePrice != "undefined"){
				formPrice.val(thePrice);
			}
		}else if(e.data.indexOf('currency=') > -1){
			theCurrency = e.data.replace('currency=', '');
			if(theCurrency != "" && theCurrency != "undefined"){
				formCurrency.val(theCurrency);
			}
		}else if(e.data.indexOf('description=') > -1){
			theDescription = br2rn(e.data.replace('description=', ''));
			if(theDescription != "" && theDescription != "undefined"){
				formDescription.val(theDescription);
			}
		}else if(e.data.indexOf('image=') > -1){
			theImage = e.data.replace('image=', '');
			if(theImage != "" && theImage != "undefined"){
				formPicture.val(theImage);
				formImage.empty().css({'background-image': 'url(' + theImage + ')'}).addClass('found').removeClass('hover');
			}
		}else if(e.data.indexOf('url=') > -1){
			theOrigin = e.data.replace('url=', '');
			if(theOrigin != "" && theOrigin != "undefined"){
				formOrigin.val(theOrigin);
			}
		}
	}

	window.addEventListener('message', respond, false);


	// SUBMIT

	sent = 0;
	errors = 0;
	form.on('submit', function(){
		validateForm();
		if(sent == 0 && errors == 0){
			submitForm();
		}
		return false;
	})

	function validateForm(){
		formPictureExtension = formPicture.val().split('.').pop().toLowerCase();
		formPictureExtension = formPictureExtension.split('?')[0];
		formPictureExtension = formPictureExtension.split('#')[0];
		formPictureExtension = formPictureExtension.split('&')[0];

		$('.error').removeClass('error');
		formName.removeClass('error');
		formWishlist.removeClass('error');
		errors = {};
		if(formName.val() == ""){
			errors['name'] = "You must provide a name";
		}
		if(formWishlist.val() == null){
			errors['wishlist'] = "You must select a wishlist";
		}
		if(formPicture.val() == ""){
			errors['image'] = "You must provide a picture";
		}else if(formPicture.val() != "" && $.inArray(formPictureExtension, ['gif','png','jpg','jpeg']) == -1){
			errors['image'] = "The picture should be a .jpg, .png or .gif file";
		}

		if(errors['name']){
			formName.addClass('error');
		}
		if(errors['wishlist']){
			formWishlist.addClass('error');
		}
		if(errors['image']){
			$('#image').addClass('error');
		}

		if(errors['name'] || errors['wishlist'] || errors['image']){
			return false;
		}else{
			errors = 0;
		}
	}

	function submitForm(){
		data = form.serialize();
		formWrapper = $('.form_wrapper');
		formHide = $('.form_hide');
		formWrapper.addClass('fade');
		formSubmit.val('Adding...');
		sent = 1;

		function failed(){
			formWrapper.removeClass('fade');
			alert('We couldn\'t add your wish.\nPlease reload the page and try again.');
		}

		function success(url){
			window.parent.postMessage('finished', '*');
			formWrapper.find('.loader').addClass('hide');
			setTimeout(function(){
				window.parent.postMessage('height=222', '*');
				formHide.addClass('fade').delay(250).hide();
				setTimeout(function(){
					formWrapper.removeClass('fade').addClass('hidden');
					formImage.wrap('<a href="'+url+'" target="_blank"></a>');
					formSubmit.val('Added !');
				}, 250);
			}, 250);
			form.on('submit', function(){
				window.open(url, '_blank');
			})
		}

		$.ajax({
			url: '/extension/add.php',
			type: 'POST',
			data: data,
			success: function(data){
				if(data == "error"){
					failed();
				}else{
					success(data);
				}
			}, error: function(data){
				failed();
			}
		})
	}

	window.parent.postMessage('ready', '*');

})();
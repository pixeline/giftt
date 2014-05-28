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
	formName = form.find('#name');
	formPrice = form.find('#price');
	formCurrency = form.find('#currency');
	formWishlist = form.find('#wishlist');
	formDescription = form.find('#description');
	formSubmit = form.find('#submit');

	theName = decodeURI(getUrlParameter('name'));
	if(theName){
		formName.val(theName);
	}

	thePrice = decodeURI(getUrlParameter('price'));
	if(thePrice != "" && thePrice != "undefined"){
		formPrice.val(thePrice);
	}

	theCurrency = decodeURI(getUrlParameter('currency'));
	if(theCurrency != "" && theCurrency != "undefined"){
		formCurrency.val(theCurrency);
	}

	theDescription = br2rn(decodeURI(getUrlParameter('description')));
	theDescription = theDescription.replace('$and$', '&');
	theDescription = theDescription.replace('$equals$', '=');
	if(theDescription != "" && theDescription != "undefined"){
		formDescription.val(theDescription);
	}

	theImage = decodeURI(getUrlParameter('image'));
	if(theImage != "" && theImage != "undefined"){
		formPicture.val(theImage);
		formImage.empty().css({'background-image': 'url(' + theImage + ')', 'border': 0}).removeClass('hover');
	}

	function getWishlists(){
		$.ajax({
			url: '/extension/wishlists.php',
			type: 'POST',
			success: function(data){
				if(data == ""){
					formWishlist.parents('.sep').append('<input type="text" id="wishlist" name="new_wishlist" />').find('select').remove();
				}else{
					formWishlist.append(data);
				}
			}
		})
	}
	getWishlists();


	// POST MESSAGE LISTENER

	function respond(e){
		if(e.data.indexOf('drop=') > -1){
			imageSrc = e.data.replace('drop=', '');
			formPicture.val(imageSrc);
			formImage.empty().css({'background-image': 'url(' + imageSrc + ')', 'border': 0}).removeClass('hover');
		}else if(e.data == "enter"){
			formImage.addClass('hover');
		}else if(e.data == "leave"){
			formImage.removeClass('hover');
		}else if(e.data == "start"){
			formImage.addClass('start');
		}else if(e.data == "end"){
			formImage.removeClass('start');
		}
	}

	window.addEventListener('message', respond, false);

})();
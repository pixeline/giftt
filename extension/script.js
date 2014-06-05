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

	theName = decodeURIComponent(getUrlParameter('name'));
	if(theName){
		formName.val(theName);
	}

	thePrice = decodeURIComponent(getUrlParameter('price'));
	if(thePrice != "" && thePrice != "undefined"){
		formPrice.val(thePrice);
	}

	theCurrency = decodeURIComponent(getUrlParameter('currency'));
	if(theCurrency != "" && theCurrency != "undefined"){
		formCurrency.val(theCurrency);
	}

	theDescription = br2rn(decodeURIComponent(getUrlParameter('description')));
	if(theDescription != "" && theDescription != "undefined"){
		formDescription.val(theDescription);
	}

	theImage = decodeURIComponent(getUrlParameter('image'));
	if(theImage != "" && theImage != "undefined"){
		formPicture.val(theImage);
		formImage.empty().css({'background-image': 'url(' + theImage + ')'}).addClass('found').removeClass('hover');
	}

	theOrigin = decodeURIComponent(getUrlParameter('url'));
	if(theOrigin != "" && theOrigin != "undefined"){
		formOrigin.val(theOrigin);
	}

	/*function getWishlists(){
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
	getWishlists();*/


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

	function respond(e){
		if(e.data.indexOf('drop=') > -1){
			imageSrc = e.data.replace('drop=', '');
			formPicture.val(imageSrc);
			formImage.empty().css({'background-image': 'url(' + imageSrc + ')'}).addClass('found').removeClass('hover');
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


	// SUBMIT

	form.on('submit', function(){
		submitForm();
		return false;
	})

	function submitForm(){
		data = form.serialize();

		$.ajax({
			url: '/extension/add.php',
			type: 'POST',
			data: data,
			success: function(data){
				alert('done');
			}
		})
	}

})();
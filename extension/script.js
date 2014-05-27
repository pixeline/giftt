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

	function br2ta(str) {
		str = str.replace(/<br\s*\/?>/mg, "\r\n");
		str = str.replace(/[\r\n]+$/, "");
		return str;
	}


	// FILL IN THE INPUTS
	
	container = $('.container');
	form = $('form');
	formImage = form.find('#image');
	formName = form.find('#name');
	formPrice = form.find('#price');
	formCurrency = form.find('#currency');
	formWishlist = form.find('#wishlist');
	formDescription = form.find('#description');
	formSubmit = form.find('#submit');

	theName = decodeURI(getUrlParameter('name'));
	formName.val(theName);

	thePrice = decodeURI(getUrlParameter('price'));
	formPrice.val(thePrice);

	theCurrency = decodeURI(getUrlParameter('currency'));
	formCurrency.val(theCurrency);

	theDescription = br2ta(decodeURI(getUrlParameter('description')));
	formDescription.val(theDescription);

	theImage = br2ta(decodeURI(getUrlParameter('image')));
	formImage.empty().css({'background': 'url(' + theImage + ') no-repeat center center', 'background-size': 'cover', 'border': 0});

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

})();
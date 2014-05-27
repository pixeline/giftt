(function(){

	// GET INFO

	name = "";
	price = "";
	currency = "$";
	description = "";
	image = "";

	if(window.location.href.indexOf('etsy.com') > -1){
		nameElem = document.querySelectorAll('h1')[0];
		if(nameElem){
			name = nameElem.textContent.trim();
		}

		priceElem = document.querySelectorAll('.price-block')[0];
		if(priceElem){
			priceElem = priceElem.querySelectorAll('span.currency-value')[0];

			price = priceElem.textContent.trim();
		}

		currencyElem = document.querySelectorAll('.price-block')[0];
		if(currencyElem){
			currencyElem = currencyElem.querySelectorAll('span.currency-symbol')[0];

			currency = currencyElem.textContent.trim();
		}

		descriptionElem = document.querySelectorAll('#description-text')[0];
		if(descriptionElem){
			description = descriptionElem.innerHTML.trim();
			description.substring(0, 300);
		}

		imageElem = document.querySelectorAll('#image-main')[0];
		if(imageElem){
			imageElem = imageElem.querySelectorAll('img')[0];

			image = imageElem.getAttribute('src');
		}
	}else if(window.location.href.indexOf('amazon.') > -1){
		nameElem = document.querySelectorAll('h1#title')[0] || document.querySelectorAll('.parseasinTitle')[0];
		if(nameElem){
			name = nameElem.textContent.trim();
		}

		priceElem = document.querySelectorAll('#priceblock_ourprice')[0] || document.querySelectorAll('#buyingPriceContent')[0];
		if(priceElem){
			price = priceElem.textContent.trim();
			if(price.indexOf('$') >= 0){
				price = price.replace('$', '');
				currency = '$';
			}else if(price.indexOf('EUR') >= 0){
				price = price.replace('EUR', '');
				currency = '€';
			}else if(price.indexOf('£') >= 0){
				price = price.replace('£', '');
				currency = '£';
			}
		}

		descriptionElem = document.querySelectorAll('#productDescription')[0]
		if(descriptionElem){
			descriptionElem = descriptionElem.querySelectorAll('p')[0];

			description = descriptionElem.textContent.trim();
			description.substring(0, 300);
			description = description.replace('&', '$and$');
			description = description.replace('=', '$equals$');
		}

		imageElem = document.querySelectorAll('#main-image-container')[0];
		if(imageElem){
			imageElem = imageElem.querySelectorAll('img')[0];
			image = imageElem.getAttribute('src');
		}
	}






	// CREATE VIEW

	serverUrl = "http://tfe.dev/";

	var iceframe = document.getElementById('iframeId');
	if(iceframe){
		alert('already');
		return;
	}

	iframeSrc = serverUrl + 'extension/index.html?name=' + encodeURI(name) + '&url=' + window.location + '&price=' + encodeURI(price) + '&currency=' + encodeURI(currency) + '&description=' + encodeURI(description) + '&image=' + encodeURI(image);

	iframe = document.createElement('iframe');
	iframe.src = iframeSrc;
	iframe.setAttribute("style","z-index: 1000000;position: fixed;bottom: 10px;margin-bottom: 0px;margin-left: 0px;right: 10px;width: 220px;min-height: 573px;border: none;overflow: hidden;background: rgba(110, 176, 4, 1);box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);");
	iframe.frameborder = "0";
	iframe.id = "iframeId";
	iframe.allowtransparency = true;

	document.body.appendChild(iframe);

})();
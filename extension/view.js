(function(){

	// GET INFO

	name = "";
	price = "";
	currency = "$";
	description = "";

	if(window.location.href.indexOf('etsy') > -1){
		nameElem = document.getElementsByTagName('h1')[0];
		name = nameElem.textContent.trim();

		priceElem = document.querySelectorAll('.price-block')[0].querySelectorAll('span.currency-value')[0];
		price = priceElem.textContent.trim();

		currencyElem = document.querySelectorAll('.price-block')[0].querySelectorAll('span.currency-symbol')[0];
		currency = currencyElem.textContent.trim();

		descriptionElem = document.querySelectorAll('#description-text')[0];
		description = descriptionElem.innerHTML.trim();
		description.substring(0, 300);

		imageElem = document.querySelectorAll('#image-main')[0].querySelectorAll('img')[0];
		image = imageElem.getAttribute('src');
	}






	// CREATE VIEW

	serverUrl = "http://tfe.dev/";

	var iceframe = document.getElementById('iframeId');
	if(iceframe){
		alert('already');
		return;
	}

	iframeSrc = serverUrl + 'extension/index.html?name=' + name + '&url=' + window.location + '&price=' + price + '&currency=' + currency + '&description=' + description + '&image=' + image;

	iframe = document.createElement('iframe');
	iframe.src = iframeSrc;
	iframe.setAttribute("style","z-index: 1000000;position: fixed;bottom: 10px;margin-bottom: 0px;margin-left: 0px;right: 10px;width: 220px;min-height: 573px;border: none;overflow: hidden;background: rgba(110, 176, 4, 1);box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);");
	iframe.frameborder = "0";
	iframe.id = "iframeId";
	iframe.allowtransparency = true;

	document.body.appendChild(iframe);

})();
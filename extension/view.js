(function(){

	debug = 0;

	// SHOW OR HIDE?

	var iframe = document.getElementById('iframeId');
	var dropzone = document.getElementById('dropzone');
	if(iframe){
		iframe.remove(0);
		dropzone.remove(0);
		window.removeEventListener('message', respondParent);
		return false;
	}



	// GET INFO

	fname = "";
	price = "";
	currency = "$";
	description = "";
	image = "";

	var metas = document.getElementsByTagName('meta');
	function getMetaContent(target){
		for(i=0; i<metas.length; i++){
			if(metas[i].getAttribute("property") == target){
				return metas[i].getAttribute("content");
			}else if(metas[i].getAttribute("name") == target){
				return metas[i].getAttribute("content");
			}
		}
		return false;
	}

	// defaults
	if(getMetaContent('og:title')){
		fname = getMetaContent('og:title');
	}else{
		nameElem = document.querySelectorAll('h1')[0];
		if(nameElem){
			fname = nameElem.textContent.trim();
		}
	}

	if(getMetaContent('og:image')){
		image = getMetaContent('og:image');
	}

	if(getMetaContent('description')){
		description = getMetaContent('description');
	}

	// specific stories
	if(window.location.href.indexOf('etsy.com') > -1){
		if(getMetaContent('og:title') != ""){
			fname = getMetaContent('og:title');
		}

		if(getMetaContent('og:image') != ""){
			image = getMetaContent('og:image');
		}

		// PRICE NEEDS TO BE RETRIEVED THIS WAY, OTHERWISE IT WILL NOT ALWAYS BE THE SAME CURRENCY/CONVERSION
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
			fname = nameElem.textContent.trim();
		}

		priceElem = document.querySelectorAll('#priceblock_ourprice')[0] || document.querySelectorAll('#buyingPriceContent')[0];
		if(priceElem){
			price = priceElem.textContent.trim();
			if(price.indexOf('$') > -1){
				price = price.replace('$', '');
				currency = '$';
			}else if(price.indexOf('EUR') > -1){
				price = price.replace('EUR', '');
				currency = '€';
			}else if(price.indexOf('£') > -1){
				price = price.replace('£', '');
				currency = '£';
			}
		}

		descriptionElem = document.querySelectorAll('#productDescription')[0]
		if(descriptionElem){
			descriptionElem = descriptionElem.querySelectorAll('p')[0];

			description = descriptionElem.textContent.trim();
			description.substring(0, 300);
		}

		imageElem = document.querySelectorAll('#main-image-container')[0];
		if(imageElem){
			imageElem = imageElem.querySelectorAll('img')[0];
			image = imageElem.getAttribute('src');
		}
	}else if(window.location.href.indexOf('store.apple') > -1){
		priceElem = document.querySelectorAll('span[itemprop="price"]')[0];
		if(priceElem){
			price = priceElem.textContent.trim();
		}

		currencyElem = document.querySelectorAll('meta[itemprop="priceCurrency"]')[0];
		if(currencyElem){
			currencyElem = currencyElem.getAttribute('content');
			if(currencyElem.indexOf('$') > -1 || currencyElem.indexOf('USD') > -1){
				price = price.replace('$', '');
				price = price.replace('USD', '');
				currency = '$';
			}else if(currencyElem.indexOf('€') > -1 || currencyElem.indexOf('EUR') > -1){
				price = price.replace('€', '');
				price = price.replace('EUR', '');
				currency = '€';
			}else if(currencyElem.indexOf('£') > -1 || currencyElem.indexOf('GBP') > -1){
				price = price.replace('£', '');
				price = price.replace('GBP', '');
				currency = '£';
			}
		}

		imageElem = document.querySelectorAll('#productInfo')[0];
		if(imageElem){
			imageElem = imageElem.querySelectorAll('img')[0];
			image = imageElem.getAttribute('src');
			console.log(image);
		}
	}else if(window.location.href.indexOf('pinterest.com') > -1){
		if(getMetaContent('og:description')){
			fname = getMetaContent('og:description');
		}
	}




	// CREATE VIEW

	if(debug == 1){
		serverUrl = "http://tfe.dev/";
	}else{
		serverUrl = "http://giftt.me/";
	}

	iframeSrc = serverUrl + 'extension/index.php';

	iframe = document.createElement('iframe');
	iframe.src = iframeSrc;
	iframe.setAttribute("style","z-index: 100000;position: fixed;bottom: 10px;margin-bottom: 0px;margin-left: 0px;right: 10px;width: 220px;height: 573px;border: none;overflow: hidden;background: rgba(110, 176, 4, 1);box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.2);-webkit-transition: height 0.4s ease-in-out;transition: height 0.4s ease-in-out;");
	iframe.frameborder = "0";
	iframe.id = "iframeId";
	iframe.allowtransparency = true;
	document.body.appendChild(iframe);

	dropzone = document.createElement('div');
	dropzone.id = "dropzone";
	dropzone.style.position = "fixed";
	dropzone.style.right = "25px";
	dropzone.style.width = "190px";
	dropzone.style.bottom = "438px";
	dropzone.style.height = "130px";
	dropzone.style.zIndex = "1000000";
	dropzone.style.background = "red";
	dropzone.style.opacity = "0";
	dropzone.style.display = "none";
	document.body.appendChild(dropzone);



	// DRAG & DROP

	dropzone.addEventListener('dragover', dragOver, false);
	dropzone.addEventListener('dragenter', dragEnter, false);
	dropzone.addEventListener('dragleave', dragLeave, false);
	dropzone.addEventListener('drop', drop, false);
	document.addEventListener('dragstart', dragStart, false);
	document.addEventListener('dragend', dragEnd, false);

	function dragOver(e){
		e.stopPropagation();
		e.preventDefault();
	}

	function dragEnter(e){
		e.stopPropagation();
		e.preventDefault();

		iframe.contentWindow.postMessage('enter', '*');
	}

	function dragLeave(e){
		iframe.contentWindow.postMessage('leave', '*');
		e.stopPropagation();
		e.preventDefault();
		
	}

	function drop(e){
		e.stopPropagation();
		e.preventDefault();

		var imageUrl = e.dataTransfer.getData('text/html');
		var rex = /src="?([^"\s]+)"?\s*/;
		var url, res;
		url = rex.exec(imageUrl);
		
		iframe.contentWindow.postMessage('drop='+url[1], '*');
		
		return false;
	}

	function dragStart(e){
		e.stopPropagation();

		iframe.contentWindow.postMessage('start', '*');
	}

	function dragEnd(e){
		e.stopPropagation();
		e.preventDefault();

		iframe.contentWindow.postMessage('end', '*');
	}

	// RECEIVE MESSAGES

	function respondParent(e){
		if(e.data.indexOf('height=') > -1){
			iframeHeight = e.data.replace('height=', '');
			document.querySelectorAll('#iframeId')[0].style.height = iframeHeight;
		}else if(e.data == "ready"){
			dropzone.style.display = "block";
			if(iframe.contentWindow){
				iframe.contentWindow.postMessage('name='+fname, serverUrl);
				iframe.contentWindow.postMessage('url='+window.location, serverUrl);
				iframe.contentWindow.postMessage('price='+price, serverUrl);
				iframe.contentWindow.postMessage('currency='+currency, serverUrl);
				iframe.contentWindow.postMessage('description='+description, serverUrl);
				iframe.contentWindow.postMessage('image='+image, serverUrl);
			}
		}
	}

	window.addEventListener('message', respondParent, false);

})();
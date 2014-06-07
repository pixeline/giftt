(function(){

	debug = 0;



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
			if(descriptionElem.querySelectorAll('p')[0]){
				descriptionElem = descriptionElem.querySelectorAll('p')[0];
			}else if(descriptionElem.querySelectorAll('.content')[0]){
				descriptionElem = descriptionElem.querySelectorAll('.content')[0]
			}
			console.log(descriptionElem);
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
		serverUrl = "https://giftt.me/";
	}

	iframeSrc = serverUrl + 'extension/view.php';

	iframe = document.createElement('iframe');
	iframe.src = iframeSrc;
	iframe.setAttribute("style","z-index: 100000;position: fixed;bottom: 10px;margin-bottom: 0px;margin-left: 0px;right: 10px;width: 220px;height: 573px;border: none;border-top-left-radius: 2px;border-bottom-left-radius: 2px;border-bottom-right-radius: 2px;overflow: hidden;background: rgba(110, 176, 4, 1);box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.2);-webkit-transition: height 0.4s ease-in-out;transition: height 0.4s ease-in-out;");
	iframe.frameborder = "0";
	iframe.id = "giftt_iframe";
	iframe.allowtransparency = true;
	document.body.appendChild(iframe);

	dropzone = document.createElement('div');
	dropzone.id = "giftt_dropzone";
	dropzone.style.setProperty('position', 'fixed', 'important');
	dropzone.style.setProperty('right', '25px', 'important');
	dropzone.style.setProperty('width', '190px',  'important');
	dropzone.style.setProperty('bottom', '438px',  'important');
	dropzone.style.setProperty('height', '130px',  'important');
	dropzone.style.setProperty('z-index', '1000000',  'important');
	dropzone.style.setProperty('background', 'none ', 'important');
	dropzone.style.setProperty('opacity', '0', 'important');
	dropzone.style.setProperty('display', 'none', 'important');
	document.body.appendChild(dropzone);

	closeDiv = document.createElement('div');
	closeDiv.id = "giftt_close";
	closeDiv.style.setProperty('position', 'fixed', 'important');
	closeDiv.style.setProperty('right', '10px', 'important');
	closeDiv.style.setProperty('width', '24px', 'important');
	closeDiv.style.setProperty('bottom', '583px', 'important');
	closeDiv.style.setProperty('height', '24px', 'important');
	closeDiv.style.setProperty('line-height', '24px', 'important');
	closeDiv.style.setProperty('border-top-left-radius', '2px', 'important');
	closeDiv.style.setProperty('border-top-right-radius', '2px', 'important');
	closeDiv.style.setProperty('text-align', 'center', 'important');
	closeDiv.style.setProperty('cursor', 'pointer', 'important');
	closeDiv.style.setProperty('z-index', '1000000', 'important');
	closeDiv.style.setProperty('background', 'rgba(186, 216, 121, 1)', 'important');
	closeDiv.style.transition = "background 0.2s ease-in-out, bottom 0.4s ease-in-out";
	closeDiv.style.webkitTransition = "background 0.2s ease-in-out, bottom 0.4s ease-in-out";
	closeDiv.innerHTML = '<img src="' + serverUrl + 'extension/images/close.svg" style="margin-top: 8px;" />';
	document.body.appendChild(closeDiv);

	closeDiv.addEventListener('mouseover', function(){
		closeDiv.style.setProperty('background', 'rgba(110, 176, 4, 1)', 'important');
	}, false);

	closeDiv.addEventListener('mouseout', function(){
		closeDiv.style.setProperty('background', 'rgba(186, 216, 121, 1)', 'important');
	}, false);

	closeDiv.addEventListener('click', function(){
		closeFrame();
	}, false);

	function closeFrame(){
		iframe.style.setProperty('display', 'none', 'important');
		dropzone.style.setProperty('display', 'none', 'important');
		closeDiv.style.setProperty('display', 'none', 'important');
	}



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
			document.querySelectorAll('#giftt_iframe')[0].style.setProperty('height', iframeHeight+'px', 'important');
			document.querySelectorAll('#giftt_close')[0].style.setProperty('bottom', parseInt(iframeHeight)+10+'px', 'important');
		}else if(e.data == "ready"){
			dropzone.style.setProperty('display', 'block', 'important');
			if(iframe.contentWindow){
				iframe.contentWindow.postMessage('name='+fname, serverUrl);
				iframe.contentWindow.postMessage('url='+window.location, serverUrl);
				iframe.contentWindow.postMessage('price='+price, serverUrl);
				iframe.contentWindow.postMessage('currency='+currency, serverUrl);
				iframe.contentWindow.postMessage('description='+description, serverUrl);
				iframe.contentWindow.postMessage('image='+image, serverUrl);
			}
		}else if(e.data == "finished"){
			dropzone.style.setProperty('display', 'none', 'important');
		}else if(e.data == "close"){
			closeFrame();
		}
	}

	window.addEventListener('message', respondParent, false);

})();
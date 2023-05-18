window.onload = function () {
	// Forgot Form
	if (document.getElementById('formForgot')) {
		var formForgot = document.getElementById('formForgot');
		var eventType = 'submit';
		var functionName = forgotRequest;

		if (formForgot.addEventListener) {
			// DOM Browsers
			formForgot.addEventListener(eventType, functionName, false);
		} else if (formForgot.attachEvent) {
			// IE
			formForgot.attachEvent('on' + eventType, functionName);
		} else {
			// other browsers
			formForgot['on' + eventType] = functionName;
		}
	}
	// Forgot Contact
	if (document.getElementById('formContact')) {
		var formContact = document.getElementById('formContact');
		var eventType = 'submit';
		var functionName = contactRequest;

		if (formContact.addEventListener) {
			// DOM Browsers
			formContact.addEventListener(eventType, functionName, false);
		} else if (formContact.attachEvent) {
			// IE
			formContact.attachEvent('on' + eventType, functionName);
		} else {
			// other browsers
			formContact['on' + eventType] = functionName;
		}
	}
};

// Initialize Request Object for AJAX
function inicializa_xhr() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		return new ActiveXObject('Microsoft.XMLHTTP');
	}
}

// Forgot form request
function forgotRequest(e) {
	var event = e || window.event;
	formLoadingAsync(document.getElementById('bForgot'), 'Resetting password...', 'btnCloseForgot');

	event.preventDefault();
	peticion_http = inicializa_xhr();
	if (peticion_http) {
		var emailValue = document.getElementById('forgotModalFocus').value;
		var oldPasswValue = document.getElementById('forgotModalPassw').value;
		console.log(emailValue + ', ' + oldPasswValue);
		var url = 'index.php?ctl=forgot';
		var params = 'email=' + emailValue + '&oldpassw=' + oldPasswValue;
		var func = processForgot;
		peticion_http.onreadystatechange = func;
		peticion_http.open('POST', url, true);
		peticion_http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		peticion_http.send(params);
	}
}

// Process forgot form -> Receive & Distribute Data to Document
function processForgot() {
	if (peticion_http.readyState == READY_STATE_COMPLETE) {
		if (peticion_http.status == 200) {
			console.log('Peticion: ' + peticion_http.responseText);
			var jsonResponse = JSON.parse(peticion_http.responseText);
			if (jsonResponse.message != '') {
				console.log(jsonResponse);
				var bForgot = document.getElementById('bForgot');
				var forgotAppend = document.getElementById('forgotAppend');
				forgotAppend.innerHTML = '';
				var divAlert = document.createElement('div');
				divAlert.setAttribute('class', 'alert alert-info p-1 mt-2 mb-1 text-center');
				divAlert.setAttribute('role', 'alert');
				divAlert.setAttribute('id', 'forgotAlert');

				var iconAlert = document.createElement('i');
				iconAlert.setAttribute('class', 'bi bi-info-circle me-2');

				divAlert.appendChild(iconAlert);
				divAlert.appendChild(document.createTextNode(jsonResponse.message));
				forgotAppend.appendChild(divAlert);
				document.getElementById('formForgot').reset();
				stopFormLoading(bForgot, 'Reset Password', 'bi bi-arrow-clockwise ms-2');
			} else {
				alert('Error while processing data.');
			}
		}
	}
}

// Forgot form request
function contactRequest(e) {
	var event = e || window.event;
	formLoadingAsync(document.getElementById('bContact'), 'Sending message...');

	event.preventDefault();
	peticion_http = inicializa_xhr();
	if (peticion_http) {
		var nameValue = document.getElementById('contactName').value;
		var lastnameValue = document.getElementById('contactLastname').value;
		var emailValue = document.getElementById('contactEmail').value;
		var subjectValue = document.getElementById('contactSubject').value;
		var contentValue = document.getElementById('contactMessage').value;
		console.log(contentValue);
		var url = 'index.php?ctl=contact';
		var params =
			'name=' + nameValue + '&lastname=' + lastnameValue + '&email=' + emailValue + '&subject=' + subjectValue + '&content=' + contentValue;
		var func = processContact;
		peticion_http.onreadystatechange = func;
		peticion_http.open('POST', url, true);
		peticion_http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		peticion_http.send(params);
	}
}

// Process contact form -> Receive & Distribute Data to Document
function processContact() {
	if (peticion_http.readyState == READY_STATE_COMPLETE) {
		if (peticion_http.status == 200) {
			console.log('Peticion: ' + peticion_http.responseText);
			var jsonResponse = JSON.parse(peticion_http.responseText);
			if (jsonResponse.message != '' || jsonResponse.error != '') {
				console.log(jsonResponse);
				var bContact = document.getElementById('bContact');
				var contactAppend = document.getElementById('contactAppend');
				contactAppend.innerHTML = '';
				var divAlert = document.createElement('div');
				divAlert.setAttribute('class', 'alert alert-info p-1 mt-2 mb-1 text-center');
				divAlert.setAttribute('role', 'alert');
				divAlert.setAttribute('id', 'contactAlert');

				var iconAlert = document.createElement('i');
				iconAlert.setAttribute('class', 'bi bi-info-circle me-2');

				divAlert.appendChild(iconAlert);
				divAlert.appendChild(document.createTextNode(jsonResponse.message != '' ? jsonResponse.message : jsonResponse.error));
				contactAppend.appendChild(divAlert);
				document.getElementById('formContact').reset();
				stopFormLoading(bContact, 'Send Message');
			} else {
				alert('Error while processing data.');
			}
		}
	}
}

// Generic user request -> allows reuse
function userRequest(url, params, func) {
	peticion_http = inicializa_xhr();
	if (peticion_http) {
		var url = 'index.php?ctl=login';
		var params = 'orem=ipsum&name=binny';
		peticion_http.onreadystatechange = func;
		peticion_http.open('POST', url, true);
		peticion_http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		peticion_http.send(params);
	}
}

function stopFormLoading(formBtn, content, iconClass = null) {
	console.log('Stop form loading: ' + formBtn);
	// retrieve submit button (html element), button text content & icon class (optional)
	formBtn.innerHTML = '';

	formBtn.appendChild(document.createTextNode(content));
	if (iconClass) {
		icon = document.createElement('i');
		icon.setAttribute('class', iconClass);
		formBtn.appendChild(icon);
	}
	formBtn.removeAttribute('disabled');

	closeBtnList = document.getElementsByClassName('btn-close');
	for (let closeBtn of closeBtnList) {
		closeBtn.removeAttribute('disabled');
	}
}

function formLoadingAsync(formBtn, btnContent, btnCloseId = null) {
	console.log('BTN ELEMENT');
	console.log(formBtn);

	formBtn.innerHTML = '';
	//event.preventDefault();
	spinner = document.createElement('span');
	screenReaderSpan = document.createElement('span');
	screenReaderSpan.appendChild(document.createTextNode(btnContent));
	screenReaderSpan.setAttribute('class', 'visually-hidden');

	spinner.setAttribute('class', 'spinner-border spinner-border-sm me-2');
	spinner.setAttribute('role', 'status');
	spinner.setAttribute('aria-hidden', 'true');

	formBtn.appendChild(screenReaderSpan);
	formBtn.appendChild(spinner);
	formBtn.appendChild(document.createTextNode(btnContent));
	formBtn.setAttribute('disabled', 'true');

	// If there is modal close button, remove disabled.
	if (btnCloseId) {
		btnClose = document.getElementById(btnCloseId);
		btnClose.setAttribute('disabled', 'true');
	}
}

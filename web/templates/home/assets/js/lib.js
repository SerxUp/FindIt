var READY_STATE_COMPLETE = 4;
$(document).ready(function () {
	var activeUrl = window.location.href;
	var splitUrl = activeUrl.split('=');
	console.log(window.location);
	/********** AJAX ONLOAD ****************/
	if (splitUrl[1] == 'adminUsers') {
		listUsers();
		var selectTags = document.getElementById('inputGroupSelectTag');
		selectTags.onclick = createTags;
		selectTagsFull = document.getElementsByTagName('select')[0];
		console.log('hola');
		console.log(selectTagsFull.value);
		// Input Disabled Toggle - Privada
		var tipoEvento = 'change';
		funcion = listUsers;
		if (selectTagsFull.addEventListener) {
			// navegadores DOM
			selectTagsFull.addEventListener(tipoEvento, funcion, false);
		} else if (selectTagsFull.attachEvent) {
			// Internet Explorer
			selectTagsFull.attachEvent('on' + tipoEvento, funcion);
		} else {
			// resto de navegadores
			selectTagsFull['on' + tipoEvento] = funcion;
		}

		// Varying Disable Modal **IMPORTANT**
		const disableModal = document.getElementById('disableModal');
		disableModal.addEventListener('show.bs.modal', (event) => {
			// Button that triggered the modal
			const button = event.relatedTarget;
			// Extract info from data-bs-* attributes
			const recipient = button.getAttribute('data-bs-whatever');
			// If necessary, you could initiate an AJAX request here
			// and then do the updating in a callback.
			//
			// Update the modal's content.
			const modalTitle = disableModal.querySelector('.modal-title');
			const modalTitleInput = disableModal.querySelector('.modal-header input');
			const modalBodyParagraph = disableModal.querySelector('.modal-body p');

			modalTitle.textContent = `Disable \"${recipient}\"?`;
			modalTitleInput.value = recipient;
			modalBodyParagraph.innerHTML =
				'This action will disable the selected user: ' +
				recipient +
				'. And that user will not be able to use their account until it is enabled.';
		});

		// Varying Disable Modal **IMPORTANT**
		const enableModal = document.getElementById('enableModal');
		enableModal.addEventListener('show.bs.modal', (event) => {
			// Button that triggered the modal
			const button = event.relatedTarget;
			// Extract info from data-bs-* attributes
			const recipient = button.getAttribute('data-bs-whatever');
			// If necessary, you could initiate an AJAX request here
			// and then do the updating in a callback.
			//
			// Update the modal's content.
			const modalTitle = enableModal.querySelector('.modal-title');
			const modalTitleInput = enableModal.querySelector('.modal-header input');
			const modalBodyParagraph = enableModal.querySelector('.modal-body p');

			modalTitle.textContent = `Enable \"${recipient}\"?`;
			modalTitleInput.value = recipient;
			modalBodyParagraph.innerHTML =
				'This action will enable the selected user: ' + recipient + '. And that user will be able to use their account again.';
		});

		// Filter Users
		var tipoEvento = 'submit';
		funcion = searchUser;
		if (document.getElementById('formSearchUser') && document.getElementById('bSearchUser')) {
			var formSearchUser = document.getElementById('formSearchUser');
			var bSearchUser = document.getElementById('bEnableUser');

			if (formSearchUser.addEventListener) {
				// navegadores DOM
				formSearchUser.addEventListener(tipoEvento, funcion, false);
			} else if (formSearchUser.attachEvent) {
				// Internet Explorer
				formSearchUser.attachEvent('on' + tipoEvento, funcion4);
			} else {
				// resto de navegadores
				formSearchUser['on' + tipoEvento] = funcion;
			}
		}
		// Filter Users with TAGS AJAX
		//onchange select value
	}

	// Form Submit
	if (document.getElementsByClassName('form-submit')) {
		var formBtnList = document.getElementsByClassName('form-submit');
		var formList = document.getElementsByTagName('form');
		console.log(formBtnList);
		console.log(formList);

		var eventType = 'submit';
		var functionName = formLoading;

		for (let formElement of formList) {
			console.log(formElement.id);
			if (formElement.addEventListener) {
				// DOM Browsers
				formElement.addEventListener(eventType, functionName, false);
			} else if (formElement.attachEvent) {
				// IE
				formElement.attachEvent('on' + eventType, functionName);
			} else {
				// other browsers
				formElement['on' + eventType] = functionName;
			}
		}
	}
	// END Form Submit
	// Form Click AJAX
	if (document.getElementById('bForgot')) {
		var formBtn = document.getElementById('bForgot'); //change to form click class
		var formElement = document.getElementById('formForgot');
		console.log('AJAX: ' + formBtn);

		var eventType = 'click';
		var functionName = formLoading;

		if (formBtn.addEventListener) {
			// DOM Browsers
			formBtn.addEventListener(eventType, functionName, false);
		} else if (formBtn.attachEvent) {
			// IE
			formBtn.attachEvent('on' + eventType, functionName);
		} else {
			// other browsers
			formBtn['on' + eventType] = functionName;
		}
	}
	// END Form Click AJAX
	// Show Password Checkbox
	console.log('hola1');
});

// Loading spinner inside input when submitted
function formLoading(e) {
	var event = e || window.event;
	console.log(event.type);
	// The button clicked
	var formElement = event.target;
	console.log(formElement);
	console.log('ID:' + formElement.id);
	// Content to show in button
	var btnContent = ' Loading...';
	if (event.type === 'submit') {
		// All modal submit buttons (in case that there is an error getting the specific button)
		var formBtnList = document.getElementsByClassName('form-submit');
		// If formElement is correct, apply only to specific
		switch (formElement.id) {
			case 'formLogin':
				btnContent = 'Signing in...';
				btnCloseId = 'btnCloseLogin';

				userLogin = document.getElementById('loginModalFocus');
				userPassw = document.getElementById('loginModalPassword');
				break;
			case 'formSignup':
				btnContent = 'Signing Up...';
				btnCloseId = 'btnCloseSignup';

				emailForgot = document.getElementById('signupModalFocus');
				break;
			case 'formForgot':
				btnContent = 'Resetting password...';
				btnCloseId = 'btnCloseForgot';

				emailForgot = document.getElementById('forgotModalFocus');
				console.log(emailForgot.value);
				break;
			case 'formContact':
				btnContent = 'Sending message...';
				btnCloseId = 'btnCloseContact';

				emailForgot = document.getElementById('forgotModalFocus');
				console.log(emailForgot.value);
				break;
			case 'formNewsletter':
				btnContent = 'Subscribing...';
				btnCloseId = 'btnCloseNewsletter';

				emailForgot = document.getElementById('forgotModalFocus');
				console.log(emailForgot.value);
				break;
			default:
				allowed = false;
				break;
		}
		if (formElement) {
			formBtn = formElement.getElementsByClassName('form-submit')[0];
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

			closeBtnList = document.getElementsByClassName('btn-close');
			for (let closeBtn of closeBtnList) {
				closeBtn.setAttribute('disabled', 'true');
			}
		} else {
			for (let formBtn of formBtnList) {
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

				closeBtnList = document.getElementsByClassName('btn-close');
				for (let closeBtn of closeBtnList) {
					closeBtn.setAttribute('disabled', 'true');
				}
			}
		}
	} else if (event.type === 'click') {
		// All modal submit buttons (in case that there is an error getting the specific button)
		var formBtnList = document.getElementsByClassName('form-click');
		// If formElement is correct, apply only to specific
		switch (formElement.id) {
			case 'formForgot':
				btnContent = 'Resetting password...';
				btnCloseId = 'btnCloseForgot';
				formBtn = document.getElementById('bForgot');
				break;
			case 'formContact':
				btnContent = 'Sending message...';
				btnCloseId = 'btnCloseContact';
				formBtn = document.getElementById('bContact');
				break;
			default:
				allowed = false;
				break;
		}
		if (formElement) {
			console.log('holita');
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

			/*closeBtnList = document.getElementsByClassName('btn-close');
			for (let closeBtn of closeBtnList) {
				closeBtn.setAttribute('disabled', 'true');
			}*/
		} else {
			for (let formBtn of formBtnList) {
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

				closeBtnList = document.getElementsByClassName('btn-close');
				for (let closeBtn of closeBtnList) {
					closeBtn.setAttribute('disabled', 'true');
				}
			}
		}
	}
}

function stopFormLoading(formBtn, content, iconClass = null) {
	console.log('Stop form loading: ' + formBtn);
	// retrieve submit button (html element), button text content & icon class (optional)
	formBtn.innerHTML = '';

	formBtn.appendChild(document.createTextNode(content));
	if (iconClass != null) {
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

/********** AJAX FUNCTIONS ****************/
// Initialize Request Object for AJAX
function inicializa_xhr() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		return new ActiveXObject('Microsoft.XMLHTTP');
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

function postVisibility(id, vis, func) {
	peticion_http = inicializa_xhr();
	if (peticion_http) {
		var url = 'index.php?ctl=postVisibility&id=' + id + '&vis=' + vis;
		var params = 'id=' + id + '&vis=' + vis;
		peticion_http.onreadystatechange = func;
		peticion_http.open('POST', url, true);
		peticion_http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		peticion_http.send(params);
	}
}

// Process User Signup -> Receive & Distribute Data to Document
function processVisibility() {
	if (peticion_http.readyState == READY_STATE_COMPLETE) {
		if (peticion_http.status == 200) {
			console.log('Peticion: ' + peticion_http.responseText);
			var jsonResponse = JSON.parse(peticion_http.responseText);
			if (jsonResponse) {
				switch (jsonResponse) {
				}
			}

			/* Rest of options
			for (let i = 0; i < jsonResponse.length; i++) {
				var selectElement = document.getElementById('inputGroupSelectTagFull');
				var optionElement = document.createElement('option');
				optionElement.value = jsonResponse[i].idTag;
				optionElement.innerText = jsonResponse[i].tagName;
				selectElement.appendChild(optionElement);
			}*/
		}
	}
}

// Process User Signup -> Receive & Distribute Data to Document
function processUserSignup() {
	if (peticion_http.readyState == READY_STATE_COMPLETE) {
		if (peticion_http.status == 200) {
			console.log('Peticion: ' + peticion_http.responseText);
			var jsonResponse = JSON.parse(peticion_http.responseText);

			/* Rest of options
			for (let i = 0; i < jsonResponse.length; i++) {
				var selectElement = document.getElementById('inputGroupSelectTagFull');
				var optionElement = document.createElement('option');
				optionElement.value = jsonResponse[i].idTag;
				optionElement.innerText = jsonResponse[i].tagName;
				selectElement.appendChild(optionElement);
			}*/
		}
		stopFormLoading(document.getElementById('bSignup'), 'Sign up');
	}
}

// Filter Users - Admin Page
function createTags() {
	if ((selectTags = document.getElementById('inputGroupSelectTag'))) {
		peticion_http = inicializa_xhr();
		if (peticion_http) {
			peticion_http.onreadystatechange = procesaCreateTags;
			peticion_http.open('POST', 'index.php?ctl=createTags', true);
			peticion_http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			peticion_http.send();
		}
		selectTags.setAttribute('id', 'inputGroupSelectTagFull');
	}
}

// Process Filter Tags -> Receive & Distribute Data to Document
function procesaCreateTags() {
	if (peticion_http.readyState == READY_STATE_COMPLETE) {
		if (peticion_http.status == 200) {
			console.log('Peticion: ' + peticion_http.responseText);
			var jsonResponse = JSON.parse(peticion_http.responseText);

			// Rest of options
			for (let i = 0; i < jsonResponse.length; i++) {
				var selectElement = document.getElementById('inputGroupSelectTagFull');
				var optionElement = document.createElement('option');
				optionElement.value = jsonResponse[i].idTag;
				optionElement.innerText = jsonResponse[i].tagName;
				selectElement.appendChild(optionElement);
			}
		}
	}
}

// List Forum - (function is tag dependent)
function listForums() {
	var filtro = '1';
	if ((selectTags = document.getElementById('inputTagForumFull'))) {
		filtro = selectTags.value;
	}

	peticion_http = inicializa_xhr();
	if (peticion_http) {
		peticion_http.onreadystatechange = procesaListUsers;
		peticion_http.open('POST', 'index.php?ctl=listForums', true);
		peticion_http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		peticion_http.send('filtro=' + filtro);
	}
}
// Process List Forum Info -> Receive & Distribute Data to Document
function procesaListForums() {
	if (peticion_http.readyState == READY_STATE_COMPLETE) {
		if (peticion_http.status == 200) {
			console.log('Peticion: ' + peticion_http.responseText);
			//Empty tBody for new results
			var tBody = document.getElementById('tbody');
			console.log(tBody.getElementsByTagName('tr'));
			console.log(tBody.lastChild);
			tBodyChildren = tBody.getElementsByTagName('tr');
			while (tBody.hasChildNodes()) {
				tBody.removeChild(tBody.lastChild);
			}

			var jsonResponse = JSON.parse(peticion_http.responseText);
			for (let i = 0; i < jsonResponse.length; i++) {
				// IMPORTANT - Create Card Element
				var trBlock = document.createElement('tr');
				var thIndex = document.createElement('th');

				var tdUser = document.createElement('td');
				var tdName = document.createElement('td');
				var tdEmail = document.createElement('td');
				var tdLastSes = document.createElement('td');
				var tdHabilitada = document.createElement('td');
				var tdButton = document.createElement('td');

				var button = document.createElement('button');
				button.type = 'button';
				if (jsonResponse[i].Habilitada == '1') {
					button.setAttribute('class', 'btn btn-outline-danger');
					button.setAttribute('data-bs-toggle', 'modal');
					button.setAttribute('data-bs-target', '#disableModal');
					button.setAttribute('data-bs-whatever', jsonResponse[i].User);
					//modal toggle
					button.innerHTML = 'Disable';
				} else if (jsonResponse[i].Habilitada == '0') {
					button.setAttribute('class', 'btn btn-outline-success');
					button.setAttribute('data-bs-toggle', 'modal');
					button.setAttribute('data-bs-target', '#enableModal');
					button.setAttribute('data-bs-whatever', jsonResponse[i].User);
					//modal toggle
					button.innerHTML = 'Enable';
				}

				thIndex.setAttribute('class', 'border-end bg-light');
				thIndex.setAttribute('scope', 'row');
				tdButton.setAttribute('class', 'text-center');
				tdButton.setAttribute('scope', 'row');
				tdButton.appendChild(button);

				thIndex.innerHTML = jsonResponse[i].id;
				tdUser.innerHTML = jsonResponse[i].User;
				tdName.innerHTML = jsonResponse[i].Nombre;
				tdEmail.innerHTML = jsonResponse[i].Email;
				tdLastSes.innerHTML = timeConverter(jsonResponse[i].Ult_Ses);
				tdHabilitada.innerHTML = jsonResponse[i].Habilitada;

				trBlock.appendChild(thIndex);
				trBlock.appendChild(tdUser);
				trBlock.appendChild(tdName);
				trBlock.appendChild(tdEmail);
				trBlock.appendChild(tdLastSes);
				trBlock.appendChild(tdHabilitada);
				trBlock.appendChild(tdButton);

				document.getElementById('tbody').appendChild(trBlock);
			}
		}
	}
}

// AUX Function - Unix Formatter
function timeConverter(UNIX_timestamp) {
	var a = new Date(UNIX_timestamp * 1000);
	var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	var year = a.getFullYear();
	var month = months[a.getMonth()];
	var date = a.getDate();
	var hour = a.getHours();
	var min = a.getMinutes();
	var sec = a.getSeconds();
	var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec;
	return time;
}

// Show Login Modal - When showModal=login
$(document).ready(function () {
	var showModal = getUrlParameter('showModal');
	console.log('MODAL: ' + showModal);
	if (showModal) {
		switch (showModal) {
			case 'login':
				$('#loginModal').modal('show');
				break;
			case 'signup':
				$('#signupModal').modal('show');
				break;
			case 'forgot':
				$('#forgotModal').modal('show');
				break;
			default:
				break;
		}
	}

	const loginModal = document.getElementById('loginModal');
	const loginModalFocus = document.getElementById('loginModalFocus');
	loginModal.addEventListener('shown.bs.modal', () => {
		loginModalFocus.focus();
	});

	const signupModal = document.getElementById('signupModal');
	const signupModalFocus = document.getElementById('signupModalFocus');
	signupModal.addEventListener('shown.bs.modal', () => {
		signupModalFocus.focus();
	});

	const forgotModal = document.getElementById('forgotModal');
	const forgotModalFocus = document.getElementById('forgotModalFocus');
	forgotModal.addEventListener('shown.bs.modal', () => {
		forgotModalFocus.focus();
	});
	//Password toggle
	if (document.getElementById('showPassword')) {
		console.log('hola2');

		var showPassword = document.getElementById('showPassword');

		var eventType = 'change';
		var functionName = togglePassword;
		console.log(showPassword);
		if (showPassword.addEventListener) {
			// DOM Browsers
			showPassword.addEventListener(eventType, functionName, false);
		} else if (showPassword.attachEvent) {
			// IE
			showPassword.attachEvent('on' + eventType, functionName);
		} else {
			// other browsers
			showPassword['on' + eventType] = functionName;
		}
	}
});

// Get parameter from URL
var getUrlParameter = function getUrlParameter(sParam) {
	var sPageURL = window.location.search.substring(1),
		sURLVariables = sPageURL.split('&'),
		sParameterName,
		i;
	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
		}
	}
	return false;
};
// Password input type toggle
function togglePassword(e) {
	var event = e || window.event;
	checkbox = event.target;
	var passwordInput = document.getElementById('loginModalPassword');
	if (checkbox.checked == true) {
		passwordInput.type = 'text';
	} else {
		passwordInput.type = 'password';
	}
}

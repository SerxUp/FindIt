window.onload = function () {
  var activeUrl = window.location.href;
  var splitUrl = activeUrl.split('=');

  // Options - Toggle Active State
  optionList = document.getElementsByClassName("optionDropdown");
  var tipoEvento = "mouseenter";
  var tipoEvento2 = "mouseout";
  funcion = toggleActive;
  for (let i = 0; i < optionList.length; i++) {
    if (optionList[i].addEventListener) { // navegadores DOM
      optionList[i].addEventListener(tipoEvento, funcion, false);
      optionList[i].addEventListener(tipoEvento2, funcion, false);
    } else if (optionList[i].attachEvent) { // Internet Explorer
      optionList[i].attachEvent("on" + tipoEvento, funcion);
      optionList[i].attachEvent("on" + tipoEvento2, funcion);
    } else { // resto de navegadores
      optionList[i]["on" + tipoEvento] = funcion;
      optionList[i]["on" + tipoEvento2] = funcion;
    }
  }

  // Loading Spinner - Onsubmit signup form
  if (splitUrl[1] == 'signup') {
    var formSignup = document.getElementById('formSignup');
    var tipoEvento3 = "submit";
    funcion2 = pageLoading;
    if (formSignup.addEventListener) { // navegadores DOM
      formSignup.addEventListener(tipoEvento3, funcion2, false);
    } else if (formSignup.attachEvent) { // Internet Explorer
      formSignup.attachEvent("on" + tipoEvento3, funcion2);
    } else { // resto de navegadores
      formSignup["on" + tipoEvento3] = funcion2;
    }
  }

  // Loading Spinner - Onsubmit forgot form
  if (splitUrl[1] == 'forgot') {
    var formForgot = document.getElementById('formForgot');
    var tipoEvento3 = "submit";
    funcion2 = pageLoading;
    if (formForgot.addEventListener) { // navegadores DOM
      formForgot.addEventListener(tipoEvento3, funcion2, false);
    } else if (formForgot.attachEvent) { // Internet Explorer
      formForgot.attachEvent("on" + tipoEvento3, funcion2);
    } else { // resto de navegadores
      formForgot["on" + tipoEvento3] = funcion2;
    }

  }
  // Loading Spinner - Onsubmit login form
  if (document.getElementById('formLogin')) {
    var formLogin = document.getElementById('formLogin');
    var tipoEvento3 = "submit";
    funcion2 = pageLoading;
    if (formLogin.addEventListener) { // navegadores DOM
      formLogin.addEventListener(tipoEvento3, funcion2, false);
    } else if (formLogin.attachEvent) { // Internet Explorer
      formLogin.attachEvent("on" + tipoEvento3, funcion2);
    } else { // resto de navegadores
      formLogin["on" + tipoEvento3] = funcion2;
    }
  }

  // Password Visibility Toggle - Forms
  var passIds = ["passw", "repassw", "passwInput", "passwReset", "repasswReset"];
  var tipoEvento4 = "click";
  funcion3 = togglePass;
  if (document.getElementsByClassName("viewPass")) {
    var passIcons = document.getElementsByClassName("viewPass");
    for (let i = 0; i < passIcons.length; i++) {
      parentButton = passIcons[i].parentElement;
      if (parentButton.addEventListener) { // navegadores DOM
        parentButton.addEventListener(tipoEvento4, funcion3, false);
      } else if (parentButton.attachEvent) { // Internet Explorer
        parentButton.attachEvent("on" + tipoEvento4, funcion3);
      } else { // resto de navegadores
        parentButton["on" + tipoEvento4] = funcion3;
      }
    }
  }

  // Input Disabled Toggle - Privada
  if (splitUrl[1] == 'privada') {
    var tipoEvento4 = "click";
    funcion4 = toggleDisabled;
    if (document.getElementsByClassName("editInfo")) {
      var icons = document.getElementsByClassName("editInfo");
      console.log("hola2")
      for (let i = 0; i < icons.length; i++) {
        parentButton = icons[i].parentElement;
        if (parentButton.addEventListener) { // navegadores DOM
          parentButton.addEventListener(tipoEvento4, funcion4, false);
        } else if (parentButton.attachEvent) { // Internet Explorer
          parentButton.attachEvent("on" + tipoEvento4, funcion4);
        } else { // resto de navegadores
          parentButton["on" + tipoEvento4] = funcion4;
        }
      }
    }
  }

}

function toggleActive(elEvento) {
  var evento = elEvento || window.event;
  var link = evento.target;
  //console.log(link.tagName);
  if (evento.type == "mouseenter" && link.tagName == 'A') {
    link.setAttribute("class", "dropdown-item text-center text-md-start optionDropdown active");
  } else if (evento.type == "mouseout" && link.tagName == 'A') {
    link.setAttribute("class", "dropdown-item text-center text-md-start optionDropdown");
  }
}

function pageLoading(elEvento) {
  var evento = elEvento || window.event;
  var formulario = evento.target;
  //evento.preventDefault();
  parentDiv = document.createElement('div');
  spinnerDiv = document.createElement('div');
  screenReaderSpan = document.createElement('span');
  screenReaderSpan.appendChild(document.createTextNode('Loading...'));
  console.log(screenReaderSpan);
  parentDiv.setAttribute("class", "text-center");
  spinnerDiv.setAttribute("class", "spinner-border");
  spinnerDiv.setAttribute("role", "status");
  screenReaderSpan.setAttribute("class", "visually-hidden");

  spinnerDiv.appendChild(screenReaderSpan);
  parentDiv.appendChild(spinnerDiv);
  formulario.appendChild(parentDiv);
}

function toggleDisabled(elEvento) {
  var evento = elEvento || window.event;
  clickedElement = evento.target;
  // Check clicked element
  if ((clickedElement.tagName).toLowerCase() == "i") {
    var buttonToggle = evento.target.parentElement;
  } else if ((clickedElement.tagName).toLowerCase() == "button") {
    var buttonToggle = evento.target;
  }
  // Get input element
  var parentDiv = buttonToggle.parentElement;
  var inputText = parentDiv.children[1];
  console.log(inputText);
  console.log(inputText.type);
  // Change disabled to false
  if (inputText.disabled) {
    inputText.disabled = false;
    inputText.focus();

    $('#bSaveChanges').prop('disabled', false); // jQuery
  } else {
    inputText.disabled = true;
  }
}

function togglePass(elEvento) {
  var evento = elEvento || window.event;
  clickedElement = evento.target;
  // Check clicked element
  if ((clickedElement.tagName).toLowerCase() == "i") {
    var buttonToggle = evento.target.parentElement;
  } else if ((clickedElement.tagName).toLowerCase() == "button") {
    var buttonToggle = evento.target;
  }
  // Get input password element
  var parentDiv = buttonToggle.parentElement;
  var inputPass = parentDiv.children[0];
  var icon = buttonToggle.children[0];
  console.log(inputPass);
  console.log(inputPass.type);
  // Change type to text or back to password and change icon
  if (inputPass.type == "password") {
    inputPass.type = "text";
    icon.setAttribute("class", "bi bi-eye viewPass");
  } else if (inputPass.type == "text") {
    inputPass.type = "password";
    icon.setAttribute("class", "bi bi-eye-slash viewPass");
  }


}

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
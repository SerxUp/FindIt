// Global Variables (CONFIG)
var READY_STATE_COMPLETE = 4;
var peticion_http = null;

// Limit of results for pages
var maxResults = 20;
// Last result index (for pagination)
var lastResult = 0;

//ArrayArmasMonster
var armasMonster = [];
//ArrayAptitudesMonster
var aptitudesMonster = [];
//ArrayTipos
var tiposMonster = [];
//ArrayDotes
var dotesMonster = [];
//ArrayTamanyos
var sizeMonster = [];
// ---------------------
window.onload = function () {
  var activeUrl = window.location.href;
  var splitUrl = activeUrl.split('=');
  /********** AJAX ONLOAD ****************/
  if (splitUrl[1] == 'adminUsers') {
    listUsers();
    var selectTags = document.getElementById('inputGroupSelectTag');
    selectTags.onclick = createTags;
    selectTagsFull = document.getElementsByTagName('select')[0];
    console.log('hola');
    console.log(selectTagsFull.value);
    // Input Disabled Toggle - Privada
    var tipoEvento = "change";
    funcion = listUsers;
    if (selectTagsFull.addEventListener) { // navegadores DOM
      selectTagsFull.addEventListener(tipoEvento, funcion, false);
    } else if (selectTagsFull.attachEvent) { // Internet Explorer
      selectTagsFull.attachEvent("on" + tipoEvento, funcion);
    } else { // resto de navegadores
      selectTagsFull["on" + tipoEvento] = funcion;
    }

    // Varying Disable Modal **IMPORTANT**
    const disableModal = document.getElementById('disableModal')
    disableModal.addEventListener('show.bs.modal', event => {
      // Button that triggered the modal
      const button = event.relatedTarget
      // Extract info from data-bs-* attributes
      const recipient = button.getAttribute('data-bs-whatever')
      // If necessary, you could initiate an AJAX request here
      // and then do the updating in a callback.
      //
      // Update the modal's content.
      const modalTitle = disableModal.querySelector('.modal-title')
      const modalTitleInput = disableModal.querySelector('.modal-header input')
      const modalBodyParagraph = disableModal.querySelector('.modal-body p')

      modalTitle.textContent = `Disable \"${recipient}\"?`
      modalTitleInput.value = recipient;
      modalBodyParagraph.innerHTML = "This action will disable the selected user: " + recipient + ". And that user will not be able to use their account until it is enabled."
    })

    // Varying Disable Modal **IMPORTANT**
    const enableModal = document.getElementById('enableModal')
    enableModal.addEventListener('show.bs.modal', event => {
      // Button that triggered the modal
      const button = event.relatedTarget
      // Extract info from data-bs-* attributes
      const recipient = button.getAttribute('data-bs-whatever')
      // If necessary, you could initiate an AJAX request here
      // and then do the updating in a callback.
      //
      // Update the modal's content.
      const modalTitle = enableModal.querySelector('.modal-title')
      const modalTitleInput = enableModal.querySelector('.modal-header input')
      const modalBodyParagraph = enableModal.querySelector('.modal-body p')

      modalTitle.textContent = `Enable \"${recipient}\"?`
      modalTitleInput.value = recipient;
      modalBodyParagraph.innerHTML = "This action will enable the selected user: " + recipient + ". And that user will be able to use their account again."
    })

    // Filter Users
    var tipoEvento = "submit";
    funcion = searchUser;
    if (document.getElementById("formSearchUser") && document.getElementById("bSearchUser")) {
      var formSearchUser = document.getElementById("formSearchUser");
      var bSearchUser = document.getElementById("bEnableUser");

      if (formSearchUser.addEventListener) { // navegadores DOM
        formSearchUser.addEventListener(tipoEvento, funcion, false);
      } else if (formSearchUser.attachEvent) { // Internet Explorer
        formSearchUser.attachEvent("on" + tipoEvento, funcion4);
      } else { // resto de navegadores
        formSearchUser["on" + tipoEvento] = funcion;
      }
    }
    // Filter Users with TAGS AJAX
    //onchange select value
  }
  /********** END AJAX ONLOAD ***********/
  /********** DOM ONLOAD ****************/
  if (splitUrl[1] == 'privada') {
    userInfo();
    // Input Disabled Toggle - Privada
    var tipoEvento4 = "click";
    funcion4 = toggleDisabled;
    if (document.getElementsByClassName("editInfo")) {
      var icons = document.getElementsByClassName("editInfo");
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
  // Options - Toggle Active State
  if (optionList = document.getElementsByClassName("optionDropdown")) {
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
  // Loading Spinner - Onsubmit contact form
  if (document.getElementById('formContact')) {
    var formLogin = document.getElementById('formContact');
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

  if (splitUrl[1].indexOf("createMonster") != -1) {

    selectTipos();
    selectTamanyos();

    arma = document.getElementById("newArma");
    aptitud = document.getElementById("newAptitud");
    dote = document.getElementById("newDote");
    selectTipo = document.getElementById("tipoSelect");
    nivel = document.getElementById("nivel");
    fuerzaCar = document.getElementById("fue");
    destrezaCar = document.getElementById("des");
    constitucionCar = document.getElementById("cons");
    sabiduriaCar = document.getElementById("sab");
    inteligenciaCar = document.getElementById("int");
    carismaCar = document.getElementById("car");
    tamanyo = document.getElementById("tamanyoSelect");
    if (document.addEventListener) { // navegadores DOM
      arma.addEventListener("click", monsterInfoArmas, false);
      aptitud.addEventListener("click", monsterInfoAptitudes, false);
      dote.addEventListener("click", monsterInfoDotes, false);
      selectTipo.addEventListener("change", rellenaDatos, false);
      nivel.addEventListener("input", rellenaDatos, false);
      fuerzaCar.addEventListener("change", rellenaDatos, false);
      destrezaCar.addEventListener("change", rellenaDatos, false);
      constitucionCar.addEventListener("change", rellenaDatos, false);
      sabiduriaCar.addEventListener("change", rellenaDatos, false);
      inteligenciaCar.addEventListener("change", rellenaDatos, false);
      carismaCar.addEventListener("change", rellenaDatos, false);
      tamanyo.addEventListener("change", rellenaDatos, false);
    } else if (document.attachEvent) { // Internet Explorer
      arma.attachEvent("on" + "click", monsterInfoArmas);
      aptitud.attachEvent("on" + "click", monsterInfoDotes);
      dote.attachEvent("on" + "click", monsterInfoDotes);
      selectTipo.attachEvent("on" + "change", rellenaDatos);
      nivel.attachEvent("on" + "input", rellenaDatos);
      fuerzaCar.attachEvent("on" + "change", rellenaDatos);
      destrezaCar.attachEvent("on" + "change", rellenaDatos);
      constitucionCar.attachEvent("on" + "change", rellenaDatos);
      sabiduriaCar.attachEvent("on" + "change", rellenaDatos);
      inteligenciaCar.attachEvent("on" + "change", rellenaDatos);
      carismaCar.attachEvent("on" + "change", rellenaDatos);
      tamanyo.attachEvent("on" + "change", rellenaDatos);
    } else { // resto de navegadores
      arma["on" + "click"] = monsterInfoArmas;
      aptitud["on" + "click"] = monsterInfoAptitudes;
      dote["on" + "click"] = monsterInfoDotes;
      selectTipo["on" + "change"] = rellenaDatos;
      nivel["on" + "input"] = rellenaDatos;
      fuerzaCar["on" + "input"] = rellenaDatos;
      destrezaCar["on" + "input"] = rellenaDatos;
      constitucionCar["on" + "input"] = rellenaDatos;
      sabiduriaCar["on" + "input"] = rellenaDatos;
      inteligenciaCar["on" + "input"] = rellenaDatos;
      carismaCar["on" + "input"] = rellenaDatos;
      tamanyo["on" + "input"] = rellenaDatos;
    }

  }

  /********** END DOM ONLOAD **************/
}
/********** AJAX FUNCTIONS ****************/
// Initialize Request Object for AJAX
function inicializa_xhr() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
}

// User Info - My Profile Page
function userInfo() {
  peticion_http = inicializa_xhr();
  if (peticion_http) {
    peticion_http.onreadystatechange = procesaUserInfo;
    peticion_http.open("POST", "index.php?ctl=userInfo", true);
    peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    peticion_http.send();
  }
}
// Process User Info -> Receive & Distribute Data to Document
function procesaUserInfo() {
  if (peticion_http.readyState == READY_STATE_COMPLETE) {
    if (peticion_http.status == 200) {
      var username = document.getElementById("username");
      // Count number of ocurrences of user id in other tables
      var userTopics = document.getElementById("userTopics");
      var userMonsters = document.getElementById("userMonsters");
      var userComments = document.getElementById("userComments");

      var nombre = document.getElementById("name");
      var lastname = document.getElementById("lastname");
      var email = document.getElementById("email");
      var town = document.getElementById("town");
      var descripcion = document.getElementById("descripcion");
      console.log(descripcion);

      console.log("Peticion: " + peticion_http.responseText);
      var jsonResponse = JSON.parse(peticion_http.responseText);

      username.innerHTML = jsonResponse.User;
      nombre.value = jsonResponse.Nombre;
      lastname.value = jsonResponse.Apellidos;
      email.value = jsonResponse.Email;
      town.value = jsonResponse.Municipio;
      descripcion.value = jsonResponse.Descripcion;
    }
  }
}

// List Users - Admin Page
function listUsers() {
  var filtro = '1';
  if (selectTags = document.getElementById('inputGroupSelectTagFull')) {
    filtro = selectTags.value;
  }

  peticion_http = inicializa_xhr();
  if (peticion_http) {
    peticion_http.onreadystatechange = procesaListUsers;
    peticion_http.open("POST", "index.php?ctl=listUsers", true);
    peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    peticion_http.send('filtro=' + filtro);
  }
}
// Process List User Info -> Receive & Distribute Data to Document
function procesaListUsers() {
  if (peticion_http.readyState == READY_STATE_COMPLETE) {
    if (peticion_http.status == 200) {

      console.log("Peticion: " + peticion_http.responseText);
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

// Filter Users - Admin Page
function createTags() {
  if (selectTags = document.getElementById('inputGroupSelectTag')) {
    peticion_http = inicializa_xhr();
    if (peticion_http) {
      peticion_http.onreadystatechange = procesaCreateTags;
      peticion_http.open("POST", "index.php?ctl=createTags", true);
      peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      peticion_http.send();
    }
    selectTags.setAttribute('id', 'inputGroupSelectTagFull');
  }
}

// Process Filter Tags -> Receive & Distribute Data to Document
function procesaCreateTags() {
  if (peticion_http.readyState == READY_STATE_COMPLETE) {
    if (peticion_http.status == 200) {

      console.log("Peticion: " + peticion_http.responseText);
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

// List Users - Admin Page
function searchUser(elEvento) {
  var evento = elEvento || window.event;
  formElement = evento.target;
  peticion_http = inicializa_xhr();
  if (peticion_http) {
    var filter = document.getElementById("userFilter").value;
    peticion_http.onreadystatechange = procesaSearchUser;
    // Send data with POST
    peticion_http.open("POST", "index.php?ctl=searchUser", true);
    peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    peticion_http.send('filter=' + filter);
  }
  evento.preventDefault();
}
// Process List User Info -> Receive & Distribute Data to Document
function procesaSearchUser() {
  if (peticion_http.readyState == READY_STATE_COMPLETE) {
    if (peticion_http.status == 200) {
      //Empty tBody for new results
      var tBody = document.getElementById('tbody');
      console.log(tBody.getElementsByTagName('tr'));
      console.log(tBody.lastChild);
      tBodyChildren = tBody.getElementsByTagName('tr');
      while (tBody.hasChildNodes()) {
        tBody.removeChild(tBody.lastChild);
      }

      console.log("Peticion: " + peticion_http.responseText);
      var jsonResponse = JSON.parse(peticion_http.responseText);

      if (jsonResponse.length > 0) {

        for (let i = 0; i < jsonResponse.length; i++) {
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
      } else {
        var trBlock = document.createElement('tr');
        var tdNotFound = document.createElement('td');
        tdNotFound.innerHTML = jsonResponse.NotFound;
        trBlock.appendChild(tdNotFound);
        document.getElementById('tbody').appendChild(trBlock);
      }
    }
  }
}
 

function selectTipos() {
  if (tiposMonster.length == 0) {
    peticion_http = inicializa_xhr();
    if (peticion_http) {
      peticion_http.onreadystatechange = procesaDatosTipos;
      peticion_http.open("POST", "index.php?ctl=selectTipos", true);
      peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      peticion_http.send();
    }
  }
}

function selectTamanyos() {
  if (sizeMonster.length == 0) {
    peticion = inicializa_xhr();
    if (peticion) {
      peticion.onreadystatechange = procesaDatosSize;
      peticion.open("POST", "index.php?ctl=selectTamanyos", true);
      peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      peticion.send();
    }
  }
}

function monsterInfoDotes() {
  if (dotesMonster.length == 0) {
    peticion_http = inicializa_xhr();
    if (peticion_http) {
      peticion_http.onreadystatechange = procesaDotes;
      peticion_http.open("POST", "index.php?ctl=monsterInfoDotes", true);
      peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      peticion_http.send();
    }
  } else {
    procesaDotes();
  }
}

function monsterInfoArmas() {
  if (armasMonster.length == 0) {
    peticion_http = inicializa_xhr();
    if (peticion_http) {
      peticion_http.onreadystatechange = procesaArmas;
      peticion_http.open("POST", "index.php?ctl=monsterInfoArmas", true);
      peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      peticion_http.send();
    }
  } else {
    procesaArmas();
  }
}

function monsterInfoAptitudes() {
  if (aptitudesMonster.length == 0) {
    peticion_http = inicializa_xhr();
    if (peticion_http) {
      peticion_http.onreadystatechange = procesaAptitudes;
      peticion_http.open("POST", "index.php?ctl=monsterInfoAptitudes", true);
      peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      peticion_http.send();
    }
  } else {
    procesaAptitudes();
  }

}

function procesaDatosSize() {
  if (peticion.readyState == READY_STATE_COMPLETE) {
    if (peticion.status == 200) {
      // Count number of ocurrences of user id in other tables

      //console.log("Peticion: " + peticion_http.responseText);
      var jsonResponse = JSON.parse(peticion.responseText);
      sizeMonster = jsonResponse;

      rellenaDatos();
    }
  }
}

function procesaDatosTipos() {
  if (peticion_http.readyState == READY_STATE_COMPLETE) {
    if (peticion_http.status == 200) {
      // Count number of ocurrences of user id in other tables

      //console.log("Peticion: " + peticion_http.responseText);
      var jsonResponse = JSON.parse(peticion_http.responseText);
      tiposMonster = jsonResponse;

      rellenaDatos();
    }
  }
}

function rellenaDatos() {

  if(tiposMonster.length==0 || sizeMonster.length==0){return}
  vida = document.getElementById("vida");
  ataque = document.getElementById("ataque");
  nivel = document.getElementById("nivel");
  fortaleza = document.getElementById("TSFortaleza");
  destreza = document.getElementById("TSDestreza");
  voluntad = document.getElementById("TSVoluntad");
  fuerzaCar = document.getElementById("fue");
  destrezaCar = document.getElementById("des");
  constitucionCar = document.getElementById("cons");
  sabiduriaCar = document.getElementById("sab");
  inteligenciaCar = document.getElementById("int");
  carismaCar = document.getElementById("car");
  ca = document.getElementById("ca");
  dmc = document.getElementById("dmc");
  bmc = document.getElementById("bmc");
  size = document.getElementById("tamanyoSelect");
  TipoSeleccionado = document.getElementById("tipoSelect");

  fue = parseInt(fuerzaCar.value);
  des = parseInt(destrezaCar.value);
  cons = parseInt(constitucionCar.value);
  sab = parseInt(sabiduriaCar.value);
  int = parseInt(inteligenciaCar.value);
  car = parseInt(carismaCar.value);
  bmcCalc = parseInt(bmc.value);
  dmcCalc = parseInt(dmc.value);

  if (isNaN(nivel.value) || parseInt(nivel.value) == 0 || nivel.value > 20) {
    nivel.value = 1;
    nivel.select();
  }

  indiceSizeMonster = 0;

  for (z = 0; z < sizeMonster.length; z++) {
    if (sizeMonster[z].Categoria == size.value) {
      indiceSizeMonster = z;
    }
  }
  for (i = 0; i < tiposMonster.length; i++) {
    if (TipoSeleccionado.value == tiposMonster[i].Nombre) {

      valorSize = size.value;
      numeroNivel = parseInt(nivel.value);

      switch (valorSize) {

        case "Grande": vida.value = (numeroNivel + 1) + "" + tiposMonster[i].TipoDG;
          break;

        case "Enorme": vida.value = (numeroNivel + 2) + "" + tiposMonster[i].TipoDG;
          break;

        case "Gargauntuesco": vida.value = (numeroNivel + 4) + "" + tiposMonster[i].TipoDG;
          break;

        case "Colosal": vida.value = (numeroNivel + 6) + "" + tiposMonster[i].TipoDG;
          break;

        default: vida.value = numeroNivel + "" + tiposMonster[i].TipoDG;
      }

      bonfue = parseInt((fue - 10) / 2);
      bondes = parseInt((des - 10) / 2);


      ataque.value = Math.floor(parseFloat(tiposMonster[i].CalculoATB) * numeroNivel);

      bonAtaque = parseInt(ataque.value);

      bonCA = parseInt(sizeMonster[indiceSizeMonster].Bon_CA);
      bonBMC_DMC = parseInt(sizeMonster[indiceSizeMonster].Mod_BMC_DMC);

      switch (sizeMonster[indiceSizeMonster].Categoria) {

        case "Minusculo": ca.value = 10 + bondes + bonCA;
          dmc.value = 10 + bonfue + bondes + bonAtaque + bonBMC_DMC;
          bmc.value = 10 + bonfue + bonAtaque + bonBMC_DMC;
          break;

        case "Diminuto": ca.value = 10 + bondes + bonCA;
          dmc.value = 10 + bonfue + bondes + bonAtaque + bonBMC_DMC;
          bmc.value = 10 + bonfue + bonAtaque + bonBMC_DMC;
          break;

        case "Menudo": ca.value = 10 + bondes + bonCA;
          dmc.value = 10 + bonfue + bondes + bonAtaque + bonBMC_DMC;
          bmc.value = 10 + bonfue + bonAtaque + bonBMC_DMC;
          break;

        case "Pequeño": ca.value = 10 + bondes + bonCA;
          dmc.value = 10 + bonfue + bondes + bonBMC_DMC;
          bmc.value = 10 + bonfue + bonAtaque + bonBMC_DMC;
          break;

        case "Mediano": ca.value = 10 + bondes + bonCA;
          dmc.value = 10 + bonfue + bondes + bonAtaque + bonBMC_DMC;
          bmc.value = 10 + bonfue + bonAtaque + bonBMC_DMC;
          break;

        case "Grande": ca.value = 10 + bondes + bonCA;
          dmc.value = 10 + bonfue + bondes + bonAtaque + bonBMC_DMC;
          bmc.value = 10 + bonfue + bonAtaque + bonBMC_DMC;
          break;

        case "Enorme": ca.value = 10 + bondes + bonCA;
          dmc.value = 10 + bonfue + bondes + bonAtaque + bonBMC_DMC;
          bmc.value = 10 + bonfue + bonAtaque + bonBMC_DMC;
          break;

        case "Gargauntuesco": ca.value = 10 + bondes + bonCA;
          dmc.value = 10 + bonfue + bondes + bonAtaque + bonBMC_DMC;
          bmc.value = 10 + bonfue + bonAtaque + bonBMC_DMC;
          break;

        case "Colosal": ca.value = 10 + bondes + bonCA;
          dmc.value = 10 + bonfue + bondes + bonAtaque + bonBMC_DMC;
          bmc.value = 10 + bonfue + bonAtaque + bonBMC_DMC;
          break;
      }

      arraySalvaciones = tiposMonster[i].TiradasSalvacion.split(";");

      fortaleza.value = "";
      destreza.value = "";
      voluntad.value = "";
      for (j = 0; j < arraySalvaciones.length; j++) {
        switch (arraySalvaciones[j]) {

          case "FORT": fortaleza.value = Math.floor(numeroNivel * 0.6) + Math.floor((cons - 10) / 2);
            break;

          case "REF": destreza.value = Math.floor(numeroNivel * 0.6) + Math.floor((des - 10) / 2);
            break;

          case "VOL": voluntad.value = Math.floor(numeroNivel * 0.6) + Math.floor((sab - 10) / 2);
            break;
        }
      }
      if (fortaleza.value == "") {
        fortaleza.value = Math.floor(numeroNivel * 0.3) + Math.floor((cons - 10) / 2);
      }
      if (destreza.value == "") {
        destreza.value = Math.floor(numeroNivel * 0.3) + Math.floor((des - 10) / 2);
      }
      if (voluntad.value == "") {
        voluntad.value = Math.floor(numeroNivel * 0.3) + Math.floor((sab - 10) / 2);
      }
    }
  }
}

function procesaAptitudes() {
  if (aptitudesMonster.length == 0) {
    if (peticion_http.readyState == READY_STATE_COMPLETE) {
      if (peticion_http.status == 200) {
        var username = document.getElementById("username");
        // Count number of ocurrences of user id in other tables



        //console.log("Peticion: " + peticion_http.responseText);
        var jsonResponse = JSON.parse(peticion_http.responseText);
        aptitudesMonster = jsonResponse;

      }
    }
  }
  if (aptitudesMonster.length != 0) {

    botonAptitudes = document.getElementById("newAptitud");
    divAptitudes = botonAptitudes.parentElement;
    container = document.createElement("div");
    select = document.createElement("select");
    spandelete = document.createElement("span");
    icondelete = document.createElement("i");
    spaninfo = document.createElement("span");
    iconinfo = document.createElement("i");

    container.setAttribute("class", "input-group");
    spandelete.setAttribute("class", "input-group-text px-2 mt-3 h-25");
    icondelete.setAttribute("class", "bi bi-trash");

    spaninfo.setAttribute("class", "input-group-text mt-3 px-2 h-25");
    spaninfo.setAttribute("data-bs-toggle", "modal");
    spaninfo.setAttribute("data-bs-target", "#infoModal");
    iconinfo.setAttribute("class", "bi bi-info-circle");

    if (document.addEventListener) { // navegadores DOM
      spandelete.addEventListener("click", eliminarSelect, false);
      spaninfo.addEventListener("click", rellenaModalInfo, false);
    } else if (document.attachEvent) { // Internet Explorer
      spandelete.attachEvent("on" + "click", eliminarSelect);
      spaninfo.attachEvent("on" + "click", rellenaModalInfo);
    } else { // resto de navegadores
      spandelete["on" + "click"] = eliminarSelect;
      spaninfo["on" + "click"] = rellenaModalInfo;
    }

    spaninfo.appendChild(iconinfo);
    spandelete.appendChild(icondelete);
    option = document.createElement("option");
    option.text = "Choose one...";
    option.value = -1;
    option.selected = true;
    select.setAttribute("name", "Aptitudes");
    select.appendChild(option);

    for (i = 0; aptitudesMonster.length > i; i++) {
      option = document.createElement("option");
      option.text = aptitudesMonster[i].Nombre;
      option.value = aptitudesMonster[i].id;
      select.appendChild(option);
    }

    container.appendChild(spandelete);
    container.appendChild(spaninfo);
    select.setAttribute("class", "form-select mt-3");
    container.appendChild(select);
    divAptitudes.appendChild(container);
  }
}

function procesaDotes() {
  if (dotesMonster.length == 0) {
    if (peticion_http.readyState == READY_STATE_COMPLETE) {
      if (peticion_http.status == 200) {
        // Count number of ocurrences of user id in other tables

        //console.log("Peticion: " + peticion_http.responseText);
        var jsonResponse = JSON.parse(peticion_http.responseText);
        dotesMonster = jsonResponse;

      }
    }
  }
  if (dotesMonster.length != 0) {

    botonDote = document.getElementById("newDote");
    divDote = botonDote.parentElement;

    container = document.createElement("div");
    select = document.createElement("select");
    spandelete = document.createElement("span");
    icondelete = document.createElement("i");
    spaninfo = document.createElement("span");
    iconinfo = document.createElement("i");

    container.setAttribute("class", "input-group");
    spandelete.setAttribute("class", "input-group-text px-2 mt-3 h-25");
    icondelete.setAttribute("class", "bi bi-trash");

    spaninfo.setAttribute("class", "input-group-text mt-3 px-2 h-25");
    spaninfo.setAttribute("data-bs-toggle", "modal");
    spaninfo.setAttribute("data-bs-target", "#infoModal");
    iconinfo.setAttribute("class", "bi bi-info-circle");

    if (document.addEventListener) { // navegadores DOM
      spandelete.addEventListener("click", eliminarSelect, false);
      spaninfo.addEventListener("click", rellenaModalInfo, false);
    } else if (document.attachEvent) { // Internet Explorer
      spandelete.attachEvent("on" + "click", eliminarSelect);
      spaninfo.attachEvent("on" + "click", rellenaModalInfo);
    } else { // resto de navegadores
      spandelete["on" + "click"] = eliminarSelect;
      spaninfo["on" + "click"] = rellenaModalInfo;
    }

    spaninfo.appendChild(iconinfo);
    spandelete.appendChild(icondelete);
    option = document.createElement("option");
    option.text = "Choose one...";
    option.value = -1;
    option.selected = true;
    select.setAttribute("name", "Dotes");
    select.appendChild(option);

    for (i = 0; dotesMonster.length > i; i++) {
      option = document.createElement("option");
      option.text = dotesMonster[i].Nombre;
      option.value = dotesMonster[i].id;
      select.appendChild(option);
    }

    container.appendChild(spandelete);
    container.appendChild(spaninfo);
    select.setAttribute("class", "form-select mt-3");
    container.appendChild(select);
    divDote.appendChild(container);
  }
}

function procesaArmas() {
  if (armasMonster.length == 0) {
    if (peticion_http.readyState == READY_STATE_COMPLETE) {
      if (peticion_http.status == 200) {
        // Count number of ocurrences of user id in other tables

        //console.log("Peticion: " + peticion_http.responseText);
        var jsonResponse = JSON.parse(peticion_http.responseText);
        armasMonster = jsonResponse;

      }
    }
  }
  if (armasMonster.length != 0) {

    botonArma = document.getElementById("newArma");
    divArmas = botonArma.parentElement;

    container = document.createElement("div");
    select = document.createElement("select");
    spandelete = document.createElement("span");
    icondelete = document.createElement("i");
    spaninfo = document.createElement("span");
    iconinfo = document.createElement("i");

    container.setAttribute("class", "input-group");
    spandelete.setAttribute("class", "input-group-text px-2 mt-3 h-25");
    icondelete.setAttribute("class", "bi bi-trash");

    spaninfo.setAttribute("class", "input-group-text mt-3 px-2 h-25");
    spaninfo.setAttribute("data-bs-toggle", "modal");
    spaninfo.setAttribute("data-bs-target", "#infoModal");
    iconinfo.setAttribute("class", "bi bi-info-circle");

    if (document.addEventListener) { // navegadores DOM
      spandelete.addEventListener("click", eliminarSelect, false);
      spaninfo.addEventListener("click", rellenaModalInfo, false);
    } else if (document.attachEvent) { // Internet Explorer
      spandelete.attachEvent("on" + "click", eliminarSelect);
      spaninfo.attachEvent("on" + "click", rellenaModalInfo);
    } else { // resto de navegadores
      spandelete["on" + "click"] = eliminarSelect;
      spaninfo["on" + "click"] = rellenaModalInfo;
    }

    spaninfo.appendChild(iconinfo);
    spandelete.appendChild(icondelete);
    option = document.createElement("option");
    option.text = "Choose one...";
    option.value = -1;
    option.selected = true;
    select.setAttribute("name", "Armas");
    select.appendChild(option);

    for (i = 0; armasMonster.length > i; i++) {
      option = document.createElement("option");
      option.text = armasMonster[i].Nombre;
      option.value = armasMonster[i].id;
      select.appendChild(option);
    }

    container.appendChild(spandelete);
    container.appendChild(spaninfo);
    select.setAttribute("class", "form-select mt-3");
    container.appendChild(select);
    divArmas.appendChild(container);
  }
}

function rellenaModalInfo(e) {

  evento = e || window.event;

  titulo = document.getElementById("tituloInfoModal");
  info = document.getElementById("informacionModal");
  ataque = document.getElementById("ataque");
  fuerza = document.getElementById("fue");

  bonAtaque = parseInt(ataque.value);
  Fue = parseInt(fuerza.value);
  bonFue = (Fue - 10) / 2;

  tiradaAtaque = bonAtaque + bonFue;

  select = evento.target.nextSibling;
  nombre = select.getAttribute("Name");
  numero = select.value;

  if (numero != -1) {

    if (nombre == "Armas") {
      for (i = 0; i < armasMonster.length; i++) {
        if (armasMonster[i].id == numero) {
          titulo.innerHTML = armasMonster[i].Nombre;

          selectTamanyo = document.getElementById("tamanyoSelect");
          nombreSelected = selectTamanyo.value;

          if (armasMonster[i].TipoDaño == "*") {
            datos = "Daño :" + armasMonster[i][nombreSelected] + "<br>Tipo de Daño : Perforante, Cortante y Contundente <br>Tipo Ataque :" + armasMonster[i].TipoAtaque + " <br>Tirada de Ataque : " + tiradaAtaque;
          } else {
            datos = "Daño :" + armasMonster[i][nombreSelected] + "<br>Tipo de Daño :" + armasMonster[i].TipoDaño + "<br>  Tipo Ataque :" + armasMonster[i].TipoAtaque + "<br>Tirada de Ataque : " + tiradaAtaque;;
          }

          info.innerHTML = datos;
        }
      }
    }
    if (nombre == "Aptitudes") {
      for (i = 0; i < aptitudesMonster.length; i++) {
        if (aptitudesMonster[i].id == numero) {
          titulo.innerHTML = aptitudesMonster[i].Nombre;
          info.innerHTML = aptitudesMonster[i].Descripcion;
        }
      }
    }
    if (nombre == "Dotes") {
      for (i = 0; i < dotesMonster.length; i++) {
        if (dotesMonster[i].id == numero) {
          titulo.innerHTML = dotesMonster[i].Nombre;
          info.innerHTML = "PreRequisitos: " + dotesMonster[i].PreRequisito + "<br> <br> Beneficios: " + dotesMonster[i].Beneficio;
        }
      }
    }

  } else {
    titulo.innerHTML = "Opcion no seleccionada";
    info.innerHTML = "";
  }

}

function eliminarSelect(e) {

  evento = e || window.event;

  evento.target.parentElement.remove();
}
/* Onchange Select Filter Tags
function showCustomer(str) {
  var xhttp;
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "getcustomer.php?q=" + str, true);
  xhttp.send();
}

// Onchange Select Filter Tags
function showCustomer(str) {
  var xhttp;
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "getcustomer.php?q=" + str, true);
  xhttp.send();
}*/

/********** END AJAX FUNCTIONS ***********/
/********** DOM FUNCTIONS ****************/

// Active toggle when hovering dropdown options - Home Page
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

// Loading spinner under form when submitted
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

// Toggle disabled state for inputs - Privada User Info
function toggleDisabled(elEvento) {
  var evento = elEvento || window.event;
  clickedElement = evento.target;
  console.log(clickedElement.tagName);
  // Check clicked element
  if ((clickedElement.tagName).toLowerCase() == "i") {
    var buttonToggle = evento.target.parentElement;
  } else if ((clickedElement.tagName).toLowerCase() == "button") {
    var buttonToggle = evento.target;
  }

  if ((clickedElement.tagName).toLowerCase() == "textarea") {
    $('#bSaveChanges').prop('disabled', false); // jQuery
  } else {
    // Get input element
    var parentDiv = buttonToggle.parentElement;
    var inputText = parentDiv.children[1];
    //console.log(inputText);
    //console.log(inputText.type);
    // Change disabled to false
    if (inputText.disabled) {
      inputText.disabled = false;
      inputText.focus();

      $('#bSaveChanges').prop('disabled', false); // jQuery
    } else {
      inputText.disabled = true;
    }
  }

}

// Toggle input type for passwords
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
/********** END DOM FUNCTIONS ************/

//===========// UNDER DEVELOPMENT SECTION //=========//
// List Forum - (function is tag dependent)
function listForums() {
  var filtro = '1';
  if (selectTags = document.getElementById('inputTagForumFull')) {
    filtro = selectTags.value;
  }

  peticion_http = inicializa_xhr();
  if (peticion_http) {
    peticion_http.onreadystatechange = procesaListUsers;
    peticion_http.open("POST", "index.php?ctl=listForums", true);
    peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    peticion_http.send('filtro=' + filtro);
  }
}
// Process List Forum Info -> Receive & Distribute Data to Document
function procesaListForums() {
  if (peticion_http.readyState == READY_STATE_COMPLETE) {
    if (peticion_http.status == 200) {

      console.log("Peticion: " + peticion_http.responseText);
      //Empty tBody for new results
      var tBody = document.getElementById('tbody');
      console.log(tBody.getElementsByTagName('tr'));
      console.log(tBody.lastChild);
      tBodyChildren = tBody.getElementsByTagName('tr');
      while (tBody.hasChildNodes()) {
        tBody.removeChild(tBody.lastChild);
      }

      var jsonResponse = JSON.parse(peticion_http.responseText);
      for (let i = 0; i < jsonResponse.length; i++) { // IMPORTANT - Create Card Element 
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


// Filter Forums - Admin Page
function createTagsForum() { // not finished
  if (selectTags = document.getElementById('inputTagForum')) {
    peticion_http = inicializa_xhr();
    if (peticion_http) {
      peticion_http.onreadystatechange = procesaCreateTags;
      peticion_http.open("POST", "index.php?ctl=createTagsForum", true);
      peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      peticion_http.send();
    }
    selectTags.setAttribute('id', 'inputTagForumFull');
  }
}

// Process Filter Forum Tags -> Receive & Distribute Data to Document
function procesaCreateTagsForum() { // not finished
  if (peticion_http.readyState == READY_STATE_COMPLETE) {
    if (peticion_http.status == 200) {

      console.log("Peticion: " + peticion_http.responseText);
      var jsonResponse = JSON.parse(peticion_http.responseText);

      // Rest of options
      for (let i = 0; i < jsonResponse.length; i++) {
        var selectElement = document.getElementById('inputTagForumFull');
        var optionElement = document.createElement('option');
        optionElement.value = jsonResponse[i].idTag;
        optionElement.innerText = jsonResponse[i].tagName;
        selectElement.appendChild(optionElement);
      }
    }
  }
}

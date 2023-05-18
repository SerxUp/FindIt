<?php

class Controller
{

    //Método que se encarga de cargar el header que corresponda según el tipo de usuario
    private function loadHeader()
    {
        if ($_SESSION['user_status'] == 0) {
            return 'templates/home/header.php';
        } else if ($_SESSION['user_status'] == 1) {
            return 'templates/userpage/header.php';
        } else if ($_SESSION['user_status'] == 2) {
            return 'templates/userpage/header.php';
        }
    }

    public function home()
    {
        if (isset($_REQUEST['bAcceptCookies'])) {
            setcookie('acceptCookies', "true", horaActual() + 7776000);
            $cookiesAccepted = true;
        }
        if (!recoge('showModal')) {
            $_SESSION['message'] = '';
        }

        // Carga provinces y countries para los selects del signup modal
        try {
            $model = new FindIt();
            $provincesList = $model->getProvincias(231);
            $countriesList = $model->getCountries();
            $postCount = (int)$model->countPosts()['count(topic_id)'];
            $userCount = (int)$model->countUsers()['count(user_id)'];
            $_SESSION['homeLoad'] = true;
        } catch (Exception $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
            header(Config::$location404);
        } catch (Error $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            header(Config::$location404);
        }
        require __DIR__ . '/../../web/templates/home/index.php';
    }

    public function exit()
    {
        session_destroy();
        header(Config::$locationHome);
    }

    public function error()
    {

        $menu = $this->loadHeader();

        require __DIR__ . '/../../web/templates/error.php';
    }
    /* Converted to AJAX
    public function contact()
    {
        $menu = 'headerPublic.php';
        if ($_SESSION['user_status'] < 0) {
            header(Config::$locationHome);
        }

        $params = array(
            'name' => '',
            'lastname' => '',
            'email' => '',
            'info' => '',
        );

        $errores = array();

        $menu = $this->loadHeader();

        if (isset($_POST['bContact']) && isset($_REQUEST["termsAgree"])) {

            $name = recoge("name");
            $lastname = recoge("lastname");
            $email = recoge("email");
            $info = recoge("info");

            cTexto($name, "name", $errores);
            cTexto($lastname, "lastname", $errores);
            cMail($email, "email", $errores);
            cTextarea($info, "info", $errores);

            if (empty($errores)) {

                if (sendMailContact($name, $lastname, $email, $info, $errores)) {
                    $params['emailVerify'] = "Your contact form has been sent successfully. Thank you";
                    header("location:index.php?ctl=home");
                } else {
                    error_log('Error de contact. ' . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                    $errores['validation'] = "We could not send your contact form.<br>Please try again later :(";
                }
            }
        }
        require __DIR__ . '/../../web/templates/contact.php';
    }
    public function forgot()
    {
        $menu = 'headerPublic.php';
        if ($_SESSION['user_status'] > 0) {
            header(Config::$locationHome);
        }

        $params = array('email' => '');
        // Array Errores
        $errores = array();

        if (isset($_REQUEST['bForgot'])) {
            // Recoger todos los datos del formulario
            $email = recoge('email');

            // Check forms fata. Validation using functions from General.php
            try {
                $model = new FindIt(); // FindIt object - database model
                //Check if email & remail are equal; then or valid email or error (nested ternary operator)
                cMail($email, "email", $errores) ? '' : $errores["email"] = "Please enter a valid email.";
                if (empty($errores)) {
                    // Check email against DB
                    $valid = ($model->cMailBD($email) ? true : false);
                    !$valid ? $errores["email"] = "No account linked to that email address." : $params['message'] = "Verification email sent! Please check your inbox & spam folder.";
                } else {
                    $valid = false;
                }
            } catch (Exception $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
                $errores["sql"] = "Unexpected database error.";
                header(Config::$location404);
            } catch (Error $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                $errores["sql"] = "Unexpected database error.";
                header(Config::$location404);
            }

            if (empty($errores) && $valid) {
                // Si no ha habido problema creo modelo y hago inserción     
                try {
                    if ($arrayUser = $model->getUserByMail($email)) {
                        if ($arrayUser['Validada'] == '1' && $arrayUser['Habilitada'] == '1') {
                            $token = '';
                            $mailInfo = array();
                            if ($model->insertarToken($arrayUser['Email'], $token, 900)) {
                                $urlToken = Config::$urlVerifyForgot . $token;
                                if (sendResetPassw($arrayUser, $urlToken, $mailInfo, $errores)) {
                                    $params['emailVerify'] = "A verification email was sent to \"$email\".<br>Please check your email to verify your account.";
                                } else {
                                    $params['emailVerify'] = "We could not send you an email to \"$email\".<br>Please try again later :(";
                                }
                            }
                            header(Config::$locationHome);
                        } else {
                            $errores["emailVerify"] = "This account has not been validated or is disabled. Sorry not sorry ;)";
                            $params["emailVerify"] = "This account has not been validated or is disabled. Sorry not sorry ;)";
                        }
                    } else {
                        $params['message'] = "No account linked to \"" . $email . "\"";
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
                    header(Config::$location404);
                } catch (Error $e) {
                    error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                    header(Config::$location404);
                }
            } else {
                $params = array(
                    'email' => $email,
                );
                $params['message'] = "Something's not right. Please check the form.";
            }
        }
        //echo var_dump($errores);
        //echo var_dump($params);

        require __DIR__ . '/../../web/templates/forgot.php';
    }*/

    public function verifyForgot()
    {
        if ($_SESSION['user_status'] > 0) {
            header(Config::$locationHome);
        }
        $menu = $this->loadHeader();
        $errores = array();
        $token = recoge('token');
        if (strlen($token) == 32) { // Token debe tener longitud de 32 caracteres.
            try {
                $model = new FindIt(); // Objeto FindIt para contrastar datos con la BBDD
                ($arrayToken = $model->getToken($token)) ? $expires = $arrayToken['date_expired'] : $errores['token'] = "Token provided is not valid.";
                //echo var_dump($arrayToken);
                $validation = false;
                if (empty($errores)) {
                    if ($expires > horaActual()) {
                        if ($arrayToken['used'] == '1') {
                            $errores['token'] = "This token has already been used.";
                            $notValid = true;
                        } else {
                            $arrayUser = $model->getUserById($arrayToken['user_id']);
                            if ($arrayUser) {
                                $validation = true;
                            } else {
                                $errores['validation'] = "Unexpected error while validating. Please, try again later.";
                            }
                        }
                    } else {
                        if ($arrayUser = $model->getUserByMail($arrayToken['User'])) {
                            if ($arrayUser['verified'] == '1' && $arrayUser['disabled'] == '0') {
                                $token = '';
                                $mailInfo = array();
                                if ($model->insertarToken($arrayUser['email'], $token, 900)) {
                                    $urlToken = Config::$urlVerifyForgot . $token;
                                    if (sendResetPassw($arrayUser, $urlToken, $mailInfo, $errores)) {
                                        $errores['token'] = "This link has expired. A new password reset link has been sent to your email, please check your inbox.";
                                        $notValid = true;
                                    } else {
                                        $params['emailVerify'] = "We could not send you an email to \"" . $arrayToken['User'] . "\".<br>Please try again later :(";
                                        header(Config::$locationHome);
                                    }
                                } else {
                                    $params['token'] = "Unexpected database error. Please try again later.";
                                    $notValid = true;
                                }
                            } else {
                                $errores["emailVerify"] = "This account has not been validated or is disabled. Sorry not sorry ;)";
                            }
                        } else {
                            $params['message'] = "No account linked to \"" . $arrayToken['user'] . "\"";
                        }
                        $notValid = true;
                    }

                    if ($validation) {
                    } else {
                        $errores['validation'] = "Unknown validation error.";
                        $notValid = true;
                    }
                } else {
                    echo var_dump($errores);
                    $notValid = true;
                }
            } catch (Exception $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
                $errores["sql"] = "Unexpected database error.";
                header(Config::$location404);
            } catch (Error $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                $errores["sql"] = "Unexpected database error.";
                header(Config::$location404);
            }
        } else {
            header(Config::$location404);
        }

        // Envio de formulario
        try {
            if (isset($_POST['bChangeP'])) { // Nombre del boton del formulario
                $errores = array();
                $passw = recoge('passw');
                $repassw = recoge('repassw');
                //var_dump($_REQUEST);

                // Comprobar campos formulario. Aqui va la validación con las funciones de bGeneral   
                if ($passw === $repassw) {
                    //Check si passw y repassw son iguales; luego o valida passw o error
                    if (cPassw($passw, "passw", $errores) && empty($errores)) {
                        $m = new FindIt();
                        if ($m->resetPassw(encriptar($passw), $arrayToken['User']) && $m->usedToken($arrayToken['User'])) {
                            $params['message'] = 'Password changed successfully! You can login now.';
                            $btnHome = true;
                        } else {
                            // Todos los else se quedan en la pagina verifyForgot y mustran el mensaje de error
                            $params['message'] = 'Password could not be changed. Please try again later.';
                        }
                    } else {
                        $params['message'] = 'Password does not meet the requirements.';
                    }
                } else {
                    $params = array(
                        'user' => $arrayToken['User'],
                        'passw' => $passw
                    );
                    $params['message'] = 'Passwords do not match.';
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
            header(Config::$location404);
        } catch (Error $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            header(Config::$location404);
        }
        require __DIR__ . '/../../web/templates/verifyForgot.php';
    }

    public function verifyAccount() // HACER FUNCION
    {
        if ($_SESSION['user_status'] > 0) {
            header(Config::$locationHome);
        }
        $errores = array();
        $msg = array();
        $token = recoge('token');
        //echo $token;
        $msg['first'] = 'Could not verify the account';
        $msg['second'] = 'Contact our support team';
        if (strlen($token) == 32) { // Token debe tener longitud de 32 caracteres.
            try {
                $model = new FindIt(); // Objeto FindIt para contrastar datos con la BBDD
                ($arrayToken = $model->getToken($token)) ? $expires = $arrayToken['date_expired'] : $errores['token'] = "Token provided is not valid.";
                //echo var_dump($arrayToken);
                if (empty($errores)) {
                    if ($expires > horaActual()) {
                        if ($arrayToken['used'] == '1' || $model->getVerified($arrayToken['user_id']) == '1') {
                            $errores['token'] = "This account has already been verified.";
                            $validation = false;
                        } else {
                            $model->verifyUser($arrayToken['user_id']) ? $validation = true : $errores['token'] = "Unexpected error while validating. Please, try again later.";
                        }
                    } else {
                        $errores['token'] = "This link has expired. To resend the verification email, click the button below.";
                        $msg['second'] = 'This link has expired.';
                        $validation = false;
                    }

                    if ($validation) {
                        if (!$model->usedToken($arrayToken['user_id'])) {
                            $errores['token'] = "Unexpected error while validating. Please, try again later.";
                            $validation = false;
                        } else {
                            $arrayUser = $model->getUserInfo($arrayToken['user_id'])[0];
                            if ($arrayUser) {
                                $mailInfo = array();
                                sendSuccessVerify($arrayUser['name'], $arrayUser['username'], $arrayUser['email'], Config::$urlLogin, $mailInfo, $errores);
                            }
                            $msg['first'] = 'Account verified!';
                            $msg['second'] = 'Enjoy the forums :)';
                        }
                    }
                }
            } catch (Exception $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
                $errores["sql"] = "Unexpected database error.";
                header(Config::$location404);
            } catch (Error $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                $errores["sql"] = "Unexpected database error.";
                header(Config::$location404);
            }
        } else {
            header(Config::$location404);
        }
        //var_dump($arrayToken, $validation, $msg);
        require __DIR__ . '/../../web/templates/verifyAccount.php';
    }
    public function login()
    {
        try {
            $params = array(
                'user' => '',
                'passw' => ''
            );
            $errores = array();
            $_SESSION['message'] = '';
            $menu = 'templates/home/header.php';

            if ($_SESSION['user_status'] > 0) {
                header(Config::$locationUserPage);
            }
            #if (isset($_REQUEST['bLogin'])) { // Nombre del boton del formulario
            echo 'hola';
            $user = recoge('user'); // user o email
            $passw = recoge('passw');

            // Comprobar campos formulario. Aqui va la validación con las funciones de bGeneral   
            if (cUser($user, "user", $errores) || cMail($user, "user", $errores)) { // Comprobar si es un user correcto o un email correcto.
                // Si no ha habido problema creo modelo y hago inserción                    
                $m = new FindIt();
                if ($usuario = $m->consultarUsuario($user)) {
                    if ($usuario["disabled"] == "0") {
                        if ($usuario["verified"] == "1") {
                            // Compruebo si el password es correcto
                            if (comprobarhash($passw, $usuario['password'])) {
                                // Obtenemos el resto de datos
                                $_SESSION['user_id'] = $usuario['user_id'];
                                $_SESSION['username'] = $usuario['username'];
                                $_SESSION['user_status'] = $usuario['user_level'];
                                $_SESSION['picture_path'] = $usuario['picture_path'];
                                if ($usuario['last_access_ip'] != getUserIp()) {
                                    $mailInfo = array();
                                    sendNewLogin($usuario, $mailInfo, $errores);
                                }
                                $m->userLogin($usuario['user_id'], getUserIp(), getUserDevice(), 0) ?: $errores['lastSession'] = "Unable to update login session info for user \"$user\".";

                                header(Config::$locationUserPage);
                            } else {
                                $params['message'] = 'Wrong username or password.';
                                $_SESSION['message'] = 'Wrong username or password.';
                                header(Config::$locationLogin);
                            }
                        } else {
                            $errores['validada'] = "This account has not been verified. Please, check your email.";
                            $_SESSION['message'] = 'This account has not been verified. Please, check your email.';
                            $showResendButton = true;
                            header(Config::$locationLogin);
                        }
                    } else {
                        $errores['habilitada'] = "This account has been temporarily disabled.<br> Please, contact our support team.";
                        $_SESSION['message'] = 'This account has been temporarily disabled.<br> Please, contact our support team.';
                        $showContactButton = true;
                        header(Config::$locationLogin);
                    }
                } else {
                    $params = array(
                        'user' => $user,
                        'passw' => $passw
                    );
                    $params['message'] = 'Wrong username or password.';
                    $_SESSION['message'] = 'Wrong username or password.';
                    header(Config::$locationLogin);
                }
            } else {
                $params = array(
                    'user' => $user,
                    'passw' => $passw
                );
                $params['message'] = 'Wrong username or password.';
                $_SESSION['message'] = 'Wrong username or password.';
                header(Config::$locationLogin);
            }
            #}
        } catch (Exception $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
            header(Config::$location404);
        } catch (Error $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            header(Config::$location404);
        }
        //var_dump($errores, $_SESSION, $_REQUEST, $usuario);
        require __DIR__ . '/../../web/templates/home/index.php';
    }


    public function signup()
    {
        if ($_SESSION['user_status'] > 0) {
            header(Config::$locationHome);
        }
        $params = array(
            'nombre' => '',
            'lastname' => '',
            'user' => '',
            'passw' => '',
            'email' => '',
            'gender' => '',
            'countryid' => '',
            'provinceid' => '',
        );

        if (isset($_REQUEST["termsAgree"])) {
            // Array Errores
            $errores = array();
            // Recoger todos los datos del formulario
            $name = recoge('name');
            $lastname = recoge('lastname');
            $user = recoge('user');
            $passw = recoge('password');
            $repassw = recoge('repassword');
            $email = recoge('email');
            $remail = recoge('remail');
            $gender = recoge('gender');
            $provinceId = recoge('province');
            $countryId = recoge('country');

            // Comprobar campos formulario. Aqui va la validación con las funciones de bGeneral o la clase Validacion

            cTexto($name, "name", $errores);
            cTexto($lastname, "lastname", $errores);
            try {
                $model = new FindIt(); // Objeto FindIt para contrastar datos con la BBDD
                //Valida User y si ya hay ese User dentro de la BBDD
                cUser($user, "user", $errores) ? ($model->cUserBD($user) ? $errores["user"] = "Username not available." : '') : '';
                //Check si passw y repassw son iguales; luego o valida passw o error
                ($passw === $repassw) ? cPassw($passw, "passw", $errores) : $errores["passw"] = "Passwords do not match.";
                //Check si email y remail son iguales; luego o valida mail o error (ternario anidado)
                ($email === $remail) ?  (cMail($email, "email", $errores) ? '' : $errores["email"] = "Please enter a valid email.") : $errores["email"] = "Emails do not match.";

                if (empty($errores)) {
                    // Check email contra BBDD
                    $model->cMailBD($email) ? $errores["email"] = "There is already an accounted linked to that email." : '';
                    // Comprueba radio con los valores validos
                    cRadio($gender, "gender", $errores, ["male", "female", "other"], FALSE);

                    $valid = $model->cProvinciaBD($provinceId, $errores);
                } else {
                    $valid = false;
                }
            } catch (Exception $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
                $errores["sql"] = "Unexpected database error.";
                header(Config::$location404);
            } catch (Error $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                $errores["sql"] = "Unexpected database error.";
                header(Config::$location404);
            }

            if (empty($errores) && $valid) {
                // Si no ha habido problema creo modelo y hago inserción     
                try {
                    // Check if profile pictures dir exists, if not, create it with appropiate permissions.
                    if (!file_exists(Config::$profilesDir)) {
                        mkdir(Config::$profilesDir, 0755);
                    }
                    $rutaImagen = cAvatar("png", $errores, Config::$imgDir, $user);
                    $_SESSION['rutaImagen'] = $rutaImagen;
                    if ($model->insertarUsuario($name, $lastname, $user, encriptar($passw), $email, horaActual(), $rutaImagen, $countryId, $provinceId, $gender, $lang = 'en', getUserIp(), getUserDevice(), $loginAttempts = 0)) { // TERMINAR ESTA PARTE DE LA FUNCION
                        // Si se inserta el usuario, creamos su carpeta (para img de perfil)
                        $userDir = Config::$imgDir . DIRECTORY_SEPARATOR . $user . DIRECTORY_SEPARATOR;
                        // Check if user dir exists, if not, create it with apprpiate permissions.
                        if (!file_exists($userDir)) {
                            mkdir($userDir, 0755);
                        }

                        $mailInfo = array();
                        $token = '';
                        $_SESSION["user_id"] = $userId = $model->getUserId($user)["user_id"];
                        //var_dump((int)$model->getUserId($user)["user_id"]);
                        if ($model->insertarToken((int)$userId, $token)) {
                            $urlToken = Config::$urlVerify . $token;
                            if (sendVerifyAccount($name, $user, $email, $urlToken, $mailInfo, $errores)) {
                                $params['message'] = "A verification email was sent to \"$email\".<br>Please check your email to verify your account.";
                                $_SESSION['signup'] = "A verification email was sent to \"$email\".<br>Please check your email to verify your account.";
                            } else {
                                $params['message'] = "We could not send you an email to \"$email\".<br>Please try again later :(";
                                $_SESSION['signup'] = "We could not send you an email to \"$email\".<br>Please try again later :(";
                            }
                        }
                        header(Config::$locationSignup);
                    } else {
                        $params = array(
                            'name' => $name,
                            'lastname' => $lastname,
                            'user' => $user,
                            'passw' => $passw,
                            'email' => $email,
                            'gender' => $gender,
                            'countryid' => $countryId,
                            'provinceid' => $provinceId,
                        );
                        $params['message'] = "Unable to sign up user \"" . $user . "\". Please check the sign up form.";
                        $_SESSION['signup'] = "Unable to sign up user \"" . $user . "\". Please check the sign up form.";
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage() . " " . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
                    header(Config::$location404);
                } catch (Error $e) {
                    error_log($e->getMessage() . " " . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                    header(Config::$location404);
                }
            } else {
                $params = array(
                    'nombre' => $name,
                    'lastname' => $lastname,
                    'user' => $user,
                    'passw' => $passw
                );
                $params['message'] = "Something's not right. Please check the sign up form.";
                $_SESSION['signup'] = "Something's not right. Please check the sign up form.";
            }
            var_dump($errores, $params, $_SESSION);
            //header(Config::$locationSignup);
        }

        if (!isset($_SESSION['homeLoad'])) {
            // Carga provinces y countries para los selects del signup modal
            try {
                $model = new FindIt();
                $provincesList = $model->getProvincias(231);
                $countriesList = $model->getCountries();
                $postCount = (int)$model->countPosts()['count(topic_id)'];
                $userCount = (int)$model->countUsers()['count(user_id)'];
                $_SESSION['homeLoad'] = true;
            } catch (Exception $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
                header(Config::$location404);
            } catch (Error $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                header(Config::$location404);
            }
        }
        require __DIR__ . '/../../web/templates/home/index.php';
    }

    public function userpage()
    {
        if ($_SESSION['user_status'] == 0) {
            header(Config::$locationHome);
        }
        $menu = $this->loadHeader();

        // Guardar cambios de la informacion del usuario
        if (isset($_REQUEST['bSaveChanges'])) {
            $errores = array();
            $name = recoge('name');
            $lastname = recoge('lastname');
            $town = recoge('town');
            $descripcion = recoge('descripcion');

            $name = ($name == "") ? $_SESSION['name'] : $name;
            $lastname = ($lastname == "") ? $_SESSION['lastname'] : $lastname;
            $town = ($town == "") ? $_SESSION['town'] : $town;

            cTexto($name, "name", $errores);
            cTexto($lastname, "lastname", $errores);
            cTexto($town, "town", $errores, 30, 3, true, true, FALSE);
            cTextarea($descripcion, 'descripcion', $errores, 600, 0);
            //var_dump($descripcion);
            if (empty($errores)) {
                try {
                    $m = new FindIt();
                    if ($m->updateUserInfo($name, $lastname, $town, $descripcion)) {
                        $errores['success'] = "Information updated successfully!";
                    } else {
                        $errores['validation'] = "Unable to update information. Please try again later :(";
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
                    header(Config::$location404);
                } catch (Error $e) {
                    error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                    header(Config::$location404);
                }
            }
        }
        // Cambiar imagen de perfil del usuario
        if (isset($_REQUEST['bChangePicture'])) {
            $errores = array();
            $rutaUser = cFotoUsuario("fotoPerfil", Config::$allowed_extensions, "png", $errores, Config::$max_file_size, Config::$profilesDir, true, $_SESSION['user']);
            if (empty($errores) && $rutaUser && !empty($rutaUser)) {
                try {
                    $m = new FindIt();
                    if ($m->updateUserPicture($rutaUser)) {
                        $errores['success'] = "Information updated successfully!";
                    } else {
                        $errores['validation'] = "Unable to update information. Please try again later :(";
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
                    header(Config::$location404);
                } catch (Error $e) {
                    error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                    header(Config::$location404);
                }
            } else {
                $errores['validation'] = "Unable to update information. Please try again later :(";
            }
        }

        // Load data
        try {
            $model = new FindIt();
            $postsList = $model->getPublicPosts();
            $userPostsList = $model->getUserPosts($_SESSION['user_id']);
            // Falta saved posts
            //var_dump($postsList);
            $countriesList = $model->getCountries();
        } catch (Exception $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
            header(Config::$location404);
        } catch (Error $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            header(Config::$location404);
        }

        require __DIR__ . '/../../web/templates/userpage/index.php';
    }
    public function forum()
    {
        if ($_SESSION['user_status'] == 0) {
            header(Config::$locationHome);
        }

        try {
            $model = new FindIt();
            $arrayTags = $model->selectForumTags();
            $arrayTopics = $model->selectForumTopics();
        } catch (Exception $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
            $errores["sql"] = "Unexpected database error.";
            header(Config::$location404);
        } catch (Error $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            $errores["sql"] = "Unexpected database error.";
            header(Config::$location404);
        }

        // Insertar Tema Foro
        if (isset($_REQUEST['bCreateForum'])) {
            $errores = array();

            $titleForum = recoge('titleForum');
            $tag = recoge('tag');
            $inputTextarea = recoge('inputTextarea');

            cTexto($titleForum, "titleForum", $errores);
            cTexto($tag, "tag", $errores);
            cTextarea($inputTextarea, "inputTextarea", $errores);

            if (empty($errores)) {
                try {
                    $m = new FindIt();
                    if ($m->checkForumTags($tag)) {
                        if ($m->crearTemaForo($_SESSION['idUser'], $tag, $titleForum)) {
                            $errores['success'] = "Topic created successfully!";
                        } else {
                            $errores['success'] = "Unable to create topic. Please try again later :(";
                        }
                    } else {
                        $errores['validation'] = "Unable to update information. Please try again later :(";
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
                    header(Config::$location404);
                } catch (Error $e) {
                    error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                    header(Config::$location404);
                }
            } else {
                $errores['validation'] = "Unable to update information. Please try again later :(";
            }
        }

        $menu = $this->loadHeader();
        require __DIR__ . '/../../web/templates/forum.php';
    }


    // ==== ADMIN FUNCTIONS ==== \\
    public function adminUsers()
    {
        if ($_SESSION['user_status'] < 2) {
            Controller::exit();
        }
        // Disable or Enable User
        if (isset($_REQUEST['bDisableUser']) || isset($_REQUEST['bEnableUser'])) {
            $habilitada = isset($_REQUEST['bDisableUser']) ? '0' : '1';
            $errores = array();
            //echo var_dump($_REQUEST);
            //echo var_dump($_SESSION);
            try {
                $m = new FindIt();
                if ($m->updateHabilitada(recoge('username'), $habilitada)) {
                    $errores['success'] = 'All changes saved.';
                } else {
                    $errores['fail'] = "Unable to update information. Please try again later :(";
                }
            } catch (Exception $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
                header(Config::$location404);
            } catch (Error $e) {
                error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                header(Config::$location404);
            }
        }

        /*try {
            $model = new FindIt();
            $arrayMonsters = $model->selectBichosPublicos();
        } catch (Exception $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
            $errores["sql"] = "Unexpected database error.";
            header(Config::$location404);
        } catch (Error $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            $errores["sql"] = "Unexpected database error.";
            header(Config::$location404);
        }*/
        $menu = $this->loadHeader();
        require __DIR__ . '/../../web/templates/adminUsers.php';
    }
}

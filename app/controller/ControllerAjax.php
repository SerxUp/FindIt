<?php
class ControllerAjax
{
    public function contact()
    {
        #$menu = 'headerPublic.php';
        if ($_SESSION['user_status'] < 0) {
            header(Config::$locationHome);
        }

        $params = array(
            'name' => '',
            'lastname' => '',
            'email' => '',
            'content' => '',
            'message' => '',
            'error' => '',
        );

        $errores = array();
        $name = recoge("name");
        $lastname = recoge("lastname");
        $email = recoge("email");
        $content = recoge("content");
        $subject = recoge("subject");

        cTexto($name, "name", $errores, 30, 1);
        cTexto($lastname, "lastname", $errores, 30, 1);
        cTexto($subject, "subject", $errores, 30, 1, true, true, false);
        cMail($email, "email", $errores);
        cTextarea($content, "content", $errores);

        if (empty($errores)) {

            if (sendMailContact($name, $lastname, $email, $content, $subject, $errores)) {
                $params = [
                    'name' => $name,
                    'lastname' => $lastname,
                    'email' => $email,
                    'content' => $content,
                    'message' => "Message sent from \"" . $email . "\"!",
                    'error' => '',
                ];
            } else {
                error_log('Error in contact. ' . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
                $errores['validation'] = "Error: Message not sent. Please try again later.";
                $params = [
                    'name' => $name,
                    'lastname' => $lastname,
                    'email' => $email,
                    'content' => $content,
                    'message' => '',
                    'error' => $errores['validation'],
                ];
            }
        } else {
            $params['error'] = "Message not sent. Check the form data.";
        }
        echo json_encode($params);
    }

    # ^ Functions above need adaptation ^ #

    public function forgot()
    {
        if ($_SESSION['user_status'] > 0) {
            header(Config::$locationHome);
        }

        $params = array(
            'email' => '',
            'message' => ''
        );
        // Array Errores
        $errores = array();

        // Recoger todos los datos del formulario
        $email = recoge('email');
        // Check forms fata. Validation using functions from General.php
        try {
            $model = new FindIt(); // FindIt object - database model
            //Check if email & remail are equal; then or valid email or error (nested ternary operator)
            cMail($email, "email", $errores) ? '' : $errores["email"] = "Please enter a valid email.";
            $params['message'] = $errores["email"] ?? '';
            if (empty($errores)) {
                // Check email against DB
                $valid = ($model->cMailBD($email) ? true : false);
                !$valid ? $errores["email"] = "No account linked to that email address." :
                    $params['message'] = "If there is an account linked to \"$email\", we will send a email so you can reset your password.";
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
                if ($usuario = $model->consultarUsuario($email)) {
                    if ($usuario['verified'] == '1' && $usuario['disabled'] == '0') {
                        $token = '';
                        $mailInfo = array();
                        if ($model->insertarToken($usuario['user_id'], $token, 900)) {
                            $urlToken = Config::$urlVerifyForgot . $token;
                            if (sendResetPassw($usuario, $urlToken, $mailInfo, $errores)) {
                                $params['message'] = "If there is an account linked to \"$email\", we will send a email so you can reset your password.";
                            } else {
                                $params['message'] = "We could not send an email to \"$email\".<br>Please try again later :(";
                            }
                        }
                        $params['email'] = $email;
                        //header(Config::$locationHome);
                    } else {
                        $errores["message"] = "This account has not been validated or is disabled. Sorry not sorry ;)";
                        $params["message"] = "This account has not been validated or is disabled. Sorry not sorry ;)";
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
        echo json_encode($params);
        //echo var_dump($errores);
        //echo var_dump($params);

    }



    public function userPicture()
    {
        if ($_SESSION['user_status'] < 1) {
            header("location:index.php?ctl=exit");
        }

        try {
            $m = new FindIt();
            if ($arrayInfoUser = $m->getUserInfo($_SESSION['idUser'])[0]) {
                $_SESSION['name'] = $arrayInfoUser['Nombre'];
                $_SESSION['lastname'] = $arrayInfoUser['Apellidos'];
                $_SESSION['validada'] = $arrayInfoUser['Validada'];
                $_SESSION['habilitada'] = $arrayInfoUser['Habilitada'];
                $_SESSION['town'] = $arrayInfoUser['Municipio'];

                //$_SESSION['about'] = $arrayInfoUser['About'];
                echo json_encode($arrayInfoUser);
            } else {
                echo "";
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
    }

    public function listUsers()
    {
        if ($_SESSION['user_status'] != 2) {
            header("location:index.php?ctl=exit");
        }
        $filtro = (recoge('filtro') ? recoge('filtro') : '1');
        try {
            $m = new FindIt();
            switch ($filtro) {
                case '1': // Show all
                    $arrayInfoUser = $m->getUserInfo('%');
                    break;
                case '2': // Disabled
                    $arrayInfoUser = $m->getUserHabilitada('0');
                    break;
                case '3': // Enabled
                    $arrayInfoUser = $m->getUserHabilitada('1');
                    break;
                case '4': // Validated
                    $arrayInfoUser = $m->getUserValidada('1');
                    break;
                case '5': // Not validated
                    $arrayInfoUser = $m->getUserValidada('0');
                    break;
                case '6': // Old users
                    $arrayInfoUser = $m->getUserOld((horaActual() - 1296000));
                    break;
                default:
                    break;
            }
            if ($arrayInfoUser) {
                echo json_encode($arrayInfoUser);
            } else {
                echo json_encode($arrayInfoUser);
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
    }

    public function searchUser()
    {
        // Search User
        if ($_SESSION['user_status'] != 2) {
            header("location:index.php?ctl=exit");
        }
        $errores = array();
        $filter = recoge('filter');

        // If filter is empty, show all users.
        $filter = ($filter == '') ? '%' : $filter;

        //if consultarUsuario returns something, echo array assoc
        //else echo no results message to ajax.js

        //echo var_dump($_REQUEST);
        //echo var_dump($_SESSION);
        try {
            $m = new FindIt();
            if ($arrayInfoUser = $m->getUserInfo($filter)) {
                echo json_encode($arrayInfoUser);
            } else {
                $json = '{"NotFound" : "Your search returned no results."}';
                $arrEquiv = ['NotFound' => '"Your search returned no results.1"'];
                echo $json;
                //echo json_encode($arrEquiv);
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
    }

    public function userInfo()
    {
        if ($_SESSION['user_status'] < 1) {
            header("location:index.php?ctl=exit");
        }

        try {
            $m = new FindIt();
            if ($arrayInfoUser = $m->getUserInfo($_SESSION['idUser'])[0]) {
                $_SESSION['name'] = $arrayInfoUser['Nombre'];
                $_SESSION['lastname'] = $arrayInfoUser['Apellidos'];
                $_SESSION['validada'] = $arrayInfoUser['Validada'];
                $_SESSION['habilitada'] = $arrayInfoUser['Habilitada'];
                $_SESSION['town'] = $arrayInfoUser['Municipio'];
                $_SESSION['descripcion'] = $arrayInfoUser['Descripcion'];

                //$_SESSION['about'] = $arrayInfoUser['About'];
                echo json_encode($arrayInfoUser);
            } else {
                echo "";
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
    }

    public function postVisibility()
    {
        if ($_SESSION['user_status'] < 1) {
            header("location:index.php?ctl=exit");
        }
        $postId = (int)recoge('id');
        $oldVisibility = (int)recoge('vis');
        $newVisibility = $oldVisibility == 2 ? 0 : $oldVisibility++;
        try {
            $m = new FindIt();
            if ($m->updatePostVisibility($postId, $newVisibility)) {
                echo json_encode($newVisibility);
            } else {
                echo "";
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logException.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
    }
}

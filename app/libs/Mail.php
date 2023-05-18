<?php
//Carga de las clases necesarias
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendVerifyAccount(string $name, string $user, string $email, string $urlToken, array &$mailInfo, array &$errores)
{
    //Crear una instancia. Con true permitimos excepciones
    $mail = new PHPMailer(true);
    // Generate URL with Token

    try {
        //Valores dependientes del servidor que utilizamos

        $mail->isSMTP();                                           //Para usaar SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Nuestro servidor SMTMP smtp.gmail.com en caso de usar gmail
        $mail->SMTPAuth   = true;
        /* 
    * SMTP username y password Poned los vuestros. La contraseña es la que nos generó GMAIL
    */
        $mail->Username   = 'findit.forums@gmail.com';
        $mail->Password   = 'jtdq qdmo ejyr zeag';
        /*
    * Encriptación a usar ssl o tls, dependiendo cual usemos hay que utilizar uno u otro puerto
    */
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = "465";
        /**TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`                         
         * $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
         * $mail->Port       = 587;  
         */


        /*
    Receptores y remitente
    */
        //Remitente
        $mail->setFrom('findit.forums@gmail.com', 'Find It Support Team');
        //Receptores. Podemos añadir más de uno. El segundo argumento es opcional, es el nombre
        $mail->addAddress($email, $name);     //Add a recipient
        //$mail->addAddress('ejemplo@example.com'); 

        //Copia
        //$mail->addCC('cc@example.com');
        //Copia Oculta
        //$mail->addBCC('bcc@example.com');

        //Archivos adjuntos
        $mail->addAttachment('templates/docs/FindIt_TermsOfAgreement.pdf', "Terms of Agreement - Find It Forums");         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Contenido
        //Si enviamos HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF8";
        //Asunto
        $mail->Subject = "$name, please verify your account.";
        //Conteido HTML

        $mail->Body    = verifyBody($name, $user, $email, $urlToken);
        //Contenido alternativo en texto simple
        $mail->AltBody = "If you cannot see this message properly, copy and paste this URL in your browser to verify your account: " . $urlToken;
        //Enviar correo
        $mail->send();
        $mailInfo["verify"] = 'El mensaje se ha enviado con exito';
        return true;
    } catch (Exception $e) {
        $errores["verify"] = "El mensaje no se ha enviado: {$mail->ErrorInfo}";
        error_log($e->getMessage() . ' || ' . $mail->ErrorInfo . ' || ' . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logMail.txt");
        return false;
    } catch (Error $e) {
        error_log($e->getMessage() . " " . $mail->ErrorInfo . " " . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
        //header(Config::$location404);
        return false;
    }
}

function sendNewLogin(array &$usuario, array &$mailInfo, array &$errores)
{
    //Crear una instancia. Con true permitimos excepciones
    $mail = new PHPMailer(true);
    // Generate URL with Token

    try {
        //Valores dependientes del servidor que utilizamos

        $mail->isSMTP();                                           //Para usaar SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Nuestro servidor SMTMP smtp.gmail.com en caso de usar gmail
        $mail->SMTPAuth   = true;
        /* 
    * SMTP username y password Poned los vuestros. La contraseña es la que nos generó GMAIL
    */
        $mail->Username   = 'findit.forums@gmail.com';
        $mail->Password   = 'jtdq qdmo ejyr zeag';
        /*
    * Encriptación a usar ssl o tls, dependiendo cual usemos hay que utilizar uno u otro puerto
    */
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = "465";
        $mail->setFrom('findit.forums@gmail.com', 'Find It Support Team');
        $mail->addAddress($usuario['email'], $usuario['name']);
        //Contenido
        //Si enviamos HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF8";
        //Asunto
        $mail->Subject = "Alert: New Login detected for \"" . $usuario['username'] . "\"";
        //Conteido HTML

        $mail->Body    = newLoginBody($usuario);
        //Contenido alternativo en texto simple
        $mail->AltBody = "If you cannot see this message properly, contact our support team.";
        //Enviar correo
        $mail->send();
        $mailInfo["verify"] = 'El mensaje se ha enviado con exito';
        return true;
    } catch (Exception $e) {
        $errores["verify"] = "El mensaje no se ha enviado: {$mail->ErrorInfo}";
        error_log($e->getMessage() . ' || ' . $mail->ErrorInfo . ' || ' . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logMail.txt");
        return false;
    } catch (Error $e) {
        error_log($e->getMessage() . " " . $mail->ErrorInfo . " " . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
        //header(Config::$location404);
        return false;
    }
}

function sendSuccessVerify(string $name, string $user, string $email, string $urlLogin, array &$mailInfo, array &$errores)
{
    //Crear una instancia. Con true permitimos excepciones
    $mail = new PHPMailer(true);
    // Generate URL with Token

    try {
        //Valores dependientes del servidor que utilizamos

        $mail->isSMTP();                                           //Para usaar SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Nuestro servidor SMTMP smtp.gmail.com en caso de usar gmail
        $mail->SMTPAuth   = true;
        /* 
    * SMTP username y password Poned los vuestros. La contraseña es la que nos generó GMAIL
    */
        $mail->Username   = 'findit.forums@gmail.com';
        $mail->Password   = 'jtdq qdmo ejyr zeag';
        /*
    * Encriptación a usar ssl o tls, dependiendo cual usemos hay que utilizar uno u otro puerto
    */
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = "465";
        /**TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`                         
         * $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
         * $mail->Port       = 587;  
         */


        /*
    Receptores y remitente
    */
        //Remitente
        $mail->setFrom('findit.forums@gmail.com', 'Find It Support Team');
        //Receptores. Podemos añadir más de uno. El segundo argumento es opcional, es el nombre
        $mail->addAddress($email, $name);     //Add a recipient
        //$mail->addAddress('ejemplo@example.com'); 

        //Copia
        //$mail->addCC('cc@example.com');
        //Copia Oculta
        //$mail->addBCC('bcc@example.com');

        //Archivos adjuntos
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Contenido
        //Si enviamos HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF8";
        //Asunto
        $mail->Subject = "$name, your account was verified.";
        //Conteido HTML

        $mail->Body    = successVerifyBody($name, $user, $email, $urlLogin);
        //Contenido alternativo en texto simple
        $mail->AltBody = "If you cannot see this message properly, copy and paste this URL in your browser to go to the login page: " . $urlLogin;
        //Enviar correo
        $mail->send();
        $mailInfo["verify"] = 'El mensaje se ha enviado con exito';
        return true;
    } catch (Exception $e) {
        $errores["verify"] = "El mensaje no se ha enviado: {$mail->ErrorInfo}";
        error_log($e->getMessage() . ' || ' . $mail->ErrorInfo . ' || ' . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logMail.txt");
        return false;
    }
}

function sendResetPassw(array &$usuario, string $urlToken, array &$mailInfo, array &$errores)
{
    //Crear una instancia. Con true permitimos excepciones
    $mail = new PHPMailer(true);
    // Generate URL with Token

    try {
        //Valores dependientes del servidor que utilizamos

        $mail->isSMTP();                                           //Para usaar SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Nuestro servidor SMTMP smtp.gmail.com en caso de usar gmail
        $mail->SMTPAuth   = true;
        /* 
    * SMTP username y password Poned los vuestros. La contraseña es la que nos generó GMAIL
    */
        $mail->Username   = 'findit.forums@gmail.com';
        $mail->Password   = 'jtdq qdmo ejyr zeag';
        /*
    * Encriptación a usar ssl o tls, dependiendo cual usemos hay que utilizar uno u otro puerto
    */
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = "465";
        /**TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`                         
         * $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
         * $mail->Port       = 587;  
         */


        /*
    Receptores y remitente
    */
        //Remitente
        $mail->setFrom('findit.forums@gmail.com', 'Find It Support Team');
        //Receptores. Podemos añadir más de uno. El segundo argumento es opcional, es el nombre
        $mail->addAddress($usuario['email'], $usuario['name']);     //Add a recipient
        //$mail->addAddress('ejemplo@example.com'); 

        //Copia
        //$mail->addCC('cc@example.com');
        //Copia Oculta
        //$mail->addBCC('bcc@example.com');

        //Archivos adjuntos
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Contenido
        //Si enviamos HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF8";
        //Asunto
        $mail->Subject = "Password Reset Request for \"" . $usuario['username'] . "\"";
        //Conteido HTML

        $mail->Body    = resetBody($usuario, $urlToken);;
        //Contenido alternativo en texto simple
        $mail->AltBody = "If you cannot see this message properly, copy and paste this URL in your browser to reset your password: " . $urlToken;
        //Enviar correo
        $mail->send();
        $mailInfo["verify"] = 'El mensaje se ha enviado con exito';
        return true;
    } catch (Exception $e) {
        $errores["verify"] = "El mensaje no se ha enviado: {$mail->ErrorInfo}";
        error_log($e->getMessage() . ' || ' . $mail->ErrorInfo . ' || ' . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logMail.txt");
        return false;
    }
}

function sendMailContact(string $name, string $lastname, string $email, string $info, string $subject, array &$errores)
{
    //Crear una instancia. Con true permitimos excepciones
    $mail = new PHPMailer(true);
    // Generate URL with Token

    try {
        //Valores dependientes del servidor que utilizamos

        $mail->isSMTP();                                           //Para usaar SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Nuestro servidor SMTMP smtp.gmail.com en caso de usar gmail
        $mail->SMTPAuth   = true;
        /* 
    * SMTP username y password Poned los vuestros. La contraseña es la que nos generó GMAIL
    */
        $mail->Username   = 'findit.forums@gmail.com';
        $mail->Password   = 'jtdq qdmo ejyr zeag';
        /*
    * Encriptación a usar ssl o tls, dependiendo cual usemos hay que utilizar uno u otro puerto
    */
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = "465";
        /**TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`                         
         * $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
         * $mail->Port       = 587;  
         */


        /*
    Receptores y remitente
    */
        //Remitente
        $mail->setFrom($email, $name . " " . $lastname);
        //Receptores. Podemos añadir más de uno. El segundo argumento es opcional, es el nombre
        $mail->addAddress('findit.forums@gmail.com', 'Find It Support Team');     //Add a recipient
        //$mail->addAddress('ejemplo@example.com'); 

        //Copia
        //$mail->addCC('cc@example.com');
        //Copia Oculta
        //$mail->addBCC('bcc@example.com');

        //Archivos adjuntos
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Contenido
        //Si enviamos HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF8";
        //Asunto
        $mail->Subject = "[Contact/Feedback]: \"$subject\"";
        //Conteido HTML

        $mail->Body    = contactBody($name, $lastname, $email, $info);
        //Contenido alternativo en texto simple
        $mail->AltBody = "If you cannot see this message properly, sorry.";
        //Enviar correo
        $mail->send();
        $mailInfo["verify"] = 'El mensaje se ha enviado con exito';
        return true;
    } catch (Exception $e) {
        $errores["verify"] = "El mensaje no se ha enviado: {$mail->ErrorInfo}";
        error_log($e->getMessage() . ' || ' . $mail->ErrorInfo . ' || ' . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logMail.txt");
        return false;
    }
}

function newsSignup(array &$usuario, $subject, $body, $altBody)
{
    //Crear una instancia. Con true permitimos excepciones
    $mail = new PHPMailer(true);

    try {
        //Valores dependientes del servidor que utilizamos

        $mail->isSMTP();                                           //Para usaar SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Nuestro servidor SMTMP smtp.gmail.com en caso de usar gmail
        $mail->SMTPAuth   = true;
        /* 
    * SMTP username y password Poned los vuestros. La contraseña es la que nos generó GMAIL
    */
        $mail->Username   = 'findit.forums@gmail.com';
        $mail->Password   = 'jtdq qdmo ejyr zeag';
        /*
    * Encriptación a usar ssl o tls, dependiendo cual usemos hay que utilizar uno u otro puerto
    */
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = "465";
        /**TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`                         
         * $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
         * $mail->Port       = 587;  
         */


        /*
    Receptores y remitente
    */
        //Remitente
        $mail->setFrom('findit.forums@gmail.com', 'Find It Support Team');
        //Receptores. Podemos añadir más de uno. El segundo argumento es opcional, es el nombre
        $mail->addAddress($usuario['email'], $usuario['name']);     //Add a recipient
        //$mail->addAddress('ejemplo@example.com'); 

        //Copia
        //$mail->addCC('cc@example.com');
        //Copia Oculta
        //$mail->addBCC('bcc@example.com');

        //Archivos adjuntos
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Contenido
        //Si enviamos HTML
        $mail->isHTML(true);
        $mail->CharSet = "UTF8";
        //Asunto
        $mail->Subject = $subject;
        //Conteido HTML
        $mail->Body    = $body;
        //Contenido alternativo en texto simple
        $mail->AltBody = $altBody;
        //Enviar correo
        $mail->send();
        echo 'El mensaje se ha enviado con exito';
    } catch (Exception $e) {
        echo "El mensaje no se ha enviado: {$mail->ErrorInfo}";
    }
}

// Email content
function verifyBody($name, $user, $email, $urlToken)
{
    ob_start(); ?>
    <!-- Compiled with Bootstrap Email version: 1.3.1 -->
    <table class="bg-light body" valign="top" role="presentation" border="0" cellpadding="0" cellspacing="0" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;" bgcolor="#f7fafc">
        <tbody>
            <tr>
                <td valign="top" style="line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f7fafc">
                    <table class="container" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td align="center" style="line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">
                                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; margin: 0 auto;">
                                        <tbody>
                                            <tr>
                                                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="left" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                                    <img class="w-24" src="<?php Config::$mailLogo ?>" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 96px; border-style: none; border-width: 0;" width="96">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="center" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="card p-6 p-lg-10 space-y-4" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; width: 100%; overflow: hidden; border: 1px solid #e2e8f0;" bgcolor="#ffffff">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0; padding: 40px;" align="center" bgcolor="#ffffff">
                                                                    <h1 class="h3 fw-700" style="padding-top: 0; padding-bottom: 0; font-weight: 700 !important; vertical-align: baseline; font-size: 28px; line-height: 33.6px; margin: 0;" align="center">
                                                                        Greetings, <?php echo $user; ?>! please verify your account.
                                                                    </h1>
                                                                    <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="center" width="100%" height="16">
                                                                                    &#160;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <p class="" style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="center">
                                                                        Thank you for becoming a member of the Find It Forums Community!<br>
                                                                        Click the button below to verify your account and start posting.<br>
                                                                    </p>
                                                                    <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="center" width="100%" height="16">
                                                                                    &#160;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table class="btn btn-primary p-3 fw-700" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; font-weight: 700 !important;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 24px; font-size: 16px; border-radius: 6px; font-weight: 700 !important; margin: 0;" align="center" bgcolor="#0d6efd">
                                                                                    <a href="<?php echo $urlToken; ?>" style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: 700 !important; white-space: nowrap; background-color: #0d6efd; padding: 12px; border: 1px solid #0d6efd;">
                                                                                        Verify email</a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="center" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 28px; margin: 0;" align="center">
                                                                    <h2 class="w-40" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 160px; border-style: none; border-width: 0; font-weight: bold; font-family: 'Courier New', Courier, monospace;" width="160">FIND IT<br>FORUMS</h2>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="center" width="100%" height="24">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="text-muted text-center" style="color: #718096;" align="center">
                                                        Sent with &lt;3 from Find It Support Team. <br>
                                                        Find It! Forums, Redefined. by Sergio Adam.<br>
                                                        Valencia, Spain. <br>
                                                    </div>
                                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="center" width="100%" height="24">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

<?php $contenido = ob_get_clean();
    return $contenido;
}

function newLoginBody(array &$usuario)
{
    ob_start(); ?>
    <!-- Compiled with Bootstrap Email version: 1.3.1 -->
    <table class="bg-light body" valign="top" role="presentation" border="0" cellpadding="0" cellspacing="0" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;" bgcolor="#f7fafc">
        <tbody>
            <tr>
                <td valign="top" style="line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f7fafc">
                    <table class="container" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td align="center" style="line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">
                                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; margin: 0 auto;">
                                        <tbody>
                                            <tr>
                                                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="left" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                                    <img class="w-24" src="<?php Config::$mailLogo ?>" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 96px; border-style: none; border-width: 0;" width="96">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="center" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="card p-6 p-lg-10 space-y-4" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; width: 100%; overflow: hidden; border: 1px solid #e2e8f0;" bgcolor="#ffffff">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0; padding: 40px;" align="center" bgcolor="#ffffff">
                                                                    <h1 class="h3 fw-700" style="padding-top: 0; padding-bottom: 0; font-weight: 700 !important; vertical-align: baseline; font-size: 28px; line-height: 33.6px; margin: 0;" align="center">
                                                                        Hello, "<?php echo $usuario['name']; ?>". a new login was detected.
                                                                    </h1>
                                                                    <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="center" width="100%" height="16">
                                                                                    &#160;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <p class="" style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="center">
                                                                        Access time: <strong><?php echo gmdate("d-m-Y H:i", horaActual()); ?></strong>.<br>
                                                                        IP Address: <strong><?php echo getUserIp(); ?></strong>.<br>
                                                                        Device Info: <strong><?php echo getUserDevice(); ?></strong>.<br>
                                                                        Login Attempts: <strong><?php echo $usuario['login_failed_attempts']; ?></strong>.<br>
                                                                    </p>
                                                                    <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="center" width="100%" height="16">
                                                                                    &#160;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table class="btn btn-outline-secondary p-3 fw-700" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; font-weight: 700 !important;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 24px; font-size: 16px; border-radius: 6px; font-weight: 700 !important; margin: 0;" align="center" bgcolor="#494949">
                                                                                    <p class="" style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="center">
                                                                                        If this was you, you don't need to do anything.<br>
                                                                                        If you don't recognize this activity, please <strong>change your password</strong> to secure your account.<br>
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="center" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 28px; margin: 0;" align="center">
                                                                    <h2 class="w-40" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 160px; border-style: none; border-width: 0; font-weight: bold; font-family: 'Courier New', Courier, monospace;" width="160">FIND IT<br>FORUMS</h2>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="center" width="100%" height="24">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="text-muted text-center" style="color: #718096;" align="center">
                                                        Sent with &lt;3 from Find It Support Team. <br>
                                                        Find It! Forums, Redefined. by Sergio Adam.<br>
                                                        Valencia, Spain. <br>
                                                    </div>
                                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="center" width="100%" height="24">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

<?php $contenido = ob_get_clean();
    return $contenido;
}

function successVerifyBody($name, $user, $email, $urlLogin)
{
    ob_start(); ?>
    <!-- -->
    <table class="bg-light body" valign="top" role="presentation" border="0" cellpadding="0" cellspacing="0" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;" bgcolor="#f7fafc">
        <tbody>
            <tr>
                <td valign="top" style="line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f7fafc">
                    <table class="container" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td align="center" style="line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">
                                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; margin: 0 auto;">
                                        <tbody>
                                            <tr>
                                                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="left" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                                    <img class="w-24" src="<?php Config::$mailLogo ?>" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 96px; border-style: none; border-width: 0;" width="96">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="center" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="card p-6 p-lg-10 space-y-4" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; width: 100%; overflow: hidden; border: 1px solid #e2e8f0;" bgcolor="#ffffff">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0; padding: 40px;" align="center" bgcolor="#ffffff">
                                                                    <h1 class="h3 fw-700" style="padding-top: 0; padding-bottom: 0; font-weight: 700 !important; vertical-align: baseline; font-size: 28px; line-height: 33.6px; margin: 0;" align="center">
                                                                        Hello "<?php echo $user; ?>", thank you for verifying your account!
                                                                    </h1>
                                                                    <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="center" width="100%" height="16">
                                                                                    &#160;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <p class="" style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="center">
                                                                        You can log in now!<br>
                                                                    </p>
                                                                    <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="center" width="100%" height="16">
                                                                                    &#160;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table class="btn btn-primary p-3 fw-700" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; font-weight: 700 !important;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 24px; font-size: 16px; border-radius: 6px; font-weight: 700 !important; margin: 0;" align="center" bgcolor="#0d6efd">
                                                                                    <a href="<?php echo $urlLogin; ?>" style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: 700 !important; white-space: nowrap; background-color: #0d6efd; padding: 12px; border: 1px solid #0d6efd;">
                                                                                        Login</a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="center" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 28px; margin: 0;" align="center">
                                                                    <h2 class="w-40" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 160px; border-style: none; border-width: 0; font-weight: bold; font-family: 'Courier New', Courier, monospace;" width="160">FIND IT<br>FORUMS</h2>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="center" width="100%" height="24">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="text-muted text-center" style="color: #718096;" align="center">
                                                        Sent with &lt;3 from Find It Support Team. <br>
                                                        Find It! Forums, Redefined. by Sergio Adam.<br>
                                                        Valencia, Spain. <br>
                                                    </div>
                                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="center" width="100%" height="24">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

<?php $contenido = ob_get_clean();
    return $contenido;
}

function contactBody($name, $lastname, $email, $mailInfo)
{
    ob_start(); ?>
    <!-- Compiled with Bootstrap Email version: 1.3.1 -->
    <table class="bg-light body" valign="top" role="presentation" border="0" cellpadding="0" cellspacing="0" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;" bgcolor="#f7fafc">
        <tbody>
            <tr>
                <td valign="top" style="line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f7fafc">
                    <table class="container" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td align="center" style="line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">
                                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; margin: 0 auto;">
                                        <tbody>
                                            <tr>
                                                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="left" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                                    <img class="w-24" src="<?php Config::$mailLogo ?>" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 96px; border-style: none; border-width: 0;" width="96">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="center" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="card p-6 p-lg-10 space-y-4" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; width: 100%; overflow: hidden; border: 1px solid #e2e8f0;" bgcolor="#ffffff">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0; padding: 40px;" align="center" bgcolor="#ffffff">
                                                                    <h1 class="h3 fw-700" style="padding-top: 0; padding-bottom: 0; font-weight: 700 !important; vertical-align: baseline; font-size: 28px; line-height: 33.6px; margin: 0;" align="center">
                                                                        From: <?php echo $name . " " . $lastname . "<br>(" . $email . ")" ?>
                                                                    </h1>
                                                                    <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="center" width="100%" height="16">
                                                                                    &#160;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <p class="" style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="center">
                                                                        <?php echo "Message: " . $mailInfo; ?>
                                                                    </p>
                                                                    <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="center" width="100%" height="16">
                                                                                    &#160;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table class="btn btn-primary p-3 fw-700" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; font-weight: 700 !important;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 24px; font-size: 16px; border-radius: 6px; font-weight: 700 !important; margin: 0;" align="center" bgcolor="#0d6efd">
                                                                                    <a href="mailto:<?php echo $email; ?>" style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: 700 !important; white-space: nowrap; background-color: #0d6efd; padding: 12px; border: 1px solid #0d6efd;">
                                                                                        Send Reply</a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="center" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="center" width="100%" height="24">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="text-muted text-center" style="color: #718096;" align="center">
                                                        Sent with &lt;3 from Find It Support Team. <br>
                                                        Find It! Forums, Redefined. by Sergio Adam.<br>
                                                        Valencia, Spain. <br>
                                                    </div>
                                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="center" width="100%" height="24">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

<?php $contenido = ob_get_clean();
    return $contenido;
}

function resetBody(array &$usuario, $urlToken)
{
    ob_start(); ?>
    <table class="bg-light body" valign="top" role="presentation" border="0" cellpadding="0" cellspacing="0" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;" bgcolor="#f7fafc">
        <tbody>
            <tr>
                <td valign="top" style="line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f7fafc">
                    <table class="container" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td align="center" style="line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">
                                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; margin: 0 auto;">
                                        <tbody>
                                            <tr>
                                                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="left" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                                    <img class="w-24" src="<?php Config::$mailLogo ?>" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 96px; border-style: none; border-width: 0;" width="96">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="center" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="card p-6 p-lg-10 space-y-4" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; width: 100%; overflow: hidden; border: 1px solid #e2e8f0;" bgcolor="#ffffff">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0; padding: 40px;" align="center" bgcolor="#ffffff">
                                                                    <h1 class="h3 fw-700" style="padding-top: 0; padding-bottom: 0; font-weight: 700 !important; vertical-align: baseline; font-size: 28px; line-height: 33.6px; margin: 0;" align="center">
                                                                        <?php echo $usuario['name']; ?>, a password reset was requested for your account.
                                                                    </h1>
                                                                    <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="center" width="100%" height="16">
                                                                                    &#160;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <p class="" style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="center">
                                                                        To reset your password, click the button below <br>
                                                                        If you have not requested this, ignore this message and contact our support team.<br>
                                                                    </p>
                                                                    <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="center" width="100%" height="16">
                                                                                    &#160;
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table class="btn btn-primary p-3 fw-700" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; font-weight: 700 !important;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="line-height: 24px; font-size: 16px; border-radius: 6px; font-weight: 700 !important; margin: 0;" align="center" bgcolor="#0d6efd">
                                                                                    <a href="<?php echo $urlToken; ?>" style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: 700 !important; white-space: nowrap; background-color: #0d6efd; padding: 12px; border: 1px solid #0d6efd;">
                                                                                        Reset Password</a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="center" width="100%" height="40">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 28px; margin: 0;" align="center">
                                                                    <h2 class="w-40" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 160px; border-style: none; border-width: 0; font-weight: bold; font-family: 'Courier New', Courier, monospace;" width="160">FIND IT<br>FORUMS</h2>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="center" width="100%" height="24">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="text-muted text-center" style="color: #718096;" align="center">
                                                        Sent with &lt;3 from Find It Support Team. <br>
                                                        Find It! Forums, Redefined. by Sergio Adam.<br>
                                                        Valencia, Spain. <br>
                                                    </div>
                                                    <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="center" width="100%" height="24">
                                                                    &#160;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

<?php $contenido = ob_get_clean();
    return $contenido;
}

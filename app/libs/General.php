<?php

/****
 * Librería con funciones generales y de validación
 * @author Sergio Adam
 * 
 */
/* ---------- NUEVAS FUNCIONES ----------- */

function getVisibilityBadge(int $visibility)
{
    switch ($visibility) {
        case 0:
            $badge = ' class="badge bg-danger">Private';
            break;
        case 1:
            $badge = ' class="badge bg-warning">Friends';
            break;
        case 2:
            $badge = ' class="badge bg-success">Public';
            break;
        default:
            $badge = ' class="badge bg-success">Public';
            break;
    }
    return $badge;
}
function cTextarea(string $text, string $campo, array &$errores, int $max = 300, int $min = 1)
{
    if ((mb_strlen($text) >= $min && mb_strlen($text) <= $max)) {

        return true;
    }
    $errores[$campo] = "El $campo permite de $min hasta $max caracteres";
    return false;
}

function cTextoarea(string $text, string $campo, array &$errores, int $max = 400, int $min = 3, bool $espacios = TRUE, bool $case = TRUE, bool $requerido = TRUE): bool
{
    if (!$requerido && $text == "") {
        return true;
    }
    $case = ($case === TRUE) ? "i" : "";
    $espacios = ($espacios === TRUE) ? " " : "";
    if ((preg_match("/^[a-zñ" . PHP_EOL . "$espacios]{" . $min . "," . $max . "}$/um$case", sinTildes($text)))) {
        return true;
    }
    $errores[$campo] = "Error in data field \"$campo\"";
    return false;
}

function cMail(string $mail, string $campo, array &$errores, bool $requerido = TRUE)
{
    // Remove all illegal characters from email
    $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

    // Validate e-mail
    return filter_var($mail, FILTER_VALIDATE_EMAIL);
}

function cPassw(string $text, string $campo, array &$errores, int $max = 30, int $min = 8, bool $espacios = false, bool $case = TRUE): bool
{
    $case = ($case === TRUE) ? "i" : "";
    $espacios = ($espacios === TRUE) ? " " : "";    //Permite @,$,*,-,_,+,&, caracteres alphanumericos 
    if ((preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\@\$\*\-_\+&])[A-Za-z\d\@\$\*\-_\+&]{" . $min . "," . $max . "}$/u$case", sinTildes($text)))) {
        return true;
    }
    $errores[$campo] = "Password does not meet the requirements.";
    return false;
}

function cAvatar(string $extensionFoto, array &$errores, string $dir, string $filename = NULL)
{ // "&" pasa por referencia para poder modificar la variable original.
    //Caso especial cuando el campo file no es requerido y no se intenta subir ningun archivo.
    $rutaAvatar = $dir . DIRECTORY_SEPARATOR . 'avatar' . '.' . $extensionFoto;
    $rutaFoto = Config::$profilesDir . DIRECTORY_SEPARATOR . $filename . '.' . $extensionFoto;
    if (copy($rutaAvatar, $rutaFoto)) {
        return $rutaFoto;
    } else {
        $errores['img'] = 'Error: Unable to set avatar image';
        return false;
    }
}
function cFotoUsuario(string $campo, array &$extValidas, string $extensionFoto, array &$errores, string $maxSize, string $dir, bool $requerido = TRUE, string $filename = NULL)
{ // "&" pasa por referencia para poder modificar la variable original.
    //Caso especial cuando el campo file no es requerido y no se intenta subir ningun archivo.
    if (!$requerido && $_FILES[$campo]['error'] === 4) {
        $rutaAvatar = $dir . DIRECTORY_SEPARATOR . 'avatar' . '.' . $extensionFoto;
        $rutaFoto = $dir . DIRECTORY_SEPARATOR . $filename . '.' . $extensionFoto;
        copy($rutaAvatar, $rutaFoto);
        return $rutaFoto;
    }
    //Si no se intenta subir ningun archivo y es requerido.
    if (!isset($_FILES[$campo]) && $requerido) {
        $errores[$campo] = "Error en el fichero $campo";
        return false;
    } else {
        //Cualquier otro caso comprueba los errores del archivo
        if (($_FILES[$campo]['error'] != 0)) {
            switch ($_FILES[$campo]['error']) {
                case 1:
                    $errores[$campo] = "UPLOAD_ERR_INI_SIZE. Fichero demasiado grande";
                    break;
                case 2:
                    $errores[$campo] = "UPLOAD_ERR_FORM_SIZE. El fichero es demasiado grande";
                    break;
                case 3:
                    $errores[$campo] = "UPLOAD_ERR_PARTIAL. El fichero no se ha podido subir entero";
                    break;
                case 4:
                    $errores[$campo] = "UPLOAD_ERR_NO_FILE. No se ha podido subir el fichero";
                    break;
                case 6:
                    $errores[$campo] = "UPLOAD_ERR_NO_TMP_DIR. Falta carpeta temporal<br>";
                case 7:
                    $errores[$campo] = "UPLOAD_ERR_CANT_WRITE. No se ha podido escribir en el disco<br>";

                default:
                    $errores[$campo] = 'Error indeterminado.';
            }
            return false;
        } else {
            /* Extraemos la extensión del fichero, desde el último punto. Si hubiese doble extensión, no lo
                * tendría en cuenta.
                */
            $extension = (is_null($extensionFoto) ? strtolower(pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION)) : $extensionFoto);
            /**
             * Guardamos el nombre original del fichero
             **/
            $nombreArchivo = (is_null($filename) ? $_FILES[$campo]['name'] : $filename . '.' . $extension);
            /*
                 * Guardamos nombre del fichero en el servidor
                */
            $directorioTemp = $_FILES[$campo]['tmp_name'];
            /*
                 * Calculamos el tamaño del fichero
                */
            $tamanyoFile = filesize($directorioTemp);

            /*
                * Comprobamos la extensión del archivo dentro de la lista que hemos definido al principio
                */
            if (!in_array($extension, $extValidas)) {
                $errores[$campo] = "La extensión del archivo no es válida " . var_dump($extension) . var_dump($nombreArchivo);;
                return false;
            }
            /*
                * Comprobamos el tamaño del archivo
                */
            if ($tamanyoFile > $maxSize) {
                $errores[$campo] = "El fichero debe de tener un tamaño inferior a " . floor($maxSize / pow(10, 6)) . " MB";
                return false;
            }

            /*
                * Si no ha habido errores, almacenamos el archivo en ubicación definitiva si no hay errores
                */
            if (empty($errores)) {
                if (is_dir($dir)) {
                    //Una vez validado el nombre:
                    $nombreCompleto = $dir . DIRECTORY_SEPARATOR . $nombreArchivo;
                    /**
                     * Movemos el fichero a la ubicación definitiva.
                     * */
                    if (move_uploaded_file($directorioTemp, $nombreCompleto)) {
                        //Si todo es correcto devuelve la ruta y nombre de fichero final.
                        return $nombreCompleto;
                    } else {
                        $errores[$campo] = "Ha habido un error al subir el fichero";
                        return false;
                    }
                } else {
                    $errores[$campo] = "No existe el directorio:" . $dir;
                    return false;
                }
            } else {
                $errores[$campo] = "Ha habido un error al subir el fichero";
                return false;
            }
        }
    }
}

function getResetBody($name, $user, $email, $urlToken)
{
    return "<h1>$name, you can reset your password.</h1>
    <p>A reset password request was made for the user: <b>$user</b></p>
    <p>The email linked to that account is: <b>$email</b></p>
    <p>Click the button below to reset your password!</p><br>
    <a href=" . $urlToken . "><b>Reset Password</b></a>";
}

function getTermsView()
{
    return "
    <div>
    <p style='text-align: center;'><strong>Terms &amp; Conditions</strong></p>
    <p style='text-align: center;'>Effective Date: <span id='span_id_effective_date'>May 4th, 2023</span></p>
    <p style='text-align: center;'><em>Site Covered: <span
                id='span_id_name_of_site_covered'>roldb.com</span><br /><br /></em></p>
    <p style='text-align: left;'><strong>THE AGREEMENT:</strong> The use of this website and services on this website
        provided by <span id='span_id_company_name'>Sergio Adam</span> (hereinafter referred to as 'Company') are
        subject to the following Terms &amp; Conditions (hereinafter the 'Agreement'), all parts and sub-parts of which
        are specifically incorporated by reference here. This Agreement shall govern the use of all pages on this
        website (hereinafter collectively referred to as 'Website') and any services provided by or on this Website
        ('Services').<br /><br /></p>
    <p style='text-align: left;'><strong>1) DEFINITIONS</strong></p>
    <p style='text-align: left;'>The parties referred to in this Agreement shall be defined as follows:</p>
    <p style='text-align: left; padding-left: 30px;'>a) Company, Us, We: The Company, as the creator, operator, and
        publisher of the Website, makes the Website, and certain Services on it, available to users. <span
            id='span_id_company_name'>Sergio Adam</span>, Company, Us, We, Our, Ours and other first-person pronouns
        will refer to the Company, as well as all employees and affiliates of the Company.</p>
    <p style='text-align: left; padding-left: 30px;'>b) You, the User, the Client: You, as the user of the Website, will
        be referred to throughout this Agreement with second-person pronouns such as You, Your, Yours, or as User or
        Client.</p>
    <p style='text-align: left; padding-left: 30px;'>c) Parties: Collectively, the parties to this Agreement (the
        Company and You) will be referred to as Parties.<br /><br /></p>
    <p style='text-align: left;'><strong>2) ASSENT &amp; ACCEPTANCE</strong></p>
    <p style='text-align: left;'>By using the Website, You warrant that You have read and reviewed this Agreement and
        that You agree to be bound by it. If You do not agree to be bound by this Agreement, please leave the Website
        immediately. The Company only agrees to provide use of this Website and Services to You if You assent to this
        Agreement.<br /><br /></p>

    <p style='text-align: left;'><strong>3) LICENSE TO USE WEBSITE</strong></p>
    <p style='text-align: left;'>The Company may provide You with certain information as a result of Your use of the
        Website or Services. Such information may include, but is not limited to, documentation, data, or information
        developed by the Company, and other materials which may assist in Your use of the Website or Services ('Company
        Materials'). Subject to this Agreement, the Company grants You a non-exclusive, limited, non-transferable and
        revocable license to use the Company Materials solely in connection with Your use of the Website and Services.
        The Company Materials may not be used for any other purpose, and this license terminates upon Your cessation of
        use of the Website or Services or at the termination of this Agreement.<br /><br /></p>
    <p style='text-align: left;'><strong>4) INTELLECTUAL PROPERTY</strong></p>
    <p style='text-align: left;'>You agree that the Website and all Services provided by the Company are the property of
        the Company, including all copyrights, trademarks, trade secrets, patents, and other intellectual property
        ('Company IP'). You agree that the Company owns all right, title and interest in and to the Company IP and that
        You will not use the Company IP for any unlawful or infringing purpose. You agree not to reproduce or distribute
        the Company IP in any way, including electronically or via registration of any new trademarks, trade names,
        service marks or Uniform Resource Locators (URLs), without express written permission from the Company.</p>
    <p style='text-align: left; padding-left: 30px;'>a) In order to make the Website and Services available to You, You
        hereby grant the Company a royalty-free, non-exclusive, worldwide license to copy, display, use, broadcast,
        transmit and make derivative works of any content You publish, upload, or otherwise make available to the
        Website ('Your Content'). The Company claims no further proprietary rights in Your Content.</p>
    <p style='text-align: left; padding-left: 30px;'>b) If You feel that any of Your intellectual property rights have
        been infringed or otherwise violated by the posting of information or media by another of Our users, please
        contact Us and let Us know.<br /></p>
    <p><strong> <br />5) USER OBLIGATIONS</strong></p>
    <p>As a user of the Website or Services, You may be asked to register with Us. When You do so, You will choose a
        user identifier, which may be Your email address or another term, as well as a password. You may also provide
        personal information, including, but not limited to, Your name. You are responsible for ensuring the accuracy of
        this information. This identifying information will enable You to use the Website and Services. You must not
        share such identifying information with any third party, and if You discover that Your identifying information
        has been compromised, You agree to notify Us immediately in writing. Email notification will suffice. You are
        responsible for maintaining the safety and security of Your identifying information as well as keeping Us
        apprised of any changes to Your identifying information. The billing information You provide us, including
        credit card, billing address and other payment information, is subject to the same confidentiality and accuracy
        requirements as the rest of Your identifying information. Providing false or inaccurate information, or using
        the Website or Services to further fraud or unlawful activity is grounds for immediate termination of this
        Agreement.<br /><br /></p>
    <p><strong>6) PAYMENT &amp; FEES </strong></p>
    <p>Should You register for any of the paid Services on this website or purchase any product or service on this
        website, You agree to pay Us the specific monetary amounts required for that product or those Services. These
        monetary amounts ('Fees') will be described to You during Your account registration and/or confirmation process.
        The final amount required for payment will be shown to You immediately prior to purchase. </p>
    <p><strong>7) ACCEPTABLE USE</strong></p>
    <p>You agree not to use the Website or Services for any unlawful purpose or any purpose prohibited under this
        clause. You agree not to use the Website or Services in any way that could damage the Website, Services, or
        general business of the Company.</p>
    <p style='padding-left: 30px;'>a) You further agree not to use the Website or Services:</p>
    <p style='padding-left: 60px;'>I) To harass, abuse, or threaten others or otherwise violate any person's legal
        rights;</p>
    <p style='padding-left: 60px;'>II) To violate any intellectual property rights of the Company or any third party;
    </p>
    <p style='padding-left: 60px;'>III) To upload or otherwise disseminate any computer viruses or other software that
        may damage the property of another;</p>
    <p style='padding-left: 60px;'>IV) To perpetrate any fraud;</p>
    <p style='padding-left: 60px;'>V) To engage in or create any unlawful gambling, sweepstakes, or pyramid scheme;</p>
    <p style='padding-left: 60px;'>VI) To publish or distribute any obscene or defamatory material;</p>
    <p style='padding-left: 60px;'>VII) To publish or distribute any material that incites violence, hate, or
        discrimination towards any group;</p>
    <p style='padding-left: 60px;'>VIII) To unlawfully gather information about others.<br /><br /></p>

    <p><strong>8) SALES</strong></p>
    <p>The Company may sell goods or services or allow third parties to sell goods or services on the Website. The
        Company undertakes to be as accurate as possible with all information regarding the goods and services,
        including product descriptions and images. However, the Company does not guarantee the accuracy or reliability
        of any product information, and You acknowledge and agree that You purchase such products at Your own risk. </p>

    <p><strong><br />9) REVERSE ENGINEERING &amp; SECURITY</strong></p>
    <p>You agree not to undertake any of the following actions:</p>
    <p style='padding-left: 30px;'>a) Reverse engineer, or attempt to reverse engineer or disassemble any code or
        software from or on the Website or Services;</p>
    <p style='padding-left: 30px;'>b) Violate the security of the Website or Services through any unauthorized access,
        circumvention of encryption or other security tools, data mining or interference to any host, user or
        network.<br /><br /></p>
    <p><strong>10) DATA LOSS</strong></p>
    <p>The Company does not accept responsibility for the security of Your account or content. You agree that Your use
        of the Website or Services is at Your own risk.<br /><br /></p>
    <p><strong>11) INDEMNIFICATION</strong></p>
    <p>You agree to defend and indemnify the Company and any of its affiliates (if applicable) and hold Us harmless
        against any and all legal claims and demands, including reasonable attorney's fees, which may arise from or
        relate to Your use or misuse of the Website or Services, Your breach of this Agreement, or Your conduct or
        actions. You agree that the Company shall be able to select its own legal counsel and may participate in its own
        defense, if the Company wishes.<br /><br /></p>
    <p><strong>12) SPAM POLICY</strong></p>
    <p>You are strictly prohibited from using the Website or any of the Company's Services for illegal spam activities,
        including gathering email addresses and personal information from others or sending any mass commercial
        emails.<br /><br /></p>
    <p><strong>13) THIRD-PARTY LINKS &amp; CONTENT</strong></p>
    <p>The Company may occasionally post links to third party websites or other services. You agree that the Company is
        not responsible or liable for any loss or damage caused as a result of Your use of any third party services
        linked to from Our Website.<br /><br /></p>
    <p><strong>14) MODIFICATION &amp; VARIATION</strong></p>
    <p>The Company may, from time to time and at any time without notice to You, modify this Agreement. You agree that
        the Company has the right to modify this Agreement or revise anything contained herein. You further agree that
        all modifications to this Agreement are in full force and effect immediately upon posting on the Website and
        that modifications or variations will replace any prior version of this Agreement, unless prior versions are
        specifically referred to or incorporated into the latest modification or variation of this Agreement.</p>
    <p style='text-align: left; padding-left: 30px;'>a) To the extent any part or sub-part of this Agreement is held
        ineffective or invalid by any court of law, You agree that the prior, effective version of this Agreement shall
        be considered enforceable and valid to the fullest extent.</p>
    <p style='text-align: left; padding-left: 30px;'>b) You agree to routinely monitor this Agreement and refer to the
        Effective Date posted at the top of this Agreement to note modifications or variations. You further agree to
        clear Your cache when doing so to avoid accessing a prior version of this Agreement. You agree that Your
        continued use of the Website after any modifications to this Agreement is a manifestation of Your continued
        assent to this Agreement.</p>
    <p style='text-align: left; padding-left: 30px;'>c) In the event that You fail to monitor any modifications to or
        variations of this Agreement, You agree that such failure shall be considered an affirmative waiver of Your
        right to review the modified Agreement.<br /><br /></p>
    <p style='text-align: left;'><strong>15) ENTIRE AGREEMENT</strong></p>
    <p style='text-align: left;'>This Agreement constitutes the entire understanding between the Parties with respect to
        any and all use of this Website. This Agreement supersedes and replaces all prior or contemporaneous agreements
        or understandings, written or oral, regarding the use of this Website.<br /><br /></p>
    <p style='text-align: left;'><strong>16) SERVICE INTERRUPTIONS</strong></p>
    <p style='text-align: left;'>The Company may need to interrupt Your access to the Website to perform maintenance or
        emergency services on a scheduled or unscheduled basis. You agree that Your access to the Website may be
        affected by unanticipated or unscheduled downtime, for any reason, but that the Company shall have no liability
        for any damage or loss caused as a result of such downtime.<br /><br /></p>
    <p style='text-align: left;'><strong>17) TERM, TERMINATION &amp; SUSPENSION</strong></p>
    <p style='text-align: left;'>The Company may terminate this Agreement with You at any time for any reason, with or
        without cause. The Company specifically reserves the right to terminate this Agreement if You violate any of the
        terms outlined herein, including, but not limited to, violating the intellectual property rights of the Company
        or a third party, failing to comply with applicable laws or other legal obligations, and/or publishing or
        distributing illegal material. If You have registered for an account with Us, You may also terminate this
        Agreement at any time by contacting Us and requesting termination. Please keep in mind that any outstanding fees
        will still be due even after termination of Your account. At the termination of this Agreement, any provisions
        that would be expected to survive termination by their nature shall remain in full force and effect.<br /><br />
    </p>
    <p style='text-align: left;'><strong>18) NO WARRANTIES</strong></p>
    <p style='text-align: left;'>You agree that Your use of the Website and Services is at Your sole and exclusive risk
        and that any Services provided by Us are on an 'As Is' basis. The Company hereby expressly disclaims any and all
        express or implied warranties of any kind, including, but not limited to the implied warranty of fitness for a
        particular purpose and the implied warranty of merchantability. The Company makes no warranties that the Website
        or Services will meet Your needs or that the Website or Services will be uninterrupted, error-free, or secure.
        The Company also makes no warranties as to the reliability or accuracy of any information on the Website or
        obtained through the Services. You agree that any damage that may occur to You, through Your computer system, or
        as a result of loss of Your data from Your use of the Website or Services is Your sole responsibility and that
        the Company is not liable for any such damage or loss.<br /><br /></p>
    <p><strong>19) LIMITATION ON LIABILITY</strong></p>
    <p>The Company is not liable for any damages that may occur to You as a result of Your use of the Website or
        Services, to the fullest extent permitted by law. The maximum liability of the Company arising from or relating
        to this Agreement</p>
    <p><strong>20) GENERAL PROVISIONS:</strong></p>
    <p style='padding-left: 30px;'><strong>a) LANGUAGE:</strong> All communications made or notices given pursuant to
        this Agreement shall be in the English language.</p>
    <p style='padding-left: 30px;'><strong>b) JURISDICTION, VENUE &amp; CHOICE OF LAW:</strong> Through Your use of the
        Website or Services, You agree that the laws of the State of <span
            id='span_id_state_of_residence_of_client'>California</span> shall govern any matter or dispute relating to
        or arising out of this Agreement, as well as any dispute of any kind that may arise between You and the Company,
        with the exception of its conflict of law provisions. In case any litigation specifically permitted under this
        Agreement is initiated, the Parties agree to submit to the personal jurisdiction of the state and federal courts
        of the following county: <span id='span_id_county_of_business'>Valencia</span>, <span
            id='span_id_state_of_residence_of_client'>California</span>. The Parties agree that this choice of law,
        venue, and jurisdiction provision is not permissive, but rather mandatory in nature. You hereby waive the right
        to any objection of venue, including assertion of the doctrine of forum non conveniens or similar doctrine.</p>
    <p style='padding-left: 30px;'><strong>c) ARBITRATION:</strong> In case of a dispute between the Parties relating to
        or arising out of this Agreement, the Parties shall first attempt to resolve the dispute personally and in good
        faith. If these personal resolution attempts fail, the Parties shall then submit the dispute to binding
        arbitration. The arbitration shall be conducted in the following county: <span
            id='span_id_county_of_business'>Valencia</span>. The arbitration shall be conducted by a single arbitrator,
        and such arbitrator shall have no authority to add Parties, vary the provisions of this Agreement, award
        punitive damages, or certify a class. The arbitrator shall be bound by applicable and governing Federal law as
        well as the law of the following state: <span id='span_id_state_of_residence_of_client'>California</span>. Each
        Party shall pay their own costs and fees. Claims necessitating arbitration under this section include, but are
        not limited to: contract claims, tort claims, claims based on Federal and state law, and claims based on local
        laws, ordinances, statutes or regulations. <em>Intellectual property claims by the Company will not be subject
            to arbitration and may, as an exception to this sub-part, be litigated. </em>The Parties, in agreement with
        this sub-part of this Agreement, waive any rights they may have to a jury trial in regard to arbitral claims.
    </p>
    <p style='padding-left: 30px;'><strong>e) SEVERABILITY:</strong> If any part or sub-part of this Agreement is held
        invalid or unenforceable by a court of law or competent arbitrator, the remaining parts and sub-parts will be
        enforced to the maximum extent possible. In such condition, the remainder of this Agreement shall continue in
        full force.</p>
    <p style='padding-left: 30px;'><strong>f) NO WAIVER:</strong> In the event that We fail to enforce any provision of
        this Agreement, this shall not constitute a waiver of any future enforcement of that provision or of any other
        provision. Waiver of any part or sub-part of this Agreement will not constitute a waiver of any other part or
        sub-part.</p>
    <p style='padding-left: 30px;'><strong>g) HEADINGS FOR CONVENIENCE ONLY:</strong> Headings of parts and sub-parts
        under this Agreement are for convenience and organization, only. Headings shall not affect the meaning of any
        provisions of this Agreement.</p>
    <p style='padding-left: 30px;'><strong>h) NO AGENCY, PARTNERSHIP OR JOINT VENTURE:</strong> No agency, partnership,
        or joint venture has been created between the Parties as a result of this Agreement. No Party has any authority
        to bind the other to third parties.</p>
    <p style='padding-left: 30px;'><strong>j) ELECTRONIC COMMUNICATIONS PERMITTED:</strong> Electronic communications
        are permitted to both Parties under this Agreement, including e-mail or fax. For any questions or concerns,
        please email Us at the following address: <span id='span_id_email_address_of_client'
            class='encours'>findit.forums@gmail.com</span>.</p>
    </div>";
}

/* ---------- FIN NUEVAS FUNCIONES ----------- */



//***** Funciones de sanitización **** //


/**
 * funcion sinTildes
 *
 * Elimina caracteres con tilde de las cadenas
 * 
 * @param string $frase
 * @return string
 */

function sinTildes($frase): string
{
    $no_permitidas = array(
        "á",
        "é",
        "í",
        "ó",
        "ú",
        "Á",
        "É",
        "Í",
        "Ó",
        "Ú",
        "à",
        "è",
        "ì",
        "ò",
        "ù",
        "À",
        "È",
        "Ì",
        "Ò",
        "Ù"
    );
    $permitidas = array(
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U",
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U"
    );
    $texto = str_replace($no_permitidas, $permitidas, $frase);
    return $texto;
}

/**
 * Funcion sinEspacios
 * 
 * Elimina los espacios de una cadena de texto
 * 
 * @param string $frase
 * @param string $espacio
 * @return string
 */

function sinEspacios($frase)
{
    $texto = trim(preg_replace('/ +/', ' ', $frase));
    return $texto;
}


/**
 * Funcion recoge
 * 
 * Sanitiza cadenas de texto
 * 
 * @param string $var
 * @return string
 */

function recoge(string $var)
{
    if (isset($_REQUEST[$var]) && (!is_array($_REQUEST[$var]))) {
        $tmp = sinEspacios($_REQUEST[$var]);
        $tmp = strip_tags($tmp);
    } else
        $tmp = "";

    return $tmp;
}

/**
 * Funcion recogeArray
 * 
 * Sanitiza arrays
 * 
 * @param string $var
 * @return array
 */

function recogeArray(string $var): array
{
    $array = [];
    if (isset($_REQUEST[$var]) && (is_array($_REQUEST[$var]))) {
        foreach ($_REQUEST[$var] as $valor)
            $array[] = strip_tags(sinEspacios($valor));
    }

    return $array;
}

//***** Funciones de validación **** //

/**
 * Funcion cTexto
 *
 * Valida una cadena de texto con respecto a una RegEx. Reporta error en un array.
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param integer $min
 * @param integer $max
 * @param bool $espacios
 * @param bool $case
 * @return bool
 */


function cTexto(string $text, string $campo, array &$errores, int $max = 30, int $min = 3, bool $espacios = TRUE, bool $case = TRUE, bool $requerido = TRUE): bool
{
    if (!$requerido && $text == "") {
        return true;
    }
    $case = ($case === TRUE) ? "i" : "";
    $espacios = ($espacios === TRUE) ? " " : "";
    if ((preg_match("/^[a-zñ$espacios]{" . $min . "," . $max . "}$/u$case", sinTildes($text)))) {
        return true;
    }
    $errores[$campo] = "Error in data field \"$campo\"";
    return false;
}


/**
 * Funcion cUser
 *
 * Valida una cadena de texto con respecto a una RegEx. Reporta error en un array.
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param integer $min
 * @param integer $max
 * @return bool
 */


function cUser(string $text, string $campo, array &$errores, int $max = 30, int $min = 1): bool
{

    if ((preg_match("/^[a-zA-Z0-9_]{" . $min . "," . $max . "}$/u", sinTildes($text)))) {
        return true;
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}

function unixFechaAAAAMMDD($fecha, $campo, &$errores)
{

    $arrayfecha = explode("-", $fecha);
    if (count($arrayfecha) == 3) {
        $fechavalida = checkdate($arrayfecha[1], $arrayfecha[2], $arrayfecha[0]);

        if ($fechavalida) {

            return mktime(0, 0, 0, $arrayfecha[2], $arrayfecha[1], $arrayfecha[0]);
        }
    }
    $errores[$campo] = "Date is not valid.";
    return false;
}

/**
 * Funcion cNum
 *
 * Valida que un string sea numerico menor o igual que un número y si es o no requerido
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param bool $requerido
 * @param integer $max
 * @return bool
 */
function cNum(string $num, string $campo, array &$errores, bool $requerido = TRUE, int $max = PHP_INT_MAX): bool
{
    $cuantificador = ($requerido) ? "+" : "*";
    if ((preg_match("/^[0-9]" . $cuantificador . "$/", $num))) {

        if ($num <= $max) return true;
    }
    $errores[$campo] = "Please enter a valid value in \"$campo\".";
    return false;
}

/**
 * Funcion cRadio
 *
 * Valida que un string se encuentre entre los valores posibles. Si es requerido o no
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param array $valores
 * @param bool $requerido
 * 
 * @return boolean
 */
function cRadio(string $text, string $campo, array &$errores, array $valores, bool $requerido = TRUE)
{
    if (in_array($text, $valores)) {
        return true;
    }
    if (!$requerido && $text == "") {
        return true;
    }
    $errores[$campo] = "Selection is not an option in \"$campo\".";
    return false;
}

function cSelect(string $text, string $campo, array &$errores, array $valores, bool $requerido = TRUE)
{
    if (array_key_exists($text, $valores)) {
        return true;
    }
    if (!$requerido && $text == "") {
        return true;
    }
    $errores[$campo] = "Selection is not an option in \"$campo\".";
    return false;
}
/**
 * Funcion cCheck
 *
 * Valida que los valores seleccionado en un checkbox array están dentro de los 
 * valores válidos dados en un array. Si es requerido o no
 * 
 * 
 * @param array $text
 * @param string $campo
 * @param array $errores
 * @param array $valores
 * @param bool $requerido
 * 
 * @return boolean
 */

function cCheck(array $text, string $campo, array &$errores, array $valores, bool $requerido = TRUE)
{

    if (($requerido) && (count($text) == 0)) {
        $errores[$campo] = "At least one must be checked in \"$campo\".";
        return false;
    }
    foreach ($text as $valor) {
        if (!in_array($valor, $valores)) {
            $errores[$campo] = "Selection is not an option in \"$campo\".";
            return false;
        }
    }
    return true;
}


/**
 * Funcion cFile
 * 
 * Valida la subida de un archivo a un servidor.
 *
 * @param string $nombre
 * @param array $extensiones_validas
 * @param string $directorio
 * @param integer $max_file_size
 * @param array $errores
 * @param boolean $required
 * @return boolean|string
 */
function cFile(string $nombre, array &$errores, array $extensionesValidas, string $directorio, int  $max_file_size,  bool $required = TRUE)
{
    // Caso especial que el campo de file no es requerido y no se intenta subir ningun archivo
    if ((!$required) && $_FILES[$nombre]['error'] === 4)
        return true;
    // En cualquier otro caso se comprueban los errores del servidor 
    if ($_FILES[$nombre]['error'] != 0) {
        $errores["$nombre"] = "There was a problem while uploading \"" . $nombre . "\".<br>Please try again";
        return false;
    } else {

        $nombreArchivo = strip_tags($_FILES["$nombre"]['name']);
        /*
             * Guardamos nombre del fichero en el servidor
            */
        $directorioTemp = $_FILES["$nombre"]['tmp_name'];
        /*
             * Calculamos el tamaño del fichero
            */
        $tamanyoFile = filesize($directorioTemp);

        /*
            * Extraemos la extensión del fichero, desde el último punto.
            */
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

        /*
            * Comprobamos la extensión del archivo dentro de la lista que hemos definido al principio
            */
        if (!in_array($extension, $extensionesValidas)) {
            $errores["$nombre"] = "The file's extension is not valid.";
            return false;
        }
        /*
            * Comprobamos el tamaño del archivo
            */
        if ($tamanyoFile > $max_file_size) {
            $errores["$nombre"] = "Maximum file size allowed is:" . floor($max_file_size / pow(10, 6)) . "MB";
            return false;
        }

        // Almacenamos el archivo en ubicación definitiva si no hay errores ( al compartir array de errores TODOS LOS ARCHIVOS tienen que poder procesarse para que sea exitoso. Si cualquiera da error, NINGUNO  se procesa)

        if (empty($errores)) {
            /**
             * Comprobamos si el directorio pasado es válido
             */
            if (is_dir($directorio)) {
                /**
                 * Tenemos que buscar un nombre único para guardar el fichero de manera definitiva.
                 * Podemos hacerlo de diferentes maneras, en este caso se hace añadiendo microtime() al nombre del fichero 
                 * si ya existe un archivo guardado con ese nombre.
                 * */
                $nombreArchivo = is_file($directorio . DIRECTORY_SEPARATOR . $nombreArchivo) ? time() . $nombreArchivo : $nombreArchivo;
                $nombreCompleto = $directorio . DIRECTORY_SEPARATOR . $nombreArchivo;
                /**
                 * Movemos el fichero a la ubicación definitiva.
                 * */
                if (move_uploaded_file($directorioTemp, $nombreCompleto)) {
                    /**
                     * Si todo es correcto devuelve la ruta y nombre del fichero como se ha guardado
                     */


                    return $nombreCompleto;
                } else {
                    $errores["$nombre"] = "Ha habido un error al subir el fichero";
                    return false;
                }
            } else {
                $errores["$nombre"] = "Ha habido un error al subir el fichero";
                return false;
            }
        }
    }
    return false;
}




function crypt_blowfish($password)
{

    $salt = '$2a$07$usesomesillystringforsalt$';
    $pass = crypt($password, $salt);

    return $pass;
}

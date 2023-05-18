<?php

class FindIt extends Modelo
{
    // LOGIN
    public function consultarUsuario($user)
    {
        $consulta = "SELECT * FROM fi_users WHERE username = :user OR email = :user";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':user', $user);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserId($user)
    {
        $consulta = "SELECT user_id FROM fi_users WHERE username = :user OR email = :user";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':user', $user);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    // REGISTER
    public function insertarUsuario(string $firstname, string $lastname, string $user, string $passw, string $email, $lastSession, string $picturePath, int $countryId, int $provinceId, string $gender = null, string $lang = 'en', $lastIp = null, $lastDevice = null, $loginAttempts = 0)
    {
        $consulta = "INSERT INTO fi_users 
        (username, password, name, surname, email, last_access_time, last_access_ip, 
        last_device_info, login_failed_attempts, gender, country_id, province_id, language, picture_path) 
        VALUES 
        (:user, :passw, :firstname, :lastname, :email, :lastAccessTime, :lastAccessIp, 
        :lastDeviceInfo, :loginFailedAttempts, :gender, :countryId, :provinceId, :lang, :picturePath);";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':user', $user);
        $result->bindParam(':passw', $passw);
        $result->bindParam(':firstname', $firstname);
        $result->bindParam(':lastname', $lastname);
        $result->bindParam(':email', $email);
        $result->bindParam(':lastAccessTime', $lastSession);
        $result->bindParam(':lastAccessIp', $lastIp);
        $result->bindParam(':lastDeviceInfo', $lastDevice);
        $result->bindParam(':loginFailedAttempts', $loginAttempts);
        $result->bindParam(':gender', $gender);
        $result->bindParam(':countryId', $countryId);
        $result->bindParam(':provinceId', $provinceId);
        $result->bindParam(':lang', $lang);
        $result->bindParam(':picturePath', $picturePath);
        $result->execute();
        return $result;
    }
    // PROVINCIAS
    public function getProvincias(int $countryId)
    {
        $consulta = "SELECT * FROM fi_countries_provinces WHERE country_id LIKE :countryId";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':countryId', $countryId);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // COUNTRIES
    public function getCountries()
    {
        $consulta = "SELECT * FROM fi_countries";
        $result = $this->connection->prepare($consulta);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    function cProvinciaBD($provinceId, array &$errores)
    {
        $consulta = "SELECT province_id FROM fi_countries_provinces
        WHERE province_id LIKE :provinceId";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':provinceId', $provinceId);
        $result->execute();

        $resultado = $result->fetch(PDO::FETCH_ASSOC);
        if ($resultado["province_id"] == $provinceId) {
            return true;
        } else {
            $errores["province"] = "The province selected does not exist.";
            return false;
        }
    }

    function cUserBD(String $user)
    {
        $consulta = "SELECT username FROM fi_users
        WHERE username LIKE :user";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':user', $user);
        $result->execute();

        $resultado = $result->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function cMailBD($email)
    {
        $consulta = "SELECT email FROM fi_users
        WHERE email LIKE :email";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':email', $email);
        $result->execute();

        $resultado = $result->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function getUserByMail($email)
    {
        $consulta = "SELECT user_id, username, 'name', email, verified, 'disabled' FROM fi_users
        WHERE email LIKE :email";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':email', $email);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    function getUserById($userId)
    {
        $consulta = "SELECT username, name, email, verified, disabled FROM fi_users
        WHERE user_id LIKE :userId";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':userId', $userId);
        return $result->execute();
    }

    function insertarToken(int $userId, string &$token, int $expireOffset = 3600, string $verification = 'account')
    {
        $token = genToken($userId);
        $hora = horaActual() + $expireOffset;
        $consulta = "INSERT INTO fi_tokens (token_value, user_id, date_expired, verification) VALUES (:token, :userId, :expires, :verification);";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':token', $token);
        $result->bindParam(':userId', $userId);
        $result->bindParam(':expires', $hora);
        $result->bindParam(':verification', $verification);

        $result->execute();
        return $result;
    }

    function getToken($token)
    {
        $consulta = "SELECT * FROM fi_tokens
        WHERE token_value LIKE '$token'";
        $result = $this->connection->prepare($consulta);
        $result->execute();

        $resultado = $result->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function usedToken($user, $email = '')
    {
        $consulta = "UPDATE fi_tokens SET used = '1' WHERE user_id = :user";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':user', $user);

        $result->execute();
        return $result;
    }

    function resetPassw($passw, $user)
    {
        $consulta = "UPDATE fi_users SET 'password' = :passw WHERE email = :user;";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':user', $user);
        $result->bindParam(':passw', $passw);

        $result->execute();
        return $result;
    }

    function verifyUser($user)
    {
        $consulta = "UPDATE fi_users SET verified = '1' WHERE user_id = :user;";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':user', $user);

        $result->execute();
        return $result;
    }

    function userLogin($userId, $newIp, $newDevice, $failedLogins = 0)
    {
        $hora = horaActual();
        $consulta = "UPDATE fi_users SET
         last_access_time = :newTime, last_access_ip = :newIp, 
         last_device_info = :newDeviceInfo, login_failed_attempts = :newFailedLogins 
         WHERE user_id = :userId;";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':newTime', $hora);
        $result->bindParam(':newIp', $newIp);
        $result->bindParam(':newDeviceInfo', $newDevice);
        $result->bindParam(':newFailedLogins', $failedLogins);
        $result->bindParam(':userId', $userId);

        $result->execute();
        return $result;
    }

    function getVerified($user)
    {
        $consulta = "SELECT verified FROM fi_users
        WHERE user_id = :user";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':user', $user);
        $result->execute();

        $resultado = $result->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    function countUsers()
    {
        $consulta = "SELECT count(user_id) FROM fi_users";
        $result = $this->connection->prepare($consulta);
        $result->execute();

        $resultado = $result->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    function countPosts()
    {
        $consulta = "SELECT count(topic_id) FROM fi_topics";
        $result = $this->connection->prepare($consulta);
        $result->execute();

        $resultado = $result->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    // AJAX FUNCTIONS
    function updatePostVisibility(int $topic, int $visibility = 0)
    {
        $consulta = "UPDATE fi_topics SET visibility = :vis WHERE topic_id = :topic;";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':topic', $topic);
        $result->bindParam(':vis', $visibility);

        $result->execute();
        return $result;
    }
    //
    function getUserInfo($idUser)
    {
        $consulta = "SELECT * FROM fi_users
        WHERE user_id LIKE :idUser OR username = :idUser";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':idUser', $idUser);
        $result->execute();

        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function getUserHabilitada($valor = '0')
    {
        $consulta = "SELECT id, Nombre, Apellidos, User, Email, Municipio, Validada, Habilitada, Ult_Ses  FROM fi_users
        WHERE Habilitada = :valor";
        $result = $this->connection->prepare($consulta);
        //$result->bindParam(':campo', $campo);
        $result->bindParam(':valor', $valor);
        $result->execute();

        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function getUserValidada($valor = '0')
    {
        $consulta = "SELECT id, Nombre, Apellidos, User, Email, Municipio, Validada, Habilitada, Ult_Ses  FROM fi_users
        WHERE Validada = :valor";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':valor', $valor);
        $result->execute();

        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function getUserOld($valor = '0')
    {
        $consulta = "SELECT id, Nombre, Apellidos, User, Email, Municipio, Validada, Habilitada, Ult_Ses  FROM fi_users
        WHERE Ult_Ses < :valor";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':valor', $valor);
        $result->execute();

        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function updateHabilitada($user, $habilitada = '0')
    {
        $consulta = "UPDATE users SET Habilitada = :habilitada WHERE User = :user;";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':user', $user);
        $result->bindParam(':habilitada', $habilitada);

        $result->execute();
        return $result;
    }

    function updateUserInfo($name, $lastname, $town, $descripcion)
    {
        $idUser = $_SESSION['idUser'];
        $consulta = "UPDATE users SET Nombre = :nombre, Apellidos = :lastname, Descripcion = :descripcion, Municipio = :town  WHERE id = :idUser;";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':nombre', $name);
        $result->bindParam(':lastname', $lastname);
        $result->bindParam(':town', $town);
        $result->bindParam(':idUser', $idUser);
        $result->bindParam(':descripcion', $descripcion);

        $result->execute();
        return $result;
    }

    function updateUserPicture($rutaUser)
    {
        $idUser = $_SESSION['idUser'];
        $consulta = "UPDATE fi_users SET picture_path = :ruta  WHERE user_id = :idUser;";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':ruta', $rutaUser);
        $result->bindParam(':idUser', $idUser);

        $result->execute();
        return $result;
    }

    // Forum requests

    function getPublicPosts()
    {
        $consulta = "SELECT * FROM fi_topics
        LEFT JOIN fi_users on fi_users.user_id = fi_topics.user_id
        WHERE visibility = '2'
        ORDER BY date_created DESC";
        $result = $this->connection->prepare($consulta);
        $result->execute();

        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function getUserPosts($user)
    {
        $consulta = "SELECT * FROM fi_topics
        LEFT JOIN fi_users on fi_users.user_id = fi_topics.user_id
        WHERE fi_topics.user_id = :idUser
        ORDER BY date_created DESC";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':idUser', $user);
        $result->execute();

        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function getSavedPosts($user)
    {
        $consulta = "SELECT * FROM fi_topics_saved
        LEFT JOIN fi_users on fi_users.user_id = fi_topics_saved.user_id
        LEFT JOIN fi_topics on fi_topics.topic_id = fi_topics_saved.topic_id
        WHERE fi_topics.user_id = :idUser
        ORDER BY date_created DESC";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':idUser', $user);
        $result->execute();

        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function insertaBicho($nombre,  $nivel,  $fue, $destr,  $cons,  $sab, $intel, $car,  $atb, $size,  $tipo,  $iduser,  $descripcion)
    {

        /* $consulta = "INSERT INTO bichos (Nombre, Nivel, FUERZA, DESTREZA , CONSTITUCION , SABIDURIA , INTELIGENCIA , CARISMA ,ATB,idTamanyo,idTipo,idUser,Descripcion)
        VALUES (':nombre' , ':nivel' ,':fue' , ':destr' , ':cons' , ':sab' , ':intel' , ':car' , ':atb' , ':size' , ':tipo' , ':user' , ':descripcion' )";
        */
        $consulta = "INSERT INTO roldb.bichos (Nombre, Nivel, FUERZA, DESTREZA , CONSTITUCION , SABIDURIA , INTELIGENCIA , CARISMA ,ATB,idTamanyo,idTipo,idUser,Descripcion)
        VALUES ('$nombre' , '$nivel' , '$fue' , '$destr' , '$cons' , '$sab' , '$intel' , '$car' , '$atb' , '$size' , '$tipo' , '$iduser' , '$descripcion' )";

        $result = $this->connection->prepare($consulta);
        /* $result->bindParam(':nombre', $nombre);
        $result->bindParam(':nivel', $nivel);
        $result->bindParam(':fue', $fue);
        $result->bindParam(':destr', $destr);
        $result->bindParam(':cons', $cons);
        $result->bindParam(':sab', $sab);
        $result->bindParam(':intel', $intel);
        $result->bindParam(':car', $car);
        $result->bindParam(':atb', $atb);
        $result->bindParam(':size', $size);
        $result->bindParam(':tipo', $tipo);
        $result->bindParam(':iduser', $iduser);
        $result->bindParam(':descripcion', $descripcion);
*/

        $result->execute();
        return $result;
    }

























    public function listarUsuarios()
    {
        $consulta = "SELECT * FROM users ORDER BY Nombre ASC";
        $result = $this->connection->query($consulta);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearTemaForo($idUser, $idTag, $nombre, $likes = 0)
    {
        $fechaCreacion = horaActual();
        $consulta = "INSERT INTO roldb.tema_foro (idUser, idTag, Nombre, Likes, FechaCreacion) VALUES (:idUser, :idTag, :nombre, :likes, :fechaCreacion)";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':idUser', $idUser);
        $result->bindParam(':idTag', $idTag);
        $result->bindParam(':nombre', $nombre);
        $result->bindParam(':likes', $likes);
        $result->bindParam(':fechaCreacion', $fechaCreacion);
        $result->execute();
        return $result;
    }

    public function eliminarTemaForo($idTema)
    {
        $consulta = "DELETE FROM tema_foro WHERE id LIKE :idTema";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':idTema', $idTema);
        $result->execute();
        return $result;
    }

    public function selectForumTags()
    {
        $consulta = "SELECT * FROM tags";
        $result = $this->connection->query($consulta);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkForumTags($idTag)
    {
        $consulta = "SELECT * FROM tags WHERE idTag LIKE :idTag";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':idTag', $idTag);
        $result->execute();

        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function selectForumTopics()
    {
        $consulta = "SELECT * FROM tema_foro ORDER BY FechaCreacion ASC";
        $result = $this->connection->query($consulta);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectBichosPublic($num)
    {
        $consulta = "SELECT * FROM bichos WHERE Visibilidad LIKE :Visibilidad;";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':Visibilidad', $num);
        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function selectBichosPrivate($idUser)
    {
        $consulta = "SELECT * FROM bichos WHERE idUser LIKE :idUser;";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':idUser', $idUser);
        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function deleteMonsters($idMonster)
    {
        $consulta = "DELETE FROM bichos WHERE id LIKE :idMonster";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':idMonster', $idMonster);
        $result->execute();
        return $result;
    }

    public function selectMonster($idMonster)
    {
        $consulta = "SELECT * FROM bichos WHERE id LIKE $idMonster;";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':id', $idMonster);
        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function selectAllBichos($idUser)
    {
        $consulta = "SELECT * FROM bichos WHERE idUser LIKE :idUser;";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':idUser', $idUser);
        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }


    public function updateVisibilidadAPublica($idMonster)
    {
        $consulta = "UPDATE bichos SET Visibilidad ='1' WHERE id LIKE $idMonster";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':idMonster', $idMonster);
        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function updateVisibilidadAPrivada($idMonster)
    {
        $consulta = "UPDATE bichos SET Visibilidad ='0' WHERE id LIKE $idMonster";
        $result = $this->connection->prepare($consulta);
        $result->bindParam(':idMonster', $idMonster);
        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }


    // -------------- END FUNCTIONS ------------------------ //
}

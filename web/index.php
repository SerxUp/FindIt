<?php
require_once __DIR__ . '/../app/libs/Config.php';
require_once __DIR__ . '/../app/libs/General.php';
require_once __DIR__ . '/../app/libs/Security.php';
require_once __DIR__ . '/../app/libs/Mail.php';
require_once __DIR__ . '/../app/model/classModel.php';
require_once __DIR__ . '/../app/model/classFindIt.php';
require_once __DIR__ . '/../app/controller/Controller.php';
require_once __DIR__ . '/../app/controller/ControllerAjax.php';

// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);

session_start();
if (!isset($_SESSION['user_status'])) {
    $_SESSION['user_status'] = 0;
}

$map = array(
    // ============== USER LEVEL 0 (GUEST) ============== //
    'home' => array('controller' => 'Controller', 'action' => 'home', 'user_status' => 0),
    'error' => array('controller' => 'Controller', 'action' => 'error', 'user_status' => 0),
    #'contact' => array('controller' => 'Controller', 'action' => 'contact', 'user_status' => 0),
    'login' => array('controller' => 'Controller', 'action' => 'login', 'user_status' => 0),
    'signup' => array('controller' => 'Controller', 'action' => 'signup', 'user_status' => 0),
    #'forgot' => array('controller' => 'Controller', 'action' => 'forgot', 'user_status' => 0), // Verificacion por mail con token url index.php?ctl=forgot&token
    'verifyForgot' => array('controller' => 'Controller', 'action' => 'verifyForgot', 'user_status' => 0),
    'verifyAccount' => array('controller' => 'Controller', 'action' => 'verifyAccount', 'user_status' => 0), // Verificacion por mail con token url index.php?ctl=verify&token=your_unique_token
    'listarTemaForo' => array('controller' => 'Controller', 'action' => 'listarTemaForo', 'user_status' => 0), // Comprobar user_status para permitir responder

    'forumPublic' => array('controller' => 'Controller', 'action' => 'forumPublic', 'user_status' => 0),
    'publicMonsters' => array('controller' => 'Controller', 'action' => 'publicMonsters', 'user_status' => 0),
    // ============== USER LEVEL 1 ============== //
    'userpage' => array('controller' => 'Controller', 'action' => 'userpage', 'user_status' => 1),
    // Monsters
    'userMonsters' => array('controller' => 'Controller', 'action' => 'userMonsters', 'user_status' => 1),

    'createMonster' => array('controller' => 'Controller', 'action' => 'createMonster', 'user_status' => 1),
    'exportMonster' => array('controller' => 'Controller', 'action' => 'exportMonster', 'user_status' => 1),
    /* Action - User Monsters */ 'editMonster' => array('controller' => 'Controller', 'action' => 'editMonster', 'user_status' => 1),

    // Forums
    'forum' => array('controller' => 'Controller', 'action' => 'forum', 'user_status' => 1),
    'exit' => array('controller' => 'Controller', 'action' => 'exit', 'user_status' => 1),

    // ============== USER LEVEL 2 (ADMIN) ============== //
    //'eliminarTemaForo' => array('controller' => 'Controller', 'action' => 'eliminarTemaForo', 'user_status' => 2),
    'adminUsers' => array('controller' => 'Controller', 'action' => 'adminUsers', 'user_status' => 2),
    'adminMonsters' => array('controller' => 'Controller', 'action' => 'adminMonsters', 'user_status' => 2),

    //'habilitadaUser' => array('controller' => 'Controller', 'action' => 'habilitadaUser', 'user_status' => 2),
    //'hacerMasterUser' => array('controller' => 'Controller', 'action' => 'hacerMasterUser', 'user_status' => 2),

    // ================ AJAX CONTROLLER ================== //

    // ============== USER LEVEL 0 (GUEST) ============== //
    #'login' => array('controller' => 'ControllerAjax', 'action' => 'login', 'user_status' => 0),
    #'signup' => array('controller' => 'ControllerAjax', 'action' => 'signup', 'user_status' => 0),
    'contact' => array('controller' => 'ControllerAjax', 'action' => 'contact', 'user_status' => 0),
    'forgot' => array('controller' => 'ControllerAjax', 'action' => 'forgot', 'user_status' => 0), // email verification with token url index.php?ctl=forgot&token=...

    // ============== USER LEVEL 1 ============== //
    'userInfo' => array('controller' => 'ControllerAjax', 'action' => 'userInfo', 'user_status' => 1),
    'postVisibility' => array('controller' => 'ControllerAjax', 'action' => 'postVisibility', 'user_status' => 1),
    'changeUserInfo' => array('controller' => 'ControllerAjax', 'action' => 'changeUserInfo', 'user_status' => 1),
    //'editarTemaForo' => array('controller' => 'ControllerAjax', 'action' => 'editarTemaForo', 'user_status' => 1),
    //'likeTemaForo' => array('controller' => 'ControllerAjax', 'action' => 'likeTemaForo', 'user_status' => 1),
    'monsterInfoArmas' => array('controller' => 'ControllerAjax', 'action' => 'monsterInfoArmas', 'user_status' => 1),
    'monsterInfoAptitudes' => array('controller' => 'ControllerAjax', 'action' => 'monsterInfoAptitudes', 'user_status' => 1),
    'monsterInfoDotes' => array('controller' => 'ControllerAjax', 'action' => 'monsterInfoDotes', 'user_status' => 1),
    'selectTipos' => array('controller' => 'ControllerAjax', 'action' => 'selectTipos', 'user_status' => 1),
    'selectTamanyos' => array('controller' => 'ControllerAjax', 'action' => 'selectTamanyos', 'user_status' => 1),

    // ============== USER LEVEL 2 (ADMIN) ============== //
    'accion' => array('controller' => 'ControllerAjax', 'action' => 'accion', 'user_status' => 2),
    'listUsers' => array('controller' => 'ControllerAjax', 'action' => 'listUsers', 'user_status' => 2),
    'searchUser' => array('controller' => 'ControllerAjax', 'action' => 'searchUser', 'user_status' => 2),
    'createTags' => array('controller' => 'ControllerAjax', 'action' => 'createTags', 'user_status' => 2),

);

//comprobar politica de cookies aceptada
if (isset($_COOKIE['acceptCookies'])) {
    // Parseo de la ruta
    if (isset($_GET['ctl'])) {
        if (isset($map[$_GET['ctl']])) {
            $ruta = $_GET['ctl'];
        } else {
            error_log('Path ctl: "' . $_GET['ctl'] . '. Not found.' . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
            //Si el valor puesto en ctl en la URL no existe en el array de mapeo envía una cabecera de error
            header(Config::$location404);
        }
    } else {
        $ruta = 'home';
    }
} else {
    $ruta = 'home';
    $params["cookies"] = "You need to accept the cookie policy to be able to browse our site.";
}

$controlador = $map[$ruta];
/* 
Comprobamos si el metodo correspondiente a la acción relacionada con el valor de ctl existe, 
si es así ejecutamos el método correspondiente.
En caso de no existir cabecera de error.
En caso de estar utilizando sesiones y permisos en las diferentes acciones comprobariamos tambien 
si el usuario tiene permiso suficiente para ejecutar esa acción
*/

if (method_exists($controlador['controller'], $controlador['action'])) {
    if ($controlador['user_status'] <= $_SESSION['user_status']) {
        call_user_func(array(
            new $controlador['controller'],
            $controlador['action']
        ));
    }
} else {
    error_log('Not found. Method does not exist.' . date("Y-m-d H:i:s", horaActual()) . PHP_EOL, 3, "../app/log/logError.txt");
    header(Config::$location404);
}

<?php

// Función que encripta el password utilizando blowfish con salt fijo

use PHPMailer\PHPMailer\OAuth;

function encriptar($password, $cost = 10)
{
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost]);
}

function comprobarhash($pass, $passBD)
{
    // Primero comprobamos si se ha empleado una contraseña correcta:
    return password_verify($pass, $passBD);
}

function horaActual()
{
    return time();
}

function genToken($user)
{
    return md5(uniqid($user, true));
}

function getUserIp()
{
    return $_SERVER['REMOTE_ADDR'];
}

function getUserDevice()
{
    return $_SERVER['HTTP_USER_AGENT'];
}

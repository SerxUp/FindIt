<?php


class Config
{
    //=================// WEB CONFIG (vps server) //========================//
    /*
    public static $mvc_bd_hostname = "127.0.0.1";
    public static $mvc_bd_nombre = "roldb";
    public static $mvc_bd_usuario = "roldb";
    public static $mvc_bd_clave = "B00le";

    // absolute url for TOKEN VERIFICATION
    public static $urlVerify = "http://vps793825.ovh.net/roldb/MVC/web/index.php?ctl=verify&token=";
    // absolute url for user LOGIN
    public static $urlLogin = "http://vps793825.ovh.net/roldb/MVC/web/index.php?ctl=home&login=true";
    // absolute url for TOKEN VERIFICATION
    public static $urlVerifyForgot = "http://vps793825.ovh.net/roldb/MVC/web/index.php?ctl=verifyForgot&token=";
*/
    //==================// LOCALHOST CONFIG //==============================//

    public static $mvc_bd_hostname = "localhost";
    public static $mvc_bd_nombre = "find_it";
    public static $mvc_bd_usuario = "root";
    public static $mvc_bd_clave = "";

    // absolute url for user LOGIN
    public static $urlLogin = "http://localhost/TFG/MVC/web/index.php?ctl=home&showModal=login";
    // absolute url for TOKEN VERIFICATION
    public static $urlVerify = "http://localhost/TFG/MVC/web/index.php?ctl=verifyAccount&token=";
    // absolute url for TOKEN VERIFICATION
    public static $urlVerifyForgot = "http://localhost/TFG/MVC/web/index.php?ctl=verifyForgot&token=";



    // ====================// GENERAL USE VARIABLES //========================== //

    public static $mvc_vis_css = "estilo.css";
    public static $vista = __DIR__ . '/../templates/home/index.php';
    public static $menu = __DIR__ . '/../templates/header.php';
    public static $max_file_size = 2097152;
    public static $allowed_extensions = [
        "jpg" => "jpg",
        "jpeg" => "jpeg",
        "png" => "png",
        "gif" => "gif"
    ];

    // Images directory
    public static $imgDir = "templates/imgs";
    // Profile pictures dir
    public static $profilesDir = "templates/imgs/profiles";

    //Mail Logo
    public static $mailLogo = 'http://vps793825.ovh.net/~sadam/TFG/MVC/web/templates/home/assets/img/findit-logo-mail.png';

    // header location for TOKEN VERIFICATION
    public static $locationVerify = "location:index.php?ctl=verifyAccount&token=";
    public static $locationVerifyForgot = "location:index.php?ctl=verifyForgot&token=";
    // header location for user LOGIN
    public static $locationLogin = "location:index.php?ctl=home&showModal=login";
    // header location for user LOGIN
    public static $locationSignup = "location:index.php?ctl=home&showModal=signup";
    // header location for HOME
    public static $locationHome = "location:index.php?ctl=home";
    // header location for USER PAGE
    public static $locationUserPage = "location:index.php?ctl=userpage";

    // header location for user error404 (not found)
    public static $location404 = "location:index.php?ctl=error";
}

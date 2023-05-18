<?php 

$dbhostname="localhost";
$dbusuario="root";
$dbpassword="";
$dbnombre="find_it";

$pdo = new PDO('mysql:host=' . $dbhostname . ';dbname=' . $dbnombre . '', $dbusuario, $dbpassword);

$pdo->exec("set names utf8");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

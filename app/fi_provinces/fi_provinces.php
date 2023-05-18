<?php
require("connection.php");
include("config.php");

$table = "fi_countries_provinces";
$row = "name";

//for ($i = 0; $i < count($vProvincia); $i++) {
foreach ($provincesArray as $province) {
    $query = $pdo->prepare("INSERT INTO $table ($row )VALUES (:rowValue)");
    $query->bindParam(':rowValue', $province);
    $query->execute();
}
//}
$pdo = NULL;

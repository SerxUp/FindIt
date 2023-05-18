<?php
require("connection.php");
include("config.php");

$table = "fi_countries";
$row = "name";

//for ($i = 0; $i < count($vProvincia); $i++) {
foreach ($countriesArray as $country) {
	$query = $pdo->prepare("INSERT INTO $table ($row )VALUES (:rowValue)");
	$query->bindParam(':rowValue', $country);
	$query->execute();
}
//}
$pdo = NULL;

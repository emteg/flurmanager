<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../libs/smarty/Smarty.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";

if (isset($_POST["id"]) && is_numeric($_POST["id"]) && $_POST["id"] > 0 && isset($_POST["auszugsdatum"]) && strlen($_POST["auszugsdatum"]) == 10) {
	$id = $_POST["id"];
	$auszugsDatum = $_POST["auszugsdatum"];
} else {
	die("Nicht alle oder ungültige Daten übermittelt.");
}

$datenbank = new Datenbank();

$sql = Belegung::SQL_UPDATE_AUSZUG;
$datenbank->queryDirekt($sql, Array("id" => $id, "ende" => $auszugsDatum));

header('Location: /'.$config["rootDir"]);
?>
<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";
require_once "../klassen/geld.class.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
	$id = $_GET["id"];
} else {
	die("Keine oder ungültige Id übergeben.");
}

$datenbank = new Datenbank();

$sql = Bewohner::SQL_DELETE;
$datenbank->queryDirekt($sql, Array("id" => $id));

$sql = Belegung::SQL_DELETE_BY_BEWOHNER_ID;
$datenbank->queryDirekt($sql, Array("id" => $id));

$sql = Geld::SQL_DELETE_BY_BEWOHNER_ID;
$datenbank->queryDirekt($sql, Array("id" => $id));

header("Location: /".$config["rootDir"]."index.php");
?>
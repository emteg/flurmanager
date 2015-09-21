<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";

if (isset($_POST["bewohnerName"]) && strlen($_POST["bewohnerName"]) > 2 &&
    isset($_POST["zimmer"]) && strlen($_POST["zimmer"]) >= 3 &&
		isset($_POST["einzugsdatum"]) && strlen($_POST["einzugsdatum"]) == 10 &&
		isset($_POST["bewohnerId"]) && is_numeric($_POST["bewohnerId"]) &&
		$_POST["bewohnerId"] > 0) {
	$bewohnerName = $_POST["bewohnerName"];
	$zimmer = explode(";", $_POST["zimmer"]);
	$einzugsDatum = $_POST["einzugsdatum"];
	if (count($zimmer) == 2) {
		$zimmerNummer = $zimmer[0];
		$aktuelleBelegungId = $zimmer[1];
	} else {
		die("Keine oder ungültige Zimmernummer übermittelt.");
	}
	$bewohnerId = $_POST["bewohnerId"];
} else {
	die("Nicht alle oder ungültige Daten übermittelt.");
}

$datenbank = new Datenbank();

$sql = Bewohner::SQL_SELECT_BY_ID;
$bewohner = $datenbank->querySingle($sql, Array("id" => $bewohnerId), new BewohnerFactory());

$sql = Belegung::SQL_SELECT_BY_ID;
$aktuelleBelegung = $datenbank->querySingle($sql, Array("id" => $aktuelleBelegungId), new BelegungFactory());

if ($aktuelleBelegung && $aktuelleBelegung->zimmer != $zimmerNummer) {
	die("Die Zimmernummer der aktuellen Belegung (" . $aktuelleBelegung->zimmer . 
		") stimmt nicht mit der übergebenen Zimmernummer (" . $zimmerNummer . ") überein.");
}

$auszugsDatum = date("Y-m-d", strtotime($einzugsDatum." -1 day"));

// Auszugsdatum in aktuelle Belegung eintragen, falls noch keins angegeben oder
// Auszugsdatum NACH Einzugsdatum.
if (!$aktuelleBelegung->ende || 
    ($aktuelleBelegung->ende && $aktuelleBelegung->ende > strtotime($auszugsDatum))) {
	$sql = Belegung::SQL_UPDATE_AUSZUG;
	$datenbank->queryDirekt($sql, Array("id" => $aktuelleBelegung->id, "ende" => $auszugsDatum));
}

$sql = Belegung::SQL_INSERT_INTO;
$datenbank->queryDirekt($sql, Array("bewohnerId" => $bewohner->id, "zimmer" => $zimmerNummer, "start" => $einzugsDatum));

header("Location: /".$config["rootDir"]."bewohner/index.php?id=" . $bewohner->id);
?>
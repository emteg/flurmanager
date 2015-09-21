<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../libs/smarty/Smarty.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";

if (isset($_POST["zimmer"]) && 
	  isset($_POST["vorname"]) && isset($_POST["nachname"]) && 
		isset($_POST["einzug"])) {
	$zimmer = $_POST["zimmer"];
	$vorname = $_POST["vorname"];
	$nachname = $_POST["nachname"];
	$einzug = $_POST["einzug"];
} else {
	die("Nicht alle notwendigen Formulardaten übertragen und/oder gültig.");
}

if (isset($_POST["auszug"])) {
	$auszug = $_POST["auszug"];
} else {
	$auszug = false;
}

$datenbank = new Datenbank();

// Altbelegung ausziehenlassen, falls vorhanden

$sql = Belegung::SQL_SELECT_LATEST_BY_ZIMMER;
$altBelegung = $datenbank->querySingle($sql, Array("zimmer" => $zimmer), 
	new BelegungFactory());

if ($altBelegung && $altBelegung->ende == "") {
	if ($auszug) {
		$sql = Belegung::SQL_UPDATE_AUSZUG;
		$datenbank->queryDirekt($sql, Array("ende" => $auszug, 
			"id" => $altBelegung->id));
	} else {
		die("Kein Auszugsdatum übergeben.");
	}
}

// Neuen Bewohner anlegen

$sql = Bewohner::SQL_INSERT_INTO;
$datenbank->queryDirekt($sql, Array("vorname" => $vorname, "nachname" => $nachname));

$sql = "SELECT id, vorname, nachname FROM bewohner WHERE vorname = :vorname AND nachname = :nachname ORDER BY Id DESC LIMIT 1";
$bewohner = $datenbank->querySingle($sql, Array("vorname" => $vorname, "nachname" => $nachname), new BewohnerFactory());

// Neue Belegung anlegen

$sql = Belegung::SQL_INSERT_INTO;
$datenbank->queryDirekt($sql, Array("bewohnerId" => $bewohner->id, "zimmer" => $zimmer, "start" => $einzug));

header('Location: /'.$config["rootDir"]);
?>
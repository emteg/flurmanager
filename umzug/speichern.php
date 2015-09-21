<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../libs/smarty/Smarty.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";

var_dump($_POST);

if (isset($_POST["belegung"]) && is_numeric($_POST["belegung"]) && 
    $_POST["belegung"] > 0 && isset($_POST["auszugsdatum"]) &&
		strlen($_POST["auszugsdatum"]) == 10 && isset($_POST["zimmer"]) &&
		strlen($_POST["zimmer"]) >= 3 && strpos($_POST["zimmer"], ";") !== false) {
		
	$startBelegungId = $_POST["belegung"];
	$auszugsDatum = $_POST["auszugsdatum"];
	$einzugsDatum = date("Y-m-d", strtotime($auszugsDatum." +1 day"));
	$zielZimmerNummer = substr($_POST["zimmer"], 0, strpos($_POST["zimmer"], ";"));
	$zielBelegungId = substr($_POST["zimmer"], strpos($_POST["zimmer"], ";") + 1);
	
} else {
	die("Nicht alle oder ungültige Daten übermittelt.");
}

$datenbank = new Datenbank();

// alte belegung holen
$sql = Belegung::SQL_SELECT_BY_ID_JOIN_BEWOHNER;
$startBelegung = $datenbank->querySingle($sql, Array("id" => $startBelegungId), 
	new BewohnerBelegungFactory());
$bewohner = $startBelegung->bewohner;

// auszugsdatum in alte belegung eintragen
$sql = Belegung::SQL_UPDATE_AUSZUG;
$datenbank->queryDirekt($sql, Array("id" => $startBelegung->id, "ende" => $auszugsDatum));

// auszugsdatum in zielbelegung (falls vorhanden) eintragen
if ($zielBelegungId > 0) {
	$sql = Belegung::SQL_UPDATE_AUSZUG;
	$datenbank->queryDirekt($sql, Array("id" => $zielBelegungId, "ende" => $auszugsDatum));
}

// neue belegung mit altem bewohner erstellen
$sql = Belegung::SQL_INSERT_INTO;
$datenbank->queryDirekt($sql, Array("bewohnerId" => $bewohner->id, "zimmer" => $zielZimmerNummer, "start" => $einzugsDatum));

header('Location: /'.$config["rootDir"].'bewohner/index.php?id='.$bewohner->id);
?>
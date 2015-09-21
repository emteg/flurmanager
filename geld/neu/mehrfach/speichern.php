<?php
require_once "../../../klassen/authentication.class.php";
require_once "../../../config.php";
require_once "../../../klassen/datenbank.class.php";
require_once "../../../libs/smarty/Smarty.class.php";
require_once "../../../klassen/geld.class.php";

$datenbank = new Datenbank();

$datum = null;
$betreff = "";
$betrag = 0;
$bewohner = Array();

if (postIstGueltig()) {
	variablenZuweisen();
	belegungenSpeichern($datum, $betreff, $betrag, $bewohner);
	header("Location: /".$config["rootDir"]."geld/");
} else {
	die("Input ist ungültig");
}

function postIstGueltig() {

	return isset($_POST["datum"]) && isset($_POST["betrag"]) && 
		isset($_POST["betreff"])  && isset($_POST["methode"])  && 
		is_numeric($_POST["methode"]) && is_numeric($_POST["betrag"]) &&
		($_POST["methode"] == 0 || $_POST["methode"] == 1 ) &&
		isset($_POST["bewohner"])  && is_array($_POST["bewohner"]) &&
		checkdate(substr($_POST["datum"], 5, 2), substr($_POST["datum"], 8, 2), 
			substr($_POST["datum"], 0, 4));
			
}

function variablenZuweisen() {

	global $datum;
	global $betreff;
	global $betrag;
	global $bewohner;
	
	$datum = $_POST["datum"];
	$betreff = $_POST["betreff"];
	$bewohner = $_POST["bewohner"];
	
	$methode = $_POST["methode"];
	
	if ($methode == 0) {
		$betrag = $_POST["betrag"];
	} else {
		$betrag = $_POST["betrag"] / count($_POST["bewohner"]);
	}
	
}

function belegungenSpeichern($datum, $betreff, $betrag, $bewohner) {

	foreach ($bewohner as $bewohnerId) {
		$params = Array("betreff" => $betreff, "datum" => $datum, 
			"bewohnerId" => $bewohnerId, "betrag" => $betrag);
		belegungSpeichern($params);
	}
		
}

function belegungSpeichern($params) {
	global $datenbank;

	$sql = Geld::SQL_INSERT_GUTHABEN;
	$datenbank->queryDirekt($sql, $params);
	
}
?>
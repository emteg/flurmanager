<?php
require_once "../../klassen/authentication.class.php";
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../libs/smarty/Smarty.class.php";
require_once "../../klassen/geld.class.php";

var_dump($_POST);

if (isset($_POST["grundbetrag"]) && isset($_POST["zusatzbetrag"]) &&
    isset($_POST["id"]) && is_array($_POST["id"]) && isset($_POST["monate"]) &&
		is_array($_POST["monate"]) && isset($_POST["zusatz"]) && 
		is_array($_POST["zusatz"]) && isset($_POST["semester"])) {
	
	$grundbetrag = str_replace(",", ".", $_POST["grundbetrag"]);
	$zusatzbetrag = str_replace(",", ".", $_POST["zusatzbetrag"]);
	
	if (!is_numeric($grundbetrag) || $grundbetrag <= 0 || !is_numeric($zusatzbetrag) ||
	    $zusatzbetrag <= 0) {
		die("Ungültige Werte für Grund- oder Zustatzbetrag übermittelt.");
	}
	
	$ids = $_POST["id"];
	foreach ($ids as $id) {
		if (!is_numeric($id) || $id < 0) {
			die("Ungültigen Wert für IDs übermittelt.");
		}
	}
	
	$monate = $_POST["monate"];
	foreach ($monate as $monat) {
		if (!is_numeric($monat) || $monat < 0 || $monat > 6) {
			die("Ungültigen Wert für Monate übermittelt.");
		}
	}
	
	$zusaetze = $_POST["zusatz"];
	$semester = $_POST["semester"];
	
} else {
	die("Nicht alle oder ungültige Daten übermittelt.");
}

$datenbank = new Datenbank();
$sql = Geld::SQL_INSERT_GUTHABEN;
$params = Array();
$params["betreff"] = "Abzug Flurbeitrag " . $semester;
$params["datum"] = date("Y-m-d");

foreach ($ids as $id) {
	if (isset($monate[$id])) {
	
		$betrag = -$grundbetrag;
		
		if (isset($zusaetze[$id])) {
			$betrag -= $zusatzbetrag;
		}
		
		$betrag *= $monate[$id];
		
		$params["bewohnerId"] = $id;
		$params["betrag"] = $betrag;
		
		var_dump($sql);
		var_dump($params);
		
		$datenbank->queryDirekt($sql, $params);
		
	}
}

header("Location: /".$config["rootDir"]."geld/");
?>
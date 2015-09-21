<?php
require_once "../../klassen/authentication.class.php";
$loginErforderlich = false;
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../klassen/bewohner.class.php";

if (isset($_GET["values"]) && is_array($_GET["values"]) && count($_GET["values"]) >= 1) {
	$values = $_GET["values"];
}

$datenbank = new Datenbank();
$sql = "SELECT * FROM `bewohner` WHERE ";

foreach ($values as $key => $value) {
	$sql .= "`vorname` LIKE '%".$value."%' OR `nachname` LIKE '%".$value."%'";
	if ($key < count($values) -1) {
		$sql .= " OR ";
	}
}

$res = $datenbank->queryDirektArray($sql);

$answer = "";
$ids = "";

foreach ($res as $aktuell) {
	if (is_array($aktuell)) {
		$answer .= "<option>" . $aktuell["Vorname"] . " " . $aktuell["Nachname"] . "</option>";
		$ids .= $aktuell["Id"] . ";";
	}
}

echo $ids . " " . $answer;
?>
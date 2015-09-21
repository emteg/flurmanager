<?php
require_once "../../klassen/authentication.class.php";
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../libs/smarty/Smarty.class.php";
require_once "../../klassen/geld.class.php";

var_dump($_POST);

if (isset($_POST["datum"]) && strlen($_POST["datum"]) == 10 && isset($_POST["betreff"]) && 
	  isset($_POST["betrag"]) && isset($_POST["typ"]) && is_numeric($_POST["typ"]) && 
		$_POST["typ"] >= 0 && $_POST["typ"] <= 2 && isset($_POST["bewohnerId"]) && 
		isset($_POST["id"]) && is_numeric($_POST["id"]) && $_POST["id"] > 0) {
	$datum = $_POST["datum"];
	$betreff = $_POST["betreff"];
	$typ = $_POST["typ"];
	$betrag = str_replace(",", ".", $_POST["betrag"]);
	
	if ($typ == 0) {
		$istGeld = true;
		$istGuthaben = false;
	} else if ($typ == 1) {
		$istGeld = false;
		$istGuthaben = true;
	} else {
		$istGeld = true;
		$istGuthaben = true;
	}
	
	$id = $_POST["id"];
} else {
	die("Nicht alle oder ungültige Daten übergeben.");
}

$datenbank = new Datenbank();
$sql = Geld::SQL_UPDATE;

$datenbank->queryDirekt($sql, Array("betreff" => $betreff, "betrag" => $betrag, 
	"datum" => $datum, "istGeld" => $istGeld, "istGuthaben" => $istGuthaben, "id" => $id));
	
header('Location: /'.$config["rootDir"].'geld/');
?>
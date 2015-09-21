<?php
require_once "../../klassen/authentication.class.php";
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../klassen/belegung.class.php";

var_dump($_POST);

if (isset($_POST["id"]) && is_numeric($_POST["id"]) && $_POST["id"] > 0 && 
    isset($_POST["zimmer"]) && is_numeric($_POST["zimmer"]) && $_POST["zimmer"] > 0 &&
		$_POST["zimmer"] <= $config["zimmerAnzahl"] && isset($_POST["start"]) &&
		strlen($_POST["start"]) == 10 && isset($_POST["ende"]) &&
		(strlen($_POST["ende"]) == 0 || strlen($_POST["ende"]) == 10)) {
	$id = $_POST["id"];
	$zimmer = $_POST["zimmer"];
	$start = $_POST["start"];
	$ende = $_POST["ende"];
	
	if (strlen($ende) < 10) {
		$ende = NULL;
	}
} else {
	die("Nicht alle oder ungültige Daten übergeben.");
}

$datenbank = new Datenbank();
$sql = Belegung::SQL_UPDATE;

$datenbank->queryDirekt($sql, Array("id" => $id, "zimmer" => $zimmer, 
	"start" => $start, "ende" => $ende));

header('Location: /' . $config["rootDir"] . 'belegung/index.php?id='.$id);
?>
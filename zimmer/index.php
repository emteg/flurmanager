<?php
require_once "../klassen/authentication.class.php";
$loginErforderlich = false;
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../libs/smarty/Smarty.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";

if (isset($_GET["nummer"]) && is_numeric($_GET["nummer"]) && $_GET["nummer"] <= $config["zimmerAnzahl"]) {
	$zimmer = $_GET["nummer"];
	
	if ($zimmer < 10) {
		$zimmerBezeichnung = $config["flurName"] . "0" . $zimmer;
	} else {
		$zimmerBezeichnung = $config["flurName"] . $zimmer;
	}
} else {
	die("Keine oder ungültige Zimmernummer übergeben.");
}

$datenbank = new Datenbank();

$sql = Belegung::SQL_SELECT_BY_ZIMMER_JOIN_BEWOHNER;
$belegungen = $datenbank->queryArray($sql, Array("zimmer" => $zimmer), new BewohnerBelegungFactory());

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->assign("belegungen", $belegungen);
$smarty->assign("zimmerBezeichnung", $zimmerBezeichnung);
$smarty->setTemplateDir("../seiten/templates/zimmer");
$smarty->display("index.tpl");
?>
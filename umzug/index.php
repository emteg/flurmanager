<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../libs/smarty/Smarty.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] > 0) {
	$id = $_GET["id"];
} else {
	die("Keine oder ungültige Bewohner-Id übergeben.");
}

$datenbank = new Datenbank();

$sql = Bewohner::SQL_SELECT_BY_ID;
$bewohner = $datenbank->querySingle($sql, Array("id" => $id), new BewohnerFactory());

$sql = Belegung::SQL_SELECT_BY_BEWOHNERID;
$bewohnerBelegungen = $datenbank->queryArray($sql, Array("bewohnerId" => $id), new BelegungFactory());
$zimmerNummer = $bewohnerBelegungen[0]->zimmer;

$sql = Belegung::SQL_SELECT_CURRENT_JOIN_BEWOHNER;
$daten = $datenbank->queryArray($sql, Array(), new BewohnerBelegungFactory());

$zimmer = Array();

for ($i = 1; $i <= $config["zimmerAnzahl"]; $i++) {
	$zimmer[$i]["nummer"] = $i;
	if ($i < 10) {
		$zimmer[$i]["bezeichnung"] = $config["flurName"] . "0" . $i;
	} else {
		$zimmer[$i]["bezeichnung"] = $config["flurName"] . $i;
	}
	$zimmer[$i]["istBelegt"] = false;
	$zimmer[$i]["belegung"] = null;
	$zimmer[$i]["freiAb"] = false;
	
	$zimmer[$i]["selected"] = ($i == $zimmerNummer);
	
	for ($j = 0; $j < count($daten); $j++) {
		if ($i == $daten[$j]->zimmer) {				
			$zimmer[$i]["istBelegt"] = true;
			$zimmer[$i]["belegung"] = $daten[$j];
			if ($daten[$j]->ende != "") {
				$zimmer[$i]["freiAb"] = $daten[$j]->ende; 
			}
			break;
		}
	}
}

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->assign("bewohner", $bewohner);
$smarty->assign("bewohnerBelegungen", $bewohnerBelegungen);
$smarty->assign("zimmer", $zimmer);
$smarty->setTemplateDir("../seiten/templates/umzug");
$smarty->display("index.tpl");
?>
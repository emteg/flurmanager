<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../libs/smarty/Smarty.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";

$datenbank = new Datenbank();

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

$einzugsDatum = date("Y-m-01", strtotime("next month"));

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->assign("zimmer", $zimmer);
$smarty->assign("einzugsDatum", $einzugsDatum);
$smarty->setTemplateDir("../seiten/templates/wiedereinzug");
$smarty->display("index.tpl");
?>
<?php
require_once "../../../klassen/authentication.class.php";
require_once "../../../config.php";
require_once "../../../libs/smarty/Smarty.class.php";
require_once "../../../klassen/datenbank.class.php";
require_once "../../../klassen/bewohner.class.php";
require_once "../../../klassen/belegung.class.php";

$datenbank = new Datenbank();

$belegungen = belegungenLaden();

seiteAnzeigen($belegungen);

function seiteAnzeigen($belegungen) {
	global $config;

	$smarty = new Smarty();
	$smarty->assign("flurName", $config["flurName"]);
	$smarty->assign("rootDir", $config["rootDir"]);

	$smarty->assign("today", date("Y-m-d"));
	$smarty->assign("belegungen", $belegungen);

	$smarty->setTemplateDir("../../../seiten/templates/geld/neu/mehrfach");
	$smarty->display("index.tpl");
}

function belegungenLaden() {
	global $datenbank;

	$sql = Belegung::SQL_SELECT_CURRENT_JOIN_BEWOHNER;
	$params = Array();
	return $datenbank->queryArray($sql, $params, new BewohnerBelegungFactory());
}
	
?>
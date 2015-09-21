<?php
require_once "../../klassen/authentication.class.php";
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../libs/smarty/Smarty.class.php";
require_once "../../klassen/bewohner.class.php";
require_once "../../klassen/belegung.class.php";

$datenbank = new Datenbank();

$jahr = date("Y");
$monat = date("n");

if ($monat <= 3) {
	$semester = "Wintersemester " . ($jahr - 1) . "/" . $jahr;
	$semesterStart = ($jahr - 1) . "-10-01";
} else if ($monat >= 10) {
	$semester = "Wintersemester " . $jahr . "/" . ($jahr + 1);
	$semesterStart = $jahr . "-10-01";
} else {
	$semester = "Sommersemester " . $jahr;
	$semesterStart = ($jahr) . "-04-01";
}

$sql = Belegung::SQL_SELECT_ALLE_AB_JOIN_BEWOHNER;
$belegungen = $datenbank->queryArray($sql, Array("startDatum" => $semesterStart), new BewohnerBelegungFactory());

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("../../seiten/templates/geld/beitrag");

$smarty->assign("zimmerAnzahl", $config["zimmerAnzahl"]);
$smarty->assign("belegungen", $belegungen);
$smarty->assign("semester", $semester);
$smarty->assign("semesterStart", $semesterStart);

$smarty->display("abbuchen.tpl");
?>
<?php
require_once "../../klassen/authentication.class.php";
$loginErforderlich = false;
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../libs/smarty/Smarty.class.php";
require_once "../../klassen/bewohner.class.php";
require_once "../../klassen/belegung.class.php";
require_once "../../klassen/geld.class.php";

$datenbank = new Datenbank();

require_once "../guthabenSemester.php";

$sql = Geld::SQL_SELECT_KASSENSTAND;
$res = $datenbank->queryDirektArray($sql, Array());
if ($res[0]["kassenstand"] != null) {
	$kassenstand = $res[0]["kassenstand"];
} else {
	$kassenstand = 0;
}

$sql = Geld::SQL_SELECT_SUMME_GUTHABEN;
$res = $datenbank->queryDirektArray($sql, Array());
if ($res[0]["summeGuthaben"] != null) {
	$summeGuthaben = $res[0]["summeGuthaben"];
} else {
	$summeGuthaben = 0;
}

$sql = Geld::SQL_SELECT_EINNAHMEN_ZWISCHEN;
$res = $datenbank->queryDirektSingle($sql, Array("start" => $semesterStart, "ende" => $semesterEnde));
if ($res["einnahmen"] != null) {
	$einnahmen = str_replace(".", ",", $res["einnahmen"]);
} else {
	$einnahmen = "0,00";
}

$sql = Geld::SQL_SELECT_AUSGABEN_ZWISCHEN;
$res = $datenbank->queryDirektSingle($sql, Array("start" => $semesterStart, "ende" => $semesterEnde));
if ($res["ausgaben"] != null) {
	$ausgaben = str_replace(".", ",", $res["ausgaben"]);
} else {
	$ausgaben = "0,00";
}

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("../../seiten/templates/geld/beitrag");

$smarty->assign("semester", $semester);
$smarty->assign("belegungen", $belegungen);
$smarty->assign("guthaben", $guthaben);
$smarty->assign("kassenstand", $kassenstand);
$smarty->assign("summeGuthaben", $summeGuthaben);
$smarty->assign("heute", date("Y-m-d"));
$smarty->assign("einnahmen", $einnahmen);
$smarty->assign("ausgaben", $ausgaben);
$smarty->assign("zimmerAnzahl", $config["zimmerAnzahl"]);

$smarty->display("drucken.tpl");
?>
<?php
require_once "../../klassen/authentication.class.php";
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../libs/smarty/Smarty.class.php";
require_once "../../klassen/bewohner.class.php";
require_once "../../klassen/geld.class.php";
require_once "../../klassen/pagination.class.php";

$datenbank = new Datenbank();

$sql = Geld::SQL_SELECT_COUNT;
$anzahl = $datenbank->queryDirektSingle($sql)["anzahl"];

$pagination = new Pagination($anzahl);

$sql = GELD::SQL_SELECT_ALL_JOIN_BEWOHNER . $pagination->getLimit(); 
$buchungen = $datenbank->queryArray($sql, Array(), new BewohnerGeldFactory());

if (count($buchungen) > 0) {
	$sql = Geld::SQL_SELECT_KASSENSTAND_BIS;
	$kassenstand = $datenbank->queryDirektSingle($sql, Array("datum" => $buchungen[0]->datum))["kassenstand"];
} else {
	$kassenstand = 0;
}

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);

$smarty->assign("pagination", $pagination);
$smarty->assign("buchungen", $buchungen);
$smarty->assign("filename", "/c4/geld/buchungen/index.php");
$smarty->assign("kassenstand", $kassenstand);
//$smarty->assign("", $);

$smarty->setTemplateDir("../../seiten/templates/geld/buchungen/");
$smarty->display("index.tpl");
?>
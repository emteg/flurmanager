<?php
require_once "../../klassen/authentication.class.php";
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../libs/smarty/Smarty.class.php";
require_once "../../klassen/bewohner.class.php";
require_once "../../klassen/geld.class.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
	$id = $_GET["id"];
} else {
	die("Keine oder ungültige Bewohner Id übergeben.");
}

$datenbank = new Datenbank();

$sql = Bewohner::SQL_SELECT_BY_ID;
$bewohner = $datenbank->querySingle($sql, Array("id" => $id), new BewohnerFactory());

$sql = Geld::SQL_SELECT_BY_BEWOHNERID;
$zahlungen = $datenbank->queryArray($sql, Array("bewohnerId" => $id), new GeldFactory());

$sql = GELD::SQL_SELECT_GUTHABEN;
$guthaben = $datenbank->queryDirektSingle($sql, Array("bewohnerId" => $id));

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);

$smarty->assign("bewohner", $bewohner);
$smarty->assign("zahlungen", $zahlungen);
$smarty->assign("guthaben", $guthaben["guthaben"]);

$smarty->setTemplateDir("../../seiten/templates/geld/guthaben");
$smarty->display("index.tpl");
?>
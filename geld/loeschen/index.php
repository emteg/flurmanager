<?php
require_once "../../klassen/authentication.class.php";
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../libs/smarty/Smarty.class.php";
require_once "../../klassen/bewohner.class.php";
require_once "../../klassen/belegung.class.php";
require_once "../../klassen/geld.class.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] > 0) {
	$id = $_GET["id"];
} else {
	die("Keine oder ungültige Id übergeben.");
}

$datenbank = new Datenbank();
$sql = Geld::SQL_SELECT_BY_ID_JOIN_BEWOHNER;

$buchung = $datenbank->querySingle($sql, Array("id" => $id), new BewohnerGeldFactory());

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("../../seiten/templates/geld/loeschen");

$smarty->assign("buchung", $buchung);

$smarty->display("index.tpl");
?>
<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";
require_once "../libs/smarty/Smarty.class.php";
require_once "../klassen/datenbank.class.php";
require_once "../klassen/bewohner.class.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
	$id = $_GET["id"];
} else {
	die("Keine oder ungültige Id übergeben.");
}

$datenbank = new Datenbank();
$sql = Bewohner::SQL_SELECT_BY_ID;

$bewohner = $datenbank->querySingle($sql, Array("id" => $id), new BewohnerFactory());

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);

$smarty->assign("bewohner", $bewohner);

$smarty->setTemplateDir("../seiten/templates/bewohner");
$smarty->display("loeschen.tpl");
?>
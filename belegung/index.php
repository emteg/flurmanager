<?php
require_once "../klassen/authentication.class.php";
$loginErforderlich = false;
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../libs/smarty/Smarty.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] > 0) {
	$id = $_GET["id"];
} else {
	die("Keine oder ung�ltige Belegungs-Id �bermittelt.");
}

$datenbank = new Datenbank();

$sql = Belegung::SQL_SELECT_BY_ID_JOIN_BEWOHNER;
$belegung = $datenbank->querySingle($sql, Array("id" => $id), new BewohnerBelegungFactory());

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("../seiten/templates/belegung");

$smarty->assign("belegung", $belegung);

$smarty->display("index.tpl");
?>
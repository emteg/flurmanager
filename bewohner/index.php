<?php
require_once "../klassen/authentication.class.php";
$loginErforderlich = false;
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../libs/smarty/Smarty.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";
require_once "../klassen/geld.class.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
	$id = $_GET["id"];
} else {
	die("Keine oder ungültige Bewohner Id übergeben.");
}

$datenbank = new Datenbank();

$sql = Bewohner::SQL_SELECT_BY_ID;
$bewohner = $datenbank->querySingle($sql, Array("id" => $id), new BewohnerFactory());

$sql = Belegung::SQL_SELECT_BY_BEWOHNERID;
$belegungen = $datenbank->queryArray($sql, Array("bewohnerId" => $bewohner->id), new BelegungFactory());

$sql = Geld::SQL_SELECT_GUTHABEN;
$res = $datenbank->queryDirektSingle($sql, Array("bewohnerId" => $bewohner->id));

$sql = "SELECT * FROM `hochschule` ORDER BY name ASC";
$hochschulen = $datenbank->queryDirektArray($sql);

$sql = "SELECT * FROM `studienfach` ORDER BY name ASC";
$studien = $datenbank->queryDirektArray($sql);

$sql = "SELECT * FROM `nationalitaet` ORDER BY name ASC";
$nationen = $datenbank->queryDirektArray($sql);

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("../seiten/templates/bewohner");

$smarty->assign("bewohner", $bewohner);
$smarty->assign("belegungen", $belegungen);
$smarty->assign("guthaben", $res["guthaben"]);
$smarty->assign("hochschulen", $hochschulen);
$smarty->assign("studien", $studien);
$smarty->assign("nationen", $nationen);

$smarty->display("index.tpl");
?>
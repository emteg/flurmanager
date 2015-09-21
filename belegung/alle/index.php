<?php
require_once "../../klassen/authentication.class.php";
$loginErforderlich = false;
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../libs/smarty/Smarty.class.php";
require_once "../../klassen/bewohner.class.php";
require_once "../../klassen/belegung.class.php";
require_once "../../klassen/pagination.class.php";

$datenbank = new Datenbank();

$sql = Belegung::SQL_SELECT_COUNT;
$res = $datenbank->queryDirektSingle($sql);

$anzahl = $res["COUNT(*)"];

$pagination = new Pagination($anzahl);

$sql = Belegung::SQL_SELECT_ALLE_JOIN_BEWOHNER_SORTIERT . $pagination->getLimit();
$belegungen = $datenbank->queryArray($sql, Array(), new BewohnerBelegungFactory());

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("../../seiten/templates/belegung/alle");

$smarty->assign("zimmerAnzahl", $config["zimmerAnzahl"]);
$smarty->assign("belegungen", $belegungen);
$smarty->assign("pagination", $pagination);
$smarty->assign("filename", "/flur/belegung/alle/index.php");

$smarty->display("index.tpl");
?>
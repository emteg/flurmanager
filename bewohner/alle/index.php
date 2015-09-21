<?php
require_once "../../klassen/authentication.class.php";
$loginErforderlich = false;
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../libs/smarty/Smarty.class.php";
require_once "../../klassen/bewohner.class.php";
require_once "../../klassen/pagination.class.php";

$datenbank = new Datenbank();

$sql = Bewohner::SQL_SELECT_COUNT;
$res = $datenbank->queryDirektSingle($sql);

$anzahl = $res["COUNT(*)"];

$pagination = new Pagination($anzahl);

$sql = Bewohner::SQL_SELECT_ALL_JOIN . $pagination->getLimit();
$bewohner = $datenbank->queryArray($sql, Array(), new BewohnerFactory());

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("../../seiten/templates/bewohner/alle");

$smarty->assign("zimmerAnzahl", $config["zimmerAnzahl"]);
$smarty->assign("bewohner", $bewohner);
$smarty->assign("pagination", $pagination);
$smarty->assign("filename", "/flur/bewohner/alle/index.php");

$smarty->display("index.tpl");
?>
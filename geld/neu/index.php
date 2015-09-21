<?php
require_once "../../klassen/authentication.class.php";
require_once "../../config.php";
require_once "../../libs/smarty/Smarty.class.php";

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);

$smarty->assign("today", date("Y-m-d"));

$smarty->setTemplateDir("../../seiten/templates/geld/neu");
$smarty->display("index.tpl");
?>
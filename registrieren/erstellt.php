<?php
require_once "../klassen/authentication.class.php";
$loginErforderlich = false;
require_once "../config.php";
require_once "../libs/smarty/Smarty.class.php";

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("../seiten/templates/registrieren");

$smarty->display("erstellt.tpl");
?>
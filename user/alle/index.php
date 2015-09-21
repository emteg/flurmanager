<?php
require_once "../../klassen/authentication.class.php";
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../klassen/user.class.php";
require_once "../../klassen/bewohner.class.php";
require_once "../../klassen/belegung.class.php";
require_once "../../libs/smarty/Smarty.class.php";

$datenbank = new Datenbank;

$sql = User::SQL_SELECT_ALLE;
$users = $datenbank->queryArray($sql, Array(), new UserFactory());

$belegungen = Array();
$sql = Belegung::SQL_SELECT_BY_BEWOHNER_ID_JOIN_BEWOHNER;
$factory = new BewohnerBelegungFactory();
foreach ($users as $user) {
	$parameters = Array("bewohnerId" => $user->bewohnerId);
	$belegungen[] = $datenbank->querySingle($sql, $parameters, $factory);
}

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("../../seiten/templates/user/alle");

$smarty->assign("users", $users);
$smarty->assign("belegungen", $belegungen);

$smarty->display("index.tpl");
?>
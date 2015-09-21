<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../klassen/user.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";
require_once "../libs/smarty/Smarty.class.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] > 0) {
	$id = $_GET["id"];
} else {
	die("Keine oder ungültige User-Id übergeben.");
}

$datenbank = new Datenbank();

$sql = User::SQL_SELECT_BY_ID;
$parameters = Array("id" => $id);
$user = $datenbank->querySingle($sql, $parameters, new UserFactory());

if (!$user) {
	die("Kein User mit der übergebenen Id gefunden.");
}

$sql = Belegung::SQL_SELECT_BY_BEWOHNER_ID_JOIN_BEWOHNER;
$parameters = Array("bewohnerId" => $user->bewohnerId);
$belegung = $datenbank->querySingle($sql, $parameters, new BewohnerBelegungFactory());

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("../seiten/templates/user");

$smarty->assign("user", $user);
$smarty->assign("belegung", $belegung);

$smarty->display("index.tpl");
?>
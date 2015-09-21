<?php
require_once "../klassen/authentication.class.php";
$loginErforderlich = false;
require_once "../config.php";
require_once "../libs/smarty/Smarty.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";
require_once "../klassen/datenbank.class.php";

if (isset($_GET["fehler"]) && is_numeric($_GET["fehler"])) {
	if ($_GET["fehler"] == "1") {
		$fehler = "Ungültiger Benutzername: der Benutzername muss aus mindestens 3 und maximal 50 Zeichen bestehen.";
	} else if ($_GET["fehler"] == "2") {
		$fehler = "Ungültiges Passwort: das Passwort muss aus mindestens 3 und maximal 50 Zeichen bestehen.";
	} else if ($_GET["fehler"] == "3") {
		$fehler = "Die beiden Passwörter waren nicht gleich.";
	} else if ($_GET["fehler"] == "4") {
		$fehler = "Es gibt schon einen Benutzer mit diesem Namen.";
	} else if ($_GET["fehler"] == "5") {
		$fehler = "Der ausgewählte Bewohner wohnt momentan nicht auf dem Flur.";
	} else if ($_GET["fehler"] == "6") {
		$fehler = "Für den ausgewählten Bewohner gibt es schon einen Benutzer.";
	} else {
		$fehler = "Falsche oder ungültige Daten übergeben.";
	}
}

$datenbank = new Datenbank();

$sql = '
	SELECT
		belegung.id AS id, 
		belegung.bewohnerId, 
		zimmer,
		start, 
		ende, 
		vorname, 
		nachname
	FROM 
		`belegung`
	JOIN 
		`bewohner`
	LEFT JOIN `user`
		ON belegung.bewohnerId = user.bewohnerId
	WHERE
		bewohner.id = belegung.bewohnerId AND
		start < NOW() AND
		(ende IS NULL OR ende > NOW()) AND
		user.bewohnerId IS NULL
	ORDER BY
		zimmer ASC';
		
$belegungen = $datenbank->queryArray($sql, Array(), new BewohnerBelegungFactory());

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("../seiten/templates/registrieren");

$smarty->assign("belegungen", $belegungen);
if (isset($fehler)) {
	$smarty->assign("fehler", $fehler);
}

$smarty->display("index.tpl");
?>
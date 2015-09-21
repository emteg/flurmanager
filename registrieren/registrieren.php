<?php
require_once "../klassen/authentication.class.php";
$loginErforderlich = false;
require_once "../config.php";
require_once "../klassen/user.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";
require_once "../klassen/datenbank.class.php";
require_once '../functions/passwordHash.function.php';

$datenbank = new Datenbank();

// Fehlercodes in /register/index.php
function fehler($code) {
	header("Location: ./index.php?fehler=" . $code);
	exit;
}

// Eingaben prüfen
try {
	User::validiereName($_POST["name"]);
	$name = $_POST["name"];
} catch (Exception $e) {
	fehler(1);
}

try {
	User::validierePasswort($_POST["passwort1"]);
	$passwort = create_hash($_POST["passwort1"]);
} catch (Exception $e) {
	fehler(2);
}

if ($_POST["passwort1"] != $_POST["passwort2"]) {
	fehler(3);
}

$sql = User::SQL_SELECT_BY_NAME;
$parameters = Array("name" => $name);
$user = $datenbank->querySingle($sql, $parameters, new UserFactory());

if ($user) {
	fehler(4);
}

try {
	User::validiereId($_POST["bewohnerId"]);
	$bewohnerId = $_POST["bewohnerId"];
	
	$sql = User::SQL_SELECT_BY_BEWOHNER_ID;
	$parameters = Array("bewohnerId" => $bewohnerId);
	$user = $datenbank->querySingle($sql, $parameters, new UserFactory());
	
	if ($user) {
		fehler(6);
	}
} catch (Exception $e) {
	fehler(0);
}

$sql = Belegung::SQL_SELECT_BY_BEWOHNERID;
$parameters = Array("bewohnerId" => $bewohnerId);
$belegung = $datenbank->querySingle($sql, $parameters, new BelegungFactory());

if (!$belegung || !$belegung->istAktuell()) {
	fehler(5);
}

// Ab hier keine Fehler mehr

$sql = User::SQL_INSERT_INTO;
$parameters = Array("bewohnerId" => $bewohnerId, "name" => $name, 
	"passwort" => $passwort, "istAktiviert" => false);
$datenbank->queryDirekt($sql, $parameters);

header("Location: ./erstellt.php");

?>
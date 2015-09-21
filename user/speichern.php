<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../klassen/user.class.php";
require_once '../functions/passwordHash.function.php';

$datenbank = new Datenbank();

if (User::validiereId($_POST["id"])) {
	$id = $_POST["id"];
} else {
	die("Keine oder ungültige User-Id übergeben.");
}

if (isset($_POST["istAktiviert"])) {
	$istAktiviert = true;
} else {
	$istAktiviert = false;
}

if (isset($_POST["passwort1"]) && isset($_POST["passwort2"]) &&
 	$_POST["passwort1"] == $_POST["passwort2"] && 
	User::validierePasswort($_POST["passwort1"])) {
	
	$passwort = create_hash($_POST["passwort1"]);
	
	$sql = User::SQL_UPDATE;
	$params = Array("id" => $id, "istAktiviert" => $istAktiviert, "passwort" => $passwort);
	$datenbank->queryDirekt($sql, $params);
	
	header("Location: ./index.php?id=" . $id);
	
} else {
	die("Ungütlige oder nicht identische Passwörter übermittelt.");
}
?>
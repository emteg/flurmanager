<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";

$username = $config["datenbankBenutzer"];
$password = $config["datenbankPasswort"];
$db = $config["datenbankName"];

$tables[] = "bewohner";
$tables[] = "belegung";
$tables[] = "geld";
$tables[] = "hochschule";
$tables[] = "studienfach";
$tables[] = "nationalitaet";

$mysqldumpbin = "D:\Programme\\xampp\mysql\bin\mysqldump.exe";

foreach ($tables as $table) {
	$outputpath = "D:\Programme\\xampp\htdocs\c4\\export\\" . $table . ".sql";
	$command = $mysqldumpbin . " -u" . $username . " -p" . $password . " " . $db . " " . $table . " > " . $outputpath;

	$result = system($command, $res);
	
	if ($result == 0) {
		echo $table . " erfolgreich exportiert.<br/>";
	} else {
		echo "Fehler beim Export von " . $table . "<br/>";
	}
}
?>
<?php
require_once "../klassen/authentication.class.php";
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../klassen/bewohner.class.php";

if (isset($_POST["id"]) && is_numeric($_POST["id"]) && $_POST["id"] > 0 && 
    isset($_POST["vorname"]) && strlen($_POST["vorname"]) > 0 && 
		isset($_POST["nachname"]) && isset($_POST["geburtstag"]) &&
	  isset($_POST["hochschule"]) && isset($_POST["studienfach"]) &&
		isset($_POST["geschlecht"]) && strlen($_POST["geschlecht"]) > 0 &&
		isset($_POST["nationalitaet"])) {
	$id = $_POST["id"];
	$vorname = $_POST["vorname"];
	$nachname = $_POST["nachname"];
	$geburtstag = $_POST["geburtstag"];
	$hochschule = $_POST["hochschule"];
	$studienfach = $_POST["studienfach"];
	$geschlecht = $_POST["geschlecht"];
	$nationalitaet = $_POST["nationalitaet"];
	
	if (isset($_POST["istBildungsInlaender"])) {
		$istBildungsInlaender = true;
	} else {
		$istBildungsInlaender = false;
	}
} else {
	die("Nicht alle oder ungültige Daten übergeben.");
}

$datenbank = new Datenbank();

if ($hochschule != "") {
	$sql = "SELECT * FROM `hochschule` WHERE `name` LIKE '%".$hochschule."%'";
	$result = $datenbank->queryDirektArray($sql);

	if (count($result) > 0) {
		$hochschuleId = $result[0]["Id"];
	} else {
		$sql = "INSERT INTO `hochschule` (`Name`) VALUES ('".$hochschule."')";
		$datenbank->queryDirekt($sql);
		
		$sql = "SELECT * FROM `hochschule` WHERE `name` LIKE '%".$hochschule."%'";
		$result = $datenbank->queryDirektArray($sql);
		
		$hochschuleId = $result[0]["Id"];
	}
} else {
	$hochschuleId = 0;
}

if ($studienfach != "") {
	$sql = "SELECT * FROM `studienfach` WHERE `name` LIKE '%".$studienfach."%'";
	$result = $datenbank->queryDirektArray($sql);

	if (count($result) > 0) {
		$studienfachId = $result[0]["Id"];
	} else {
		$sql = "INSERT INTO `studienfach` (`Name`) VALUES ('".$studienfach."')";
		$datenbank->queryDirekt($sql);
		
		$sql = "SELECT * FROM `studienfach` WHERE `name` LIKE '%".$studienfach."%'";
		$result = $datenbank->queryDirektArray($sql);
		
		$studienfachId = $result[0]["Id"];
	}
} else {
	$studienfachId = 0;
}

if ($nationalitaet != "") {
	$sql = "SELECT * FROM `nationalitaet` WHERE `name` LIKE '%".$nationalitaet."%'";
	$result = $datenbank->queryDirektArray($sql);

	if (count($result) > 0) {
		$nationalitaetId = $result[0]["Id"];
	} else {
		$sql = "INSERT INTO `nationalitaet` (`Name`) VALUES ('".$nationalitaet."')";
		$datenbank->queryDirekt($sql);
		
		$sql = "SELECT * FROM `nationalitaet` WHERE `name` LIKE '%".$nationalitaet."%'";
		$result = $datenbank->queryDirektArray($sql);
		
		$nationalitaetId = $result[0]["Id"];
	}
} else {
	$nationalitaetId = 0;
}

if ($geschlecht == "Unbekannt" || $geschlecht == "Maennlich" || $geschlecht == "Weiblich") {

} else {
	$geschlecht == "Unbekannt";
}

$sql = Bewohner::SQL_UPDATE;
$params = Array("id" => $id, "vorname" => $vorname, "nachname" => $nachname, 
                "geburtstag" => $geburtstag, "hochschuleId" => $hochschuleId,
								"studienfachId" => $studienfachId, "nationalitaetId" => $nationalitaetId,
								"istBildungsInlaender" => $istBildungsInlaender, "geschlecht" => $geschlecht);

$datenbank->queryDirekt($sql, $params);

header('Location: /'.$config["rootDir"].'bewohner/index.php?id='.$id);
?>
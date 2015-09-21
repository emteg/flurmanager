<?php
require_once "../../klassen/authentication.class.php";
require_once "../../config.php";
require_once "../../klassen/datenbank.class.php";
require_once "../../libs/smarty/Smarty.class.php";
require_once "../../klassen/bewohner.class.php";
require_once "../../klassen/geld.class.php";

$datenbank = new Datenbank();
$successCounter = 0;

if (isset($_POST["datum"]) && isset($_POST["betrag"]) && isset($_POST["betreff"])  && 
    isset($_POST["typ"])  && isset($_POST["bewohnerId"]) && 
		count($_POST["datum"]) == count($_POST["betrag"]) && 
		count($_POST["betrag"]) == count($_POST["betreff"]) && 
		count($_POST["betreff"]) == count($_POST["typ"]) && 
		count($_POST["typ"]) == count($_POST["bewohnerId"])) {

	foreach ($_POST["datum"] as $key => $datum) {
		$betreff = $_POST["betreff"][$key];
	
		if (!checkdate(substr($datum, 5, 2), substr($datum, 8, 2), substr($datum, 0, 4))) {
			echo "datum ungültig";
			continue;
		}
		
		$betrag = $_POST["betrag"][$key];
		if (strpos($betrag, ",") !== false) {
			$betrag = str_replace(",", ".", $betrag);
		}
		
		if (!is_numeric($betrag)) {
			echo "betrag ungültig";
			continue;
		}
		
		$typ = $_POST["typ"][$key];
		
		if (!is_numeric($typ) || $typ < 0 || $typ > 2) {
			echo "typ ungültig";
			continue;
		}
		
		$bewohnerId = $_POST["bewohnerId"][$key];
		
		if (!is_numeric($bewohnerId) || $bewohnerId < 0) {
			echo "bewohnerId ungültig";
			continue;
		}
		
		if ($typ > 0 && $bewohnerId == 0) {
			$bewohnerId = bewohnerIdSuchen($_POST["bewohnerName"][$key]);
			if ($bewohnerId == 0) {
				echo "Keine BewohnerId angegeben, Bewohner konnte nicht über Name gefunden werden";
				continue;
			}
		}
		
		switch ($typ) {
			case 0:
				$sql = Geld::SQL_INSERT_GELD;
				$params = Array("betreff" => $betreff, "datum" => $datum, 
					"betrag" => $betrag);
				break;
				
			case 1:
				$sql = Geld::SQL_INSERT_GUTHABEN;
				$params = Array("betreff" => $betreff, "datum" => $datum, 
					"betrag" => $betrag, "bewohnerId" => $bewohnerId);
				break;
				
			case 2:
				$sql = Geld::SQL_INSERT_GELDGUTHABEN;
				$params = Array("betreff" => $betreff, "datum" => $datum, 
					"betrag" => $betrag, "bewohnerId" => $bewohnerId);
				break;
		}

		$datenbank->queryDirekt($sql, $params);
		$successCounter++;
		
	}
		
} else {
	die("Es sind nicht alle Daten vorhanden.");
}

header("Location: /".$config["rootDir"]."geld/index.php?neueZahlungen=" . $successCounter);

function bewohnerIdSuchen($bewohnerName) {
	global $datenbank;
	
	$sql = "SELECT * FROM `bewohner` WHERE ";
	
	$namen = explode(" ", $bewohnerName);

	foreach ($namen as $key => $name) {
		$sql .= "`vorname` LIKE '%".$name."%' OR `nachname` LIKE '%".$name."%'";
		if ($key < count($namen) -1) {
			$sql .= " OR ";
		}
	}

	$res = $datenbank->queryDirektArray($sql);
	
	if (count($res) == 1) {
		return($res[0]["Id"]);
	} else {
		echo "Bewohnername nicht eindeutig";
		return 0;
	}
}
?>
<?php
require_once "../klassen/authentication.class.php";
$loginErforderlich = false;
require_once "../config.php";
require_once "../klassen/datenbank.class.php";
require_once "../libs/smarty/Smarty.class.php";
require_once "../klassen/bewohner.class.php";
require_once "../klassen/belegung.class.php";
require_once "../klassen/geld.class.php";

$datenbank = new Datenbank();

// Flurbeitrag
require_once "guthabenSemester.php";

$sql = Geld::SQL_SELECT_KASSENSTAND;
$res = $datenbank->queryDirektArray($sql, Array());
if ($res[0]["kassenstand"] != null) {
	$kassenstand = $res[0]["kassenstand"];
} else {
	$kassenstand = 0;
}

$sql = Geld::SQL_SELECT_EINNAHMEN_ZWISCHEN;
$res = $datenbank->queryDirektSingle($sql, Array("start" => $semesterStart, "ende" => $semesterEnde));
if ($res["einnahmen"] != null) {
	$einnahmen = str_replace(".", ",", $res["einnahmen"]);
} else {
	$einnahmen = "0,00";
}

$sql = Geld::SQL_SELECT_AUSGABEN_ZWISCHEN;
$res = $datenbank->queryDirektSingle($sql, Array("start" => $semesterStart, "ende" => $semesterEnde));
if ($res["ausgaben"] != null) {
	$ausgaben = str_replace(".", ",", $res["ausgaben"]);
} else {
	$ausgaben = "0,00";
}

$sql = Geld::SQL_SELECT_SUMME_GUTHABEN;
$res = $datenbank->queryDirektArray($sql, Array());
if ($res[0]["summeGuthaben"] != null) {
	$summeGuthaben = $res[0]["summeGuthaben"];
} else {
	$summeGuthaben = 0;
}

// Neuste Kassenbewegungen

$sql = Geld::SQL_SELECT_NEUSTE_GELD_JOIN_BEWOHNER;
$zahlungen = $datenbank->queryDirektArray($sql, Array());

$saldo = $kassenstand;

foreach ($zahlungen as $key => $zahlung) {
	if ($zahlung) {
		$zahlungen[$key]["saldo"] = number_format($saldo, 2, ',', '') . " €";
		if ($saldo < 0) {
			$zahlungen[$key]["saldo-negativ"] = true;
		} else {
			$zahlungen[$key]["saldo-negativ"] = false;
		}
		$saldo = $saldo - $zahlungen[$key]["betrag"];
		if ($zahlungen[$key]["betrag"] < 0) {
			$zahlungen[$key]["negativ"] = true;
		} else {
			$zahlungen[$key]["negativ"] = false;
		}
		$zahlungen[$key]["betrag"] = str_replace(".", ",", $zahlungen[$key]["betrag"]) . " €";
		if ($zahlung["zimmer"] != NULL) {
			$zahlungen[$key]["zimmer"] = Belegung::zimmerNummer($zahlung["zimmer"], $config["flurName"]);
		} else {
			$zahlungen[$key]["zimmer"] = "";
			$zahlungen[$key]["vorname"] = "";
			$zahlungen[$key]["nachname"] = "";
		}
	} else {
		unset($zahlungen[$key]);
	}
}

if (isset($_GET["neueZahlungen"]) && is_numeric($_GET["neueZahlungen"])) {
	$neueZahlungen = $_GET["neueZahlungen"];
} else {
	$neueZahlungen = -1;
}

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]); 
$smarty->setTemplateDir("../seiten/templates/geld");

$smarty->assign("zahlungen", $zahlungen);
$smarty->assign("semester", $semester);
$smarty->assign("belegungen", $belegungen);
$smarty->assign("guthaben", $guthaben);
$smarty->assign("summeGuthaben", $summeGuthaben);
$smarty->assign("kassenstand", $kassenstand);
$smarty->assign("einnahmen", $einnahmen);
$smarty->assign("ausgaben", $ausgaben);
$smarty->assign("neueZahlungen", $neueZahlungen);

$smarty->display("index.tpl");
?>
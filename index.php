<?php
require_once "klassen/authentication.class.php";
$loginErforderlich = false;
require_once "config.php";
require_once "klassen/datenbank.class.php";
require_once "libs/smarty/Smarty.class.php";
require_once "klassen/bewohner.class.php";
require_once "klassen/belegung.class.php";
require_once "klassen/geld.class.php";

// $bars[i]: ["wert"], ["beschriftung"]
function erzeugePlotBalkenHorizontalGestapelt($width, $height, $filename, $bars) {
	$image = imagecreatetruecolor($width, $height);
	$black = imagecolorallocate($image, 0, 0, 0);
	
	$x = 0;
	
	foreach ($bars as $bar) {
		$c1 = mt_rand(100, 220);
		$c2 = mt_rand(100, 220);
		$c3 = mt_rand(100, 220);
		$color = imagecolorallocate($image, $c1, $c2, $c3);
		
		$w = $bar["wert"] * $width;
		imagefilledrectangle($image, $x, 0, $w + $x, $height, $color);
		imagestring($image, 3, $x + 4, 3, $bar["beschriftung"], $black);
	
		$x += $w;
	}
	
	imagerectangle($image, 0, 0, $width - 1, $height - 1, $black);
	imagepng($image, $filename, 0);
}

function erzeugePlotBalkenHorizontal($width, $barHeight, $filename, $bars) {
	$height = $barHeight * count($bars);
	$image = imagecreatetruecolor($width, $height);
	$black = imagecolorallocate($image, 0, 0, 0);
	imagefilledrectangle($image, 0, 0, $width, $height, imagecolorallocate($image, 255, 255, 255));
	
	$y = 0;
	
	foreach ($bars as $bar) {
		$c1 = mt_rand(100, 220);
		$c2 = mt_rand(100, 220);
		$c3 = mt_rand(100, 220);
		$color = imagecolorallocate($image, $c1, $c2, $c3);
		
		$w = $bar["wert"] * $width;
		imagefilledrectangle($image, 0, $y, $w, $y + $barHeight, $color);
		imagerectangle($image, 0, $y, $w, $y + $barHeight, $black);
		if (imagefontwidth(3) * strlen($bar["beschriftung"]) > $w + 8) {
			imagestring($image, 3, $w + 4, $y + 3,  $bar["beschriftung"], $black);
		} else {
			imagestring($image, 3, 4, $y + 3,  $bar["beschriftung"], $black);
		}
	
		$y += $barHeight;
	}
	
	imagerectangle($image, 0, 0, $width - 1, $height - 1, $black);
	imagepng($image, $filename, 0);
}

$datenbank = new Datenbank();

// Aktuelle Belegung holen
$sql = Belegung::SQL_SELECT_CURRENT_JOIN_BEWOHNER_STUDIUM;
$daten = $datenbank->queryArray($sql, Array(), new BewohnerBelegungFactory());

// Guthaben jedes Bewohners holen, Durchschnittsalter berechnen, Frauen und
// Männer summieren
$guthaben = Array();
$sql = Geld::SQL_SELECT_GUTHABEN;
$summe = 0;
$anzahl = 0;
$maenner = 0;
$frauen = 0;
$unbekannt = 0;
$auslaender = 0;
foreach ($daten as $aktuell) {
	$res = $datenbank->queryDirektSingle($sql, Array("bewohnerId" => $aktuell->bewohnerId));
	if ($res["guthaben"] != null) {
		$guthaben[$aktuell->bewohnerId] = $res["guthaben"];
	} else {
		$guthaben[$aktuell->bewohnerId] = 0;
	}
	
	if ($aktuell->bewohner->alter()) {
		$anzahl++;
		$summe += $aktuell->bewohner->alter();
	}
	
	if ($aktuell->bewohner->geschlecht == "Maennlich") {
		$maenner++;
	} else if ($aktuell->bewohner->geschlecht == "Weiblich") {
		$frauen++;
	} else {
		$unbekannt++;
	}
	
	if (!$aktuell->bewohner->istBildungsInlaender) {
		$auslaender++;
	}
}

// Grafik Frauenanteil erzeugen
$bars = Array();
$wert = round($maenner / count($daten), 2);
$bar = Array("beschriftung" => "Maenner " . $wert * 100 . "%", "wert" => $wert);
$bars[] = $bar;
if ($unbekannt > 0) {
	$wert = round($unbekannt / count($daten), 2);
	$bar = Array("beschriftung" => "NA " . $wert * 100 . "%", "wert" => $wert);
	$bars[] = $bar;
}
$wert = round($frauen / count($daten), 2);
$bar = Array("beschriftung" => "Frauen " . $wert * 100 . "%", "wert" => $wert);
$bars[] = $bar;
erzeugePlotBalkenHorizontalGestapelt(500, 20, "./statistikFrauen.png", $bars);


// Grafik Auslänederanteil erzeugen
$bars = Array();
$wert = round((count($daten) - $auslaender) / count($daten), 2);
$bar = Array("beschriftung" => "Deutsche " . $wert * 100 . "%", "wert" => $wert);
$bars[] = $bar;
$wert = round($auslaender / count($daten), 2);
$bar = Array("beschriftung" => "Auslaender " . $wert * 100 . "%", "wert" => $wert);
$bars[] = $bar;
erzeugePlotBalkenHorizontalGestapelt(500, 20, "./statistikAuslaender.png", $bars);

if ($anzahl > 0) {
	$durchschnittsalter = round($summe / $anzahl, 1);
} else {
	$durchschnittsalter = 0;
}

// Kassenstand holen
$sql = Geld::SQL_SELECT_KASSENSTAND;
$res = $datenbank->queryDirektArray($sql, Array());
if ($res[0]["kassenstand"] != null) {
	$kassenstand = $res[0]["kassenstand"];
} else {
	$kassenstand = 0;
}

// Summe aller Guthaben aller Mitbewohner holen
$sql = Geld::SQL_SELECT_SUMME_GUTHABEN;
$res = $datenbank->queryDirektArray($sql, Array());
if ($res[0]["summeGuthaben"] != null) {
	$summeGuthaben = $res[0]["summeGuthaben"];
} else {
	$summeGuthaben = 0;
}

// Statistik über Schulen holen
$schulen = Array();
$summeSchulen = 0;
foreach ($daten as $belegung) {
	$schule = $belegung->bewohner->hochschule;
	$gefunden = false;
	
	foreach ($schulen as $schulName => $anzahl) {
		if ($schulName == $schule) {
			$schulen[$schule]++;
			$gefunden = true;
			break;
		}
	}
	
	if (!$gefunden) {
		$schulen[$schule] = 1;
	}
	
	$summeSchulen++;
}

// Statistik über Schulen sortieren, Anteile berechnen und Grafik erzeugen
array_multisort($schulen, SORT_DESC);
$bars = array();
foreach ($schulen as $key => $schule) {
	$bar["wert"] = round($schule / $summeSchulen, 2);
	
	if ($key == "") {
		$bar["beschriftung"] = "NA " . $bar["wert"] * 100 . "%";
	} else {
		$bar["beschriftung"] = $key . " " . $bar["wert"] * 100 . "%";
	}
	
	$bars[] = $bar;
}

if (count($schulen) > 0) {
	erzeugePlotBalkenHorizontalGestapelt(500, 20, "./statistikHochschulen.png", $bars);
}

// Statistik über Studiengänge holen
$studien = Array();
$summeStudien = 0;
foreach ($daten as $belegung) {
	$fach = $belegung->bewohner->studienfach;
	$gefunden = false;
	
	foreach ($studien as $studienfach => $anzahl) {
		if ($studienfach == $fach) {
			$studien[$fach]++;
			$gefunden = true;
			break;
		}
	}
	
	if (!$gefunden) {
		$studien[$fach] = 1;
	}
	
	$summeStudien++;
}

// Statistik über Studiengänge sortieren, Anteile berechnen und Grafik erzeugen
array_multisort($studien, SORT_DESC);
$bars = array();
foreach ($studien as $key => $fach) {
	$bar["wert"] = round($fach / $summeStudien, 2);

	if ($key == "") {
		$bar["beschriftung"] = "NA " . $bar["wert"] * 100 . "%";
	} else {
		$bar["beschriftung"] = $key . " " . $bar["wert"] * 100 . "%";
	}
	
	$bars[] = $bar;
}
if (count($studien) > 0) {
	erzeugePlotBalkenHorizontal(500, 20, "./statistikStudien.png", $bars);
}

$smarty = new Smarty();
$smarty->assign("flurName", $config["flurName"]);
$smarty->assign("rootDir", $config["rootDir"]);
$smarty->setTemplateDir("seiten/templates");

$smarty->assign("daten", $daten);
$smarty->assign("guthaben", $guthaben);
$smarty->assign("kassenstand", $kassenstand);
$smarty->assign("summeGuthaben", $summeGuthaben);
$smarty->assign("durchschnittsalter", $durchschnittsalter);

$smarty->display("index.tpl");
?>
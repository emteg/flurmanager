<?php
$jahr = date("Y");
$monat = date("n");

if ($monat <= 3) {
	$semester = "Wintersemester " . ($jahr - 1) . "/" . $jahr;
	$semesterStart = ($jahr - 1) . "-10-01";
	$semesterEnde = ($jahr) . "03-31";
} else if ($monat >= 10) {
	$semester = "Wintersemester " . $jahr . "/" . ($jahr + 1);
	$semesterStart = $jahr . "-10-01";
	$semesterEnde = ($jahr + 1) . "03-31";
} else {
	$semester = "Sommersemester " . $jahr;
	$semesterStart = ($jahr) . "-04-01";
	$semesterEnde = ($jahr) . "-09-30";
}

$sql = Belegung::SQL_SELECT_ALLE_AB_JOIN_BEWOHNER;
$belegungen = $datenbank->queryArray($sql, Array("startDatum" => $semesterStart), new BewohnerBelegungFactory());

for ($i = 0; $i < count($belegungen) - 2; $i++) {
	if (isset($belegungen[$i])) {
		$belegung = $belegungen[$i];
		
		for ($j = $i + 1; $j <= count($belegungen) - 1; $j++) {
			if (isset($belegungen[$j])) {
				$andereBelegung = $belegungen[$j];
				
				if ($belegung->bewohner->id == $andereBelegung->bewohner->id) {
					if ($belegung->ende != NULL) {
							array_splice($belegungen, $i, 1);
							break;
					} else if ($andereBelegung->ende != NULL) {
							array_splice($belegungen, $j, 1);
							break;
					}
				}
			}
		}
	}
}

$guthaben = Array();
$sql = Geld::SQL_SELECT_GUTHABEN;

foreach ($belegungen as $belegung) {
	$res = $datenbank->queryDirektSingle($sql, Array("bewohnerId" => $belegung->bewohnerId));
	if ($res["guthaben"] != null) {	
		$neu["guthaben"] = str_replace(".", ",", $res["guthaben"]) . " €";
		if ($res["guthaben"] < 0) {
			$neu["istNegativ"] = true;
		} else {
			$neu["istNegativ"] = false;
		}	
	} else {
		$neu["guthaben"] = "0,00 €";
		$neu["istNegativ"] = false;
	}
	
	$guthaben[] = $neu;
}
?>
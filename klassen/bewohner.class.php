<?php
class Bewohner {
	public $id = 0;
	public $vorname = "";
	public $nachname = "";
	public $geburtstag = "";
	public $hochschuleId = 0;
	public $studienfachId = 0;
	public $hochschule = "";
	public $studienfach = "";
	public $nationalitaetId = 0;
	public $nationalitaet = "";
	public $istBildungsInlaender = false;
	public $geschlecht = "";
	
	const SQL_SELECT_BY_ID = '
		SELECT
			bewohner.id as id,
			bewohner.vorname,
			bewohner.nachname,
			bewohner.geburtstag,
			bewohner.hochschuleId,
			bewohner.studienfachId,
			hochschule.name as hochschule,
			studienfach.name as studienfach,
			nationalitaetId,
			nationalitaet.name as nationalitaet,
			geschlecht,
			istBildungsInlaender
		FROM
			`bewohner`
		LEFT JOIN
			`hochschule`
			ON
				bewohner.hochschuleId = hochschule.id
		LEFT JOIN
			`studienfach`
			ON
				bewohner.studienfachId = studienfach.id
		LEFT JOIN
			`nationalitaet`
			ON
				bewohner.nationalitaetId = nationalitaet.id
		WHERE
			bewohner.id = :id';
	const SQL_SELECT_ALL = 'SELECT * FROM `bewohner`';
	const SQL_SELECT_ALL_JOIN = '
		SELECT
			bewohner.id as id,
			bewohner.vorname,
			bewohner.nachname,
			bewohner.geburtstag,
			bewohner.hochschuleId,
			bewohner.studienfachId,
			hochschule.name as hochschule,
			studienfach.name as studienfach,
			nationalitaetId,
			nationalitaet.name as nationalitaet,
			geschlecht,
			istBildungsInlaender
		FROM
			`bewohner`
		LEFT JOIN
			`hochschule`
			ON
				bewohner.hochschuleId = hochschule.id
		LEFT JOIN
			`studienfach`
			ON
				bewohner.studienfachId = studienfach.id
		LEFT JOIN
			`nationalitaet`
			ON
				bewohner.nationalitaetId = nationalitaet.id';
	const SQL_SELECT_COUNT = 'SELECT COUNT(*) FROM bewohner';
	const SQL_INSERT_INTO = '
		INSERT INTO 
			`bewohner` (`vorname`, `nachname`) 
		VALUES 
			(:vorname, :nachname)';
	const SQL_UPDATE = '
		UPDATE
			bewohner
		SET
			vorname = :vorname,
			nachname = :nachname,
			geburtstag = :geburtstag,
			hochschuleId = :hochschuleId,
			studienfachId = :studienfachId,
			nationalitaetId = :nationalitaetId,
			geschlecht = :geschlecht,
			istBildungsInlaender = :istBildungsInlaender
		WHERE
			id = :id';
	const SQL_DELETE = '
		DELETE FROM
			`bewohner`
		WHERE
			id = :id';
	
	function __construct($id, $vorname, $nachname) {
		$this->id = $id;
		$this->vorname = $vorname;
		$this->nachname = $nachname;
		$this->geburtstag = "";
		$this->studienfachId = 0;
		$this->hochschuleId = 0;
		$this->hochschule = "";
		$this->studienfach = "";
	}
	
	function alter() {
		if ($datum = strtotime($this->geburtstag)) {
			$diff = time() - $datum;
			$years = date("Y", $diff) - 1970;
			return $years;
		} else {
			return false;
		}
	}
	
	function getGeschlecht() {
		if ($this->geschlecht = "Maennlich") {
			return "Männlich";
		} else if ($this->geschlecht = "Weiblich") {
			return "Weiblich";
		} else {
			return "Unbekannt";
		}
	}
}

class BewohnerFactory {
	function create($record) {	
		$res = new Bewohner($record["id"], $record["vorname"], $record["nachname"]);	
		return $this->augment($res, $record);
	}
	
	function createJoined($record) {
		$res = new Bewohner($record["bewohnerId"], $record["vorname"], $record["nachname"]);
		return $this->augment($res, $record);
	}
	
	function augment($bewohner, $record) {
		if (isset($record["geburtstag"])) {
			$bewohner->geburtstag = $record["geburtstag"];
		}
		
		if (isset($record["hochschuleId"])) {
			$bewohner->hochschuleId = $record["hochschuleId"];
		}
		
		if (isset($record["studienfachId"])) {
			$bewohner->studienfachId = $record["studienfachId"];
		}
		
		if (isset($record["hochschule"])) {
			$bewohner->hochschule = $record["hochschule"]; 
		}
		
		if (isset($record["studienfach"])) {
			$bewohner->studienfach = $record["studienfach"]; 
		}
		
		if (isset($record["nationalitaetId"])) {
			$bewohner->nationalitaetId = $record["nationalitaetId"]; 
		}
		
		if (isset($record["nationalitaet"])) {
			$bewohner->nationalitaet = $record["nationalitaet"]; 
		}
		
		if (isset($record["geschlecht"])) {
			$bewohner->geschlecht = $record["geschlecht"]; 
		}
		
		if (isset($record["istBildungsInlaender"])) {
			$bewohner->istBildungsInlaender = $record["istBildungsInlaender"]; 
		}
		
		return $bewohner;
	}
}
?>
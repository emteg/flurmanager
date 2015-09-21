<?php
require_once dirname(__FILE__) . "/bewohner.class.php";

class Belegung {
	public $id = 0;
	public $bewohnerId = 0;
	public $bewohner = null;
	public $zimmer = 0;
	public $start = "";
	public $ende = "";
	
	const SQL_SELECT_BY_ID = '
		SELECT
			*
		FROM
			`belegung`
		WHERE
			id = :id';
	const SQL_SELECT_BY_BEWOHNERID = '
		SELECT
			*
		FROM
			`belegung`
		WHERE
			bewohnerId = :bewohnerId
		ORDER BY
			start DESC';
	const SQL_SELECT_LATEST_BY_BEWOHNERID = '
		SELECT
			*
		FROM
			`belegung`
		WHERE
			bewohnerId = :bewohnerId
		ORDER BY
			id DESC
		LIMIT 1';
	const SQL_SELECT_LATEST_BY_ZIMMER = 'SELECT * FROM belegung WHERE zimmer = :zimmer ORDER BY start DESC LIMIT 1';
	const SQL_SELECT_BY_ID_JOIN_BEWOHNER = '
		SELECT 
			belegung.id AS id, 
			bewohnerId, 
			zimmer, 
			start , 
			ende, 
			vorname, 
			nachname
		FROM 
			`bewohner`
		JOIN 
			`belegung`
		WHERE 
			bewohner.id = belegung.bewohnerId AND 
			belegung.id = :id';
	const SQL_SELECT_BY_BEWOHNER_ID_JOIN_BEWOHNER = '
		SELECT 
			belegung.id AS id, 
			bewohnerId, 
			zimmer,
			start, 
			ende, 
			vorname, 
			nachname
		FROM 
			`belegung`
		JOIN 
			`bewohner`
		WHERE
			bewohner.id = belegung.bewohnerId AND
			bewohner.id = :bewohnerId';
	const SQL_SELECT_BY_ZIMMER_JOIN_BEWOHNER = '
		SELECT 
			belegung.id AS id, 
			bewohnerId, 
			zimmer,
			start, 
			ende, 
			vorname, 
			nachname
		FROM 
			`belegung`
		JOIN 
			`bewohner`
		WHERE
			bewohner.id = belegung.bewohnerId AND
			zimmer = :zimmer
		ORDER BY
			belegung.id DESC';
	const SQL_SELECT_ALL_JOIN_BEWOHNER = '
		SELECT 
			belegung.id AS id, 
			bewohnerId, 
			zimmer,
			start, 
			ende, 
			vorname, 
			nachname
		FROM 
			`belegung`
		JOIN 
			`bewohner`
		WHERE
			bewohner.id = belegung.bewohnerId';
	const SQL_SELECT_ALLE_JOIN_BEWOHNER_SORTIERT = '
		SELECT 
			belegung.id AS id, 
			bewohnerId, 
			zimmer,
			start, 
			ende, 
			vorname, 
			nachname
		FROM 
			`belegung`
		JOIN 
			`bewohner`
		WHERE
			bewohner.id = belegung.bewohnerId
		ORDER BY
			zimmer ASC,
			start ASC';
	const SQL_SELECT_CURRENT_JOIN_BEWOHNER = '
		SELECT
			belegung.id AS id, 
			bewohnerId, 
			zimmer,
			start, 
			ende, 
			vorname, 
			nachname
		FROM 
			`belegung`
		JOIN 
			`bewohner`
		WHERE
			bewohner.id = belegung.bewohnerId AND
			start < NOW() AND
			(ende IS NULL OR ende > NOW())
		ORDER BY
			zimmer ASC';
	const SQL_SELECT_CURRENT_JOIN_BEWOHNER_STUDIUM = '
		SELECT
			belegung.id AS id, 
			bewohnerId, 
			zimmer,
			start, 
			ende, 
			vorname, 
			nachname,
			geburtstag,
			hochschuleId,
			studienfachId,
			hochschule.name as hochschule,
			studienfach.name as studienfach,
			nationalitaetId,
			nationalitaet.name as nationalitaet,
			geschlecht,
			istBildungsInlaender
		FROM 
			`belegung`
		JOIN 
			`bewohner`
		LEFT JOIN `hochschule` ON hochschuleId = hochschule.id
		LEFT JOIN `studienfach` ON studienfachId = studienfach.id
		LEFT JOIN `nationalitaet` ON nationalitaetId = nationalitaet.id
		WHERE
			bewohner.id = belegung.bewohnerId AND
			start < NOW() AND
			(ende IS NULL OR ende > NOW())
		ORDER BY
			zimmer ASC';
	const SQL_SELECT_ALLE_AB_JOIN_BEWOHNER = '
		SELECT
			belegung.id AS id, 
			bewohnerId, 
			zimmer,
			start, 
			ende, 
			vorname, 
			nachname
		FROM 
			`belegung`
		JOIN 
			`bewohner`
		WHERE
			bewohner.id = belegung.bewohnerId AND
			start < NOW() AND
			(ende IS NULL OR ende > :startDatum)
		ORDER BY
			zimmer ASC, start ASC';
	const SQL_SELECT_ALL = 'SELECT * FROM `belegung`';
	const SQL_SELECT_COUNT = 'SELECT COUNT(*) FROM belegung';
	const SQL_INSERT_INTO = '
		INSERT INTO 
			`belegung` (`bewohnerId`, `zimmer`, `start`) 
		VALUES 
			(:bewohnerId, :zimmer, :start)';
	const SQL_UPDATE = '
		UPDATE
			belegung
		SET
			zimmer = :zimmer,
			start = :start,
			ende = :ende
		WHERE
			id = :id';
	const SQL_UPDATE_AUSZUG = '
		UPDATE
			belegung
		SET
			ende = :ende
		WHERE
			id = :id';
	const SQL_DELETE = '
		DELETE FROM
			`belegung`
		WHERE
			id = :id';
	const SQL_DELETE_BY_BEWOHNER_ID = '
		DELETE FROM
			`belegung`
		WHERE
			bewohnerId = :id';
	
	function __construct($id, $bewohnerId, $zimmer, $start, $ende) {
		$this->id = $id;
		$this->bewohnerId = $bewohnerId;
		$this->zimmer = $zimmer;
		$this->start = $start;
		$this->ende = $ende;
	}
	
	function getZimmerNummer() {
		global $config;
		$res = $config["flurName"];
		if ($this->zimmer < 10) {
			$res .= "0" . $this->zimmer;
		} else {
			$res .= $this->zimmer;
		}
		return $res;
	}
	
	static function zimmerNummer($zimmer, $flurname) {
		if ($zimmer < 10) {
			return $flurname . "0" . $zimmer;
		} else {
			return $flurname . $zimmer;
		}
	}
	
	function istAktuell() {
		if (($this->ende == null || strtotime($this->ende) > time()) && strtotime($this->start) < time()) {
			return true;
		} else {
			return false;
		}
	}
}

class BelegungFactory {
	function create($record) {
		return new Belegung($record["Id"], $record["BewohnerId"], $record["Zimmer"], $record["Start"], $record["Ende"]);
	}
}

class BewohnerBelegungFactory {
	function create($record) {
		$result = new Belegung($record["id"], $record["bewohnerId"], $record["zimmer"], $record["start"], $record["ende"]);
		
		$factory = new BewohnerFactory();
		$result->bewohner = $factory->createJoined($record);
		
		return $result;
	}
}
?>
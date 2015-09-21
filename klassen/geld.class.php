<?php
require_once dirname(__FILE__) . "/bewohner.class.php";

class Geld {
	public $id = 0;
	public $betreff = "";
	public $datum = "";
	public $betrag = 0;
	public $istGeld = false;
	public $istGuthaben = false;
	public $bewohnerId = 0;
	public $bewohner = null;
	
	const SQL_SELECT_BY_ID = '
		SELECT
			*
		FROM
			`geld`
		WHERE
			id = :id';
	const SQL_SELECT_BY_ID_JOIN_BEWOHNER = '
		SELECT
			geld.id AS id,
			istGeld,
			istGuthaben,
			betrag,
			betreff,
			datum,
			bewohner.id AS bewohnerId,
			bewohner.vorname,
			bewohner.nachname,
			belegung.zimmer,
			belegung.id as belegungId
		FROM
			`geld`
		LEFT JOIN `bewohner` ON bewohner.id = geld.bewohnerId
		LEFT JOIN 
			`belegung` 
			ON 
				geld.bewohnerId = belegung.bewohnerId AND 
				geld.datum >= belegung.start AND 
				(geld.datum <= belegung.ende OR belegung.ende IS NULL)
		WHERE
			geld.id = :id';
	const SQL_SELECT_BY_BEWOHNERID = '
		SELECT
			*
		FROM
			`geld`
		WHERE
			bewohnerId = :bewohnerId
		ORDER BY
			datum DESC';
	const SQL_SELECT_ALL = '
		SELECT
			*
		FROM
			`geld`';
	const SQL_SELECT_ALL_JOIN_BEWOHNER = '
		SELECT
			geld.id AS id,
			istGeld,
			istGuthaben,
			betrag,
			betreff,
			datum,
			bewohner.id AS bewohnerId,
			bewohner.vorname,
			bewohner.nachname
		FROM
			`geld`
		LEFT JOIN 
			`bewohner` ON	bewohner.id = geld.bewohnerId
		ORDER BY
			datum DESC,
			id DESC';
	const SQL_SELECT_NEUSTE_GELD_JOIN_BEWOHNER = '
		SELECT
			DISTINCT (geld.bewohnerId), 
			geld.betrag,
			geld.betreff,
			geld.datum,
			bewohner.vorname, 
			bewohner.nachname,
			belegung.zimmer,
			belegung.id AS belegungId,
			geld.id
		FROM 
			`geld`
		LEFT JOIN `bewohner` ON bewohner.id = geld.bewohnerId
		LEFT JOIN `belegung` ON geld.bewohnerId = belegung.bewohnerId AND geld.datum >= belegung.start AND (geld.datum <= belegung.ende OR belegung.ende IS NULL)
		WHERE
			istGeld = true
		ORDER BY
			geld.datum DESC,
			geld.id DESC
		LIMIT 15';
	const SQL_SELECT_AUSGABEN_ZWISCHEN = '
		SELECT
			SUM(betrag) as ausgaben
		FROM
			`geld`
		WHERE
			istGeld = true AND
			betrag < 0 AND
			datum >= :start AND
			datum <= :ende';
	const SQL_SELECT_EINNAHMEN_ZWISCHEN = '
		SELECT
			SUM(betrag) as einnahmen
		FROM
			`geld`
		WHERE
			istGeld = true AND
			betrag > 0 AND
			datum >= :start AND
			datum <= :ende';
	const SQL_SELECT_KASSENSTAND = '
		SELECT
			SUM(betrag) AS kassenstand
		FROM
			`geld`
		WHERE
			istGeld = true';
	const SQL_SELECT_KASSENSTAND_BIS = '
		SELECT
			SUM(betrag) AS kassenstand
		FROM
			`geld`
		WHERE
			istGeld = true AND
			datum <= :datum
		ORDER BY 
			datum DESC , id DESC';
	const SQL_SELECT_SUMME_GUTHABEN = '
		SELECT
			SUM(betrag) AS summeGuthaben
		FROM
			`geld`
		WHERE
			istGuthaben = true';
	const SQL_SELECT_GUTHABEN = '
		SELECT
			SUM(betrag) AS guthaben
		FROM
			`geld`
		WHERE
			istGuthaben = true AND
			bewohnerId = :bewohnerId';
		const SQL_SELECT_GUTHABEN_BIS = '
		SELECT
			SUM(betrag) AS kassenstand
		FROM
			`geld`
		WHERE
			istGuthaben = true AND
			bewohnerId = :bewohnerId AND
			datum <= :datum';
	const SQL_SELECT_COUNT = 'SELECT COUNT(*) as anzahl FROM geld';
	const SQL_INSERT_GUTHABEN = '
		INSERT INTO
			`geld` (`betreff`, `datum`, `istGeld`, `istGuthaben`, `bewohnerId`, `betrag`)
		VALUES
			(:betreff, :datum, FALSE, TRUE, :bewohnerId, :betrag)';
	const SQL_INSERT_GELD = '
		INSERT INTO
			`geld` (`betreff`, `datum`, `istGeld`, `istGuthaben`, `betrag`)
		VALUES 
			(:betreff, :datum, TRUE, FALSE, :betrag)';
	const SQL_INSERT_GELDGUTHABEN = '
		INSERT INTO
			`geld` (`betreff`, `datum`, `istGeld`, `istGuthaben`, `bewohnerId`, `betrag`)
		VALUES
			(:betreff, :datum, TRUE, TRUE, :bewohnerId, :betrag)';
	const SQL_DELETE = '
		DELETE FROM 
			`geld`
		WHERE 
			id = :id';
	const SQL_DELETE_BY_BEWOHNER_ID = '
		DELETE FROM 
			`geld`
		WHERE 
			bewohnerId = :id';
	const SQL_UPDATE = '
		UPDATE
			geld
		SET
			betreff = :betreff,
			datum = :datum,
			betrag = :betrag,
			istGeld = :istGeld,
			istGuthaben = :istGuthaben
		WHERE
			id = :id';
	
			
	function __construct($id, $betreff, $datum, $betrag, $istGeld, $istGuthaben, $bewohnerId) {
		$this->id = $id;
		$this->betreff = $betreff;
		$this->datum = $datum;
		$this->betrag = $betrag;
		$this->istGeld = $istGeld;
		$this->istGuthaben = $istGuthaben;
		$this->bewohnerId = $bewohnerId;
		$this->bewohner = null;
	}
	
}

class GeldFactory {
	function create($record) {
		return new Geld($record["Id"], $record["Betreff"], $record["Datum"], 
			$record["Betrag"], $record["IstGeld"], $record["IstGuthaben"], $record["BewohnerId"]);
	}
}

class BewohnerGeldFactory {
	function create($record) {
		$result = new Geld($record["id"], $record["betreff"], $record["datum"], 
			$record["betrag"], $record["istGeld"], $record["istGuthaben"], $record["bewohnerId"]);
		
		$factory = new BewohnerFactory();
		$result->bewohner = $factory->createJoined($record);
		
		return $result;
	}
}
?>
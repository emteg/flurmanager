<?php
class Pagination {
	public $start = 0;
	public $anzahl = 25;
	private $seite = 1;
	private $seiten = 0;
	public $anzahlRecords;
	
	function __construct($anzahlRecords = 0) {
		if (isset($_GET['start']) && is_numeric($_GET['start'])) {
			$this->start = $_GET['start'];
		}
		if (isset($_GET['anzahl']) && is_numeric($_GET['anzahl'])) {
			$this->anzahl = $_GET['anzahl'];
		}
		$this->anzahlRecords = $anzahlRecords;
	}
	
	public function getLimit() {
		return " LIMIT " . $this->start . ", " . $this->anzahl;
	}
	
	public function getAktuelleSeite() {
		return $this->start / $this->anzahl;
	}
	
	public function getAnzahlSeiten() {
		return ceil($this->anzahlRecords / $this->anzahl);
	}
}
?>
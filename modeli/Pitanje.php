<?php

class Pitanje {

	protected $pitanje_id;
	protected $pitanje;
	protected $ispit_id;

	public function insertuj() {
		$podaci = array();
		$podaci['pitanje'] = DBConnection::prepareString($this->vratiPitanje());
		$podaci['ispit_id'] = $this->vratiIspitId();

		$imena_kolone = array();
		$vrednosti_kolone = array();
		foreach ($podaci as $kolona => $vrednost) {
			array_push($imena_kolone, "`$kolona`");
			array_push($vrednosti_kolone, "'$vrednost'");
		}
		$sql = "INSERT INTO pitanja (" .  implode(',', $imena_kolone).") "
			. "VALUES (" . implode(',', $vrednosti_kolone). ")";
		$res = DBConnection::exec($sql);

		if ($res) {
			$res = DBConnection::fetch("SELECT LAST_INSERT_ID() AS pitanje_id");
			if ( !empty($res) ) {
				$this->postaviPitanjeId($res['pitanje_id']);
				return TRUE;
			}
		}
		return FALSE;
	}

	public function snimi() {
		$pitanje_id = $this->vratiPitanjeId();
		if (!empty($pitanje_id)) {
			$pitanje = DBConnection::fetch("SELECT * FROM pitanja WHERE pitanje_id = {$pitanje_id}");
			if (!empty($pitanje)) {
				$podaci = array();
				$podaci['pitanje'] = $this->vratiPitanje();
				$podaci['ispit_id'] = $this->vratiIspitId();
			}
			$promene = array();
			foreach ($podaci as $kolona => $vrednost) {
				array_push($promene, "`$kolona` = '$vrednost'");
			}

			$sql = "UPDATE pitanja SET " . implode(",", $promene) . " WHERE pitanje_id = {$pitanje_id}";
			return DBConnection::exec($sql);
		}
		return $this->insert();
	}

	public static function nadjiPoId($pitanje_id) {
		if (empty($pitanje_id)) {
			return null;
		}
		$podaci = DBConnection::fetch("SELECT * FROM pitanja WHERE pitanje_id = {$pitanje_id}");
		if (empty($podaci)) {
			return array();
		}
		$pitanje = new self;
		$pitanje->postaviPitanjeId($podaci['pitanje_id']);
		$pitanje->postaviPitanje($podaci['pitanje']);
		$pitanje->postaviIspitId($podaci['ispit_id']);
		return $pitanje;
	}

	public static function nadjiPoIpitId($ispit_id) {
		if (empty($ispit_id)) {
			return array();
		}
		$podaci = DBConnection::fetchAll("SELECT * FROM pitanja WHERE ispit_id = {$ispit_id}");
		if (empty($podaci)) {
			return array();
		}
		$pitanja = array();
		foreach ($podaci as $podatak) {
			$pitanje = new self;
			$pitanje->postaviPitanjeId($podatak['pitanje_id']);
			$pitanje->postaviPitanje($podatak['pitanje']);
			$pitanje->postaviIspitId($podatak['ispit_id']);
			array_push($pitanja, $pitanje);
		}
		return $pitanja;
	}

	public function vratiPitanjeId()
	{
		return $this->pitanje_id;
	}

	public function postaviPitanjeId($pitanje_id)
	{
		$this->pitanje_id = $pitanje_id;
	}

	public function vratiPitanje()
	{
		return $this->pitanje;
	}

	public function postaviPitanje($pitanje)
	{
		$this->pitanje = $pitanje;
	}

	public function vratiIspitId()
	{
		return $this->ispit_id;
	}

	public function postaviIspitId($ispit_id)
	{
		$this->ispit_id = $ispit_id;
	}
}
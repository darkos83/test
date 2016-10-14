<?php

class Pitanje {

	protected $pitanje_id;
	protected $pitanje;
	protected $ispit_id;
	protected $tacan_odgovor_id;

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
				$podaci['tacan_odgovor_id'] = $this->vratiTacanOdgovorId();
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
		$pitanje->postaviTacanOdgovorId($podaci['tacan_odgovor_id']);
		return $pitanje;
	}

	public static function nadjiPoIspitId($ispit_id) {
		if (empty($ispit_id)) {
			return array();
		}
		$podaci = DBConnection::fetchAll("SELECT * FROM pitanja WHERE ispit_id = {$ispit_id} ORDER BY pitanje_id ASC;");
		if (empty($podaci)) {
			return array();
		}

		$pitanja = array();
		foreach ($podaci as $podatak) {
			$pitanje = new self;
			$pitanje->postaviPitanjeId($podatak['pitanje_id']);
			$pitanje->postaviPitanje($podatak['pitanje']);
			$pitanje->postaviIspitId($podatak['ispit_id']);
			$pitanje->postaviTacanOdgovorId($podatak['tacan_odgovor_id']);
			array_push($pitanja, $pitanje);
		}
		return $pitanja;
	}

	public static function nadjiPitanjaIOdgovoreZaPofesore($ispit_id) {
		if (empty($ispit_id)) {
			return array();
		}
		$pitanja = self::nadjiPoIspitId($ispit_id);
		if (empty($pitanja)) {
			return array();
		}
		$pitanja_odgovori = array();
		foreach ($pitanja as $key => $pitanje) {
			$odgovori = Odgovor::nadjiPoPitanjeId($pitanje->vratiPitanjeId());
			$br = $key + 1;
			$pitanja_odgovori["pitanje_{$br}"] = $pitanje->vratiPitanje();
			$pitanja_odgovori["odgovori_{$br}"] = array();
			foreach ($odgovori as $key1 => $odgovor) {
				if ($odgovor->vratiOdgovorId() == $pitanje->vratiTacanOdgovorId()) {
					$pitanja_odgovori["tacan_odgovor_{$br}"] = $key1;
				}
				array_push($pitanja_odgovori["odgovori_{$br}"], $odgovor->vratiOdgovor());
			}
		}
		return $pitanja_odgovori;
	}

	public static function nadjiPitanjaIOdgovoreZaStudente($ispit_id) {
		if (empty($ispit_id)) {
			return array();
		}
		$pitanja = self::nadjiPoIspitId($ispit_id);
		if (empty($pitanja)) {
			return array();
		}
		$pitanja_odgovori = array();
		foreach ($pitanja as $key => $pitanje) {
			$odgovori = Odgovor::nadjiPoPitanjeId($pitanje->vratiPitanjeId());
			$br = $key + 1;
			$pitanja_odgovori["pitanje_{$br}"] = $pitanje->vratiPitanje();
			$pitanja_odgovori["odgovori_{$br}"] = array();
			foreach ($odgovori as $key1 => $odgovor) {
				if ($odgovor->vratiOdgovorId() == $pitanje->vratiTacanOdgovorId()) {
					$pitanja_odgovori["tacan_odgovor_{$br}"] = $key1;
				}
				$pitanja_odgovori["odgovori_{$br}"][$odgovor->vratiOdgovorId()] = $odgovor->vratiOdgovor();
			}
		}
		return $pitanja_odgovori;
	}

	public static function izbrisiPitanjaZaIspit($ispit_id)  {
		if (empty($ispit_id)) {
			return false;
		}
		$ispit = Ispit::nadjiPoId($ispit_id);
		if (empty($ispit)) {
			throw new Exception('Nije pronadjen ispit');
		}
		$pitanja = self::nadjiPoIspitId($ispit->vratiIspitId());
		if (empty($pitanja)) {
			return true;
		}
		foreach ($pitanja as $pitanje) {
			Odgovor::izbrisiOdgovoreZaPitanje($pitanje->vratiPitanjeId());
			DBConnection::exec("DELETE FROM pitanja WHERE pitanje_id = {$pitanje->vratiPitanjeId()}");
		}
		return true;
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

	public function vratiTacanOdgovorId()
	{
		return $this->tacan_odgovor_id;
	}

	public function postaviTacanOdgovorId($tacan_odgovor_id)
	{
		$this->tacan_odgovor_id = $tacan_odgovor_id;
	}


}
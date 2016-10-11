<?php

class Ispit {

	protected $ispit_id;
	protected $naziv_ispita;
	protected $broj_pitanja;
	protected $korisnik_id;

	public function insertuj() {
		$podaci = array();
		$podaci['naziv_ispita'] = DBConnection::prepareString($this->vratiNazivIspita());
		$podaci['broj_pitanja'] = $this->vratiBrojPitanja();
		$podaci['korisnik_id'] = $this->vratiKorisnikId();

		$imena_kolone = array();
		$vrednosti_kolone = array();
		foreach ($podaci as $kolona => $vrednost) {
			array_push($imena_kolone, "`$kolona`");
			array_push($vrednosti_kolone, "'$vrednost'");
		}
		$sql = "INSERT INTO ispiti (" .  implode(',', $imena_kolone).") "
			. "VALUES (" . implode(',', $vrednosti_kolone). ")";
		$res = DBConnection::exec($sql);

		if ($res) {
			$res = DBConnection::fetch("SELECT LAST_INSERT_ID() AS ispit_id");
			if ( !empty($res) ) {
				$this->postaviIspitId($res['ispit_id']);
				return TRUE;
			}
		}
		return FALSE;
	}

	public function snimi() {
		$ispit_id = $this->vratiIspitId();
		if (!empty($ispit_id)) {
			$ispit = DBConnection::fetch("SELECT * FROM ispiti WHERE ispit_id = {$ispit_id}");
			if (!empty($ispit)) {
				$podaci = array();
				$podaci['naziv_ispita'] = $this->vratiNazivIspita();
				$podaci['broj_pitanja'] = $this->vratiBrojPitanja();
				$podaci['korisnik_id'] = $this->vratiKorisnikId();
			}
			$promene = array();
			foreach ($podaci as $kolona => $vrednost) {
				array_push($promene, "`$kolona` = '$vrednost'");
			}

			$sql = "UPDATE ispiti SET " . implode(",", $promene) . " WHERE ispit_id = {$ispit_id}";
			return DBConnection::exec($sql);
		}
		return $this->insert();
	}

	public static function nadjiPoId($ispit_id) {
		if (empty($ispit_id)) {
			return null;
		}
		$podaci = DBConnection::fetch("SELECT * FROM ispiti WHERE ispit_id = {$ispit_id}");
		if (empty($podaci)) {
			return array();
		}
		$ispit = new self;
		$ispit->postaviIspitId($podaci['ispit_id']);
		$ispit->postaviNazivIspita($podaci['naziv_ispita']);
		$ispit->postaviBrojPitanja($podaci['broj_pitanja']);
		$ispit->postaviKorisnikId($podaci['korisnik_id']);
		return $ispit;
	}

	public static function nadjiPoKorisnikId($korisnik_id) {
		if (empty($korisnik_id)) {
			return null;
		}
		$podaci = DBConnection::fetchAll("SELECT * FROM ispiti WHERE korisnik_id = {$korisnik_id}");
		if (empty($podaci)) {
			return array();
		}
		$ispiti = array();
		foreach ($podaci as $podatak) {
			$ispit = new self;
			$ispit->postaviIspitId($podatak['ispit_id']);
			$ispit->postaviNazivIspita($podatak['naziv_ispita']);
			$ispit->postaviBrojPitanja($podatak['broj_pitanja']);
			$ispit->postaviKorisnikId($podatak['korisnik_id']);
			array_push($ispiti, $ispit);
		}
		return $ispiti;
	}

	public function vratiIspitId()
	{
		return $this->ispit_id;
	}

	public function postaviIspitId($ispit_id)
	{
		$this->ispit_id = $ispit_id;
	}

	public function vratiNazivIspita()
	{
		return $this->naziv_ispita;
	}

	public function postaviNazivIspita($naziv_ispita)
	{
		$this->naziv_ispita = $naziv_ispita;
	}

	public function vratiBrojPitanja()
	{
		return $this->broj_pitanja;
	}

	public function postaviBrojPitanja($broj_pitanja)
	{
		$this->broj_pitanja = $broj_pitanja;
	}

	public function vratiKorisnikId()
	{
		return $this->korisnik_id;
	}

	public function postaviKorisnikId($korisnik_id)
	{
		$this->korisnik_id = $korisnik_id;
	}

}
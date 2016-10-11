<?php

class Odgovor {

	protected $odgovor_id;
	protected $odgovor;
	protected $tacno;
	protected $pitanje_id;

	public function insertuj() {
		$podaci = array();
		$podaci['odgovor'] = DBConnection::prepareString($this->vratiOdgovor());
		$podaci['tacno'] = $this->vratiTacno();
		$podaci['pitanje_id'] = $this->vratiPitanjeId();

		$imena_kolone = array();
		$vrednosti_kolone = array();
		foreach ($podaci as $kolona => $vrednost) {
			array_push($imena_kolone, "`$kolona`");
			array_push($vrednosti_kolone, "'$vrednost'");
		}
		$sql = "INSERT INTO odgovori (" .  implode(',', $imena_kolone).") "
			. "VALUES (" . implode(',', $vrednosti_kolone). ")";
		$res = DBConnection::exec($sql);

		if ($res) {
			$res = DBConnection::fetch("SELECT LAST_INSERT_ID() AS odgovor_id");
			if ( !empty($res) ) {
				$this->postaviOdgovorId($res['odgovor_id']);
				return TRUE;
			}
		}
		return FALSE;
	}

	public function snimi() {
		$odgovor_id = $this->vratiOdgovorId();
		if (!empty($odgovor_id)) {
			$odgovor = DBConnection::fetch("SELECT * FROM odgovori WHERE odgovor_id = {$odgovor_id}");
			if (!empty($odgovor)) {
				$podaci = array();
				$podaci['odgovor'] = $this->vratiOdgovor();
				$podaci['tacno'] = $this->vratiTacno();
				$podaci['pitanje_id'] = $this->vratiPitanjeId();
			}
			$promene = array();
			foreach ($podaci as $kolona => $vrednost) {
				array_push($promene, "`$kolona` = '$vrednost'");
			}

			$sql = "UPDATE odgovori SET " . implode(",", $promene) . " WHERE odgovor_id = {$odgovor_id}";
			return DBConnection::exec($sql);
		}
		return $this->insert();
	}

	public static function nadjiPoId($odgovor_id) {
		if (empty($odgovor_id)) {
			return null;
		}
		$podaci = DBConnection::fetch("SELECT * FROM odgovori WHERE odgovor_id = {$odgovor_id}");
		if (empty($podaci)) {
			return array();
		}
		$odgovor = new self;
		$odgovor->postaviOdgovorId($podaci['odgovor_id']);
		$odgovor->postaviOdgovor($podaci['odgovor']);
		$odgovor->postaviTacno($podaci['tacno']);
		$odgovor->postaviPitanjeId($podaci['pitanje_id']);
		return $odgovor;
	}

	public static function nadjiPoPitanjeId($pitanje_id) {
		if (empty($pitanje_id)) {
			return array();
		}
		$podaci = DBConnection::fetchAll("SELECT * FROM odgovori WHERE pitanje_id = {$pitanje_id}");
		if (empty($podaci)) {
			return array();
		}
		$odgovori = array();
		foreach ($podaci as $podatak) {
			$odgovor = new self;
			$odgovor->postaviOdgovorId($podatak['odgovor_id']);
			$odgovor->postaviOdgovor($podatak['odgovor']);
			$odgovor->postaviTacno($podatak['tacno']);
			$odgovor->postaviPitanjeId($podatak['pitanje_id']);
			array_push($odgovori, $odgovor);
		}
		return $odgovori;
	}

	public function vratiOdgovorId()
	{
		return $this->odgovor_id;
	}

	public function postaviOdgovorId($odgovor_id)
	{
		$this->odgovor_id = $odgovor_id;
	}

	public function vratiOdgovor()
	{
		return $this->odgovor;
	}

	public function postaviOdgovor($odgovor)
	{
		$this->odgovor = $odgovor;
	}

	public function vratiTacno()
	{
		return $this->tacno;
	}

	public function postaviTacno($tacno)
	{
		$this->tacno = $tacno;
	}

	public function vratiPitanjeId()
	{
		return $this->pitanje_id;
	}

	public function postaviPitanjeId($pitanje_id)
	{
		$this->pitanje_id = $pitanje_id;
	}


}
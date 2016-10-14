<?php

class Korisnik {

	const PROFESOR = 1;
	const STUDENT = 2;

	protected $korisnik_id;
	protected $korisnicko_ime;
	protected $sifra;
	protected $ime;
	protected $prezime;
	protected $tip_korisnika;

	public function insertuj() {
		$podaci = array();
		$podaci['korisnicko_ime'] = DBConnection::prepareString($this->vratiKorisnickoIme());
		$podaci['sifra'] = md5($this->vratiSifra());
		$podaci['ime'] = DBConnection::prepareString($this->vratiIme());
		$podaci['prezime'] = DBConnection::prepareString($this->vratiPrezime());
		$podaci['tip_korisnika'] = $this->vratiTipKorisnika();

		$imena_kolone = array();
		$vrednosti_kolone = array();
		foreach ($podaci as $kolona => $vrednost) {
			array_push($imena_kolone, "`$kolona`");
			array_push($vrednosti_kolone, "'$vrednost'");
		}
		$sql = "INSERT INTO korisnici (" .  implode(',', $imena_kolone).") "
				. "VALUES (" . implode(',', $vrednosti_kolone). ")";
		$res = DBConnection::exec($sql);
		if ($res) {
			$res = DBConnection::fetch("SELECT LAST_INSERT_ID()");
			if ( !empty($res) ) {
				$this->postaviKorisnikId($res[0]);
				return TRUE;
			}
		}
		return FALSE;
	}

	public function snimi() {
		$korisnik_id = $this->vratiKorisnikId();
		if (!empty($korisnik_id)) {
			$korisnik = DBConnection::fetch("SELECT * FROM korisnici WHERE korisnik_id = {$korisnik_id}");
			if (!empty($korisnik)) {
				$podaci = array();
				$podaci['ime'] = $this->vratiIme();
				$podaci['prezime'] = $this->vratiPrezime();
			}
			$promene = array();
			foreach ($podaci as $kolona => $vrednost) {
				array_push($promene, "`$kolona` = '$vrednost'");
			}

			$sql = "UPDATE korisnici SET " . implode(",", $promene) . " WHERE korisnik_id = {$korisnik_id}";
			return DBConnection::exec($sql);
		}
		return $this->insert();
	}

	public static function nadjiPoId($korisnik_id) {
		if (empty($korisnik_id)) {
			return null;
		}
		$podaci = DBConnection::fetch("SELECT * FROM korisnici WHERE korisnik_id = {$korisnik_id}");
		if (empty($podaci)) {
			return null;
		}
		$korisnik = new self;
		$korisnik->postaviKorisnikId($podaci['korisnik_id']);
		$korisnik->postaviKorisnickoIme($podaci['korisnicko_ime']);
		$korisnik->postaviIme($podaci['ime']);
		$korisnik->postaviPrezime($podaci['prezime']);
		$korisnik->postaviTipKorisnika($podaci['tip_korisnika']);
		return $korisnik;
	}

	public static function nadjiPoKorisnickomImenuISifri($korisnicko_ime, $sifra) {
		if (empty($korisnicko_ime) && empty($sifra)) {
			return null;
		}
		$korisnicko_ime = DBConnection::prepareString($korisnicko_ime);
		$sifra = md5($sifra);
		$podaci = DBConnection::fetch("SELECT * FROM korisnici WHERE korisnicko_ime = '{$korisnicko_ime}' AND sifra = '{$sifra}'");
		if (empty($podaci)) {
			return null;
		}
		$korisnik = new self;
		$korisnik->postaviKorisnikId($podaci['korisnik_id']);
		$korisnik->postaviKorisnickoIme($podaci['korisnicko_ime']);
		$korisnik->postaviIme($podaci['ime']);
		$korisnik->postaviPrezime($podaci['prezime']);
		$korisnik->postaviTipKorisnika($podaci['tip_korisnika']);
		return $korisnik;
	}

	public static function nadjiPoKorisnickomImenu($korisnicko_ime) {
		if (empty($korisnicko_ime)) {
			return null;
		}
		$korisnicko_ime = DBConnection::prepareString($korisnicko_ime);
		$podaci = DBConnection::fetch("SELECT * FROM korisnici WHERE korisnicko_ime = '{$korisnicko_ime}'");
		if (empty($podaci)) {
			return null;
		}
		$korisnik = new self;
		$korisnik->postaviKorisnikId($podaci['korisnik_id']);
		$korisnik->postaviKorisnickoIme($podaci['korisnicko_ime']);
		$korisnik->postaviIme($podaci['ime']);
		$korisnik->postaviPrezime($podaci['prezime']);
		$korisnik->postaviTipKorisnika($podaci['tip_korisnika']);
		return $korisnik;
	}

	public static function obrisiPrijaveZaIspit($ispit_id) {
		if (empty($ispit_id)) {
			throw new Exception('Id Ispit je prazan!!!');
		}
		$ispit = Ispit::nadjiPoId($ispit_id);
		if (empty($ispit)) {
			throw new Exception('Ispit nije pronadjen!!!!');
		}
		return DBConnection::exec("DELETE FROM prijave WHERE ispit_id = {$ispit->vratiIspitId()};");
	}

	public static function prijaviStudentaZaIspit($ispit_id, $korisnik_id) {
		if (empty($ispit_id)) {
			throw new Exception('Id Ispit je prazan!!!');
		}
		if (empty($korisnik_id)) {
			throw new Exception('Id Korisnika je prazan!!!');
		}
		$ispit = Ispit::nadjiPoId($ispit_id);
		if (empty($ispit)) {
			throw new Exception('Ispit nije pronadjen!!!!');
		}
		$korisnik = self::nadjiPoId($korisnik_id);
		if (empty($korisnik)) {
			throw new Exception('Korisnik nije pronadjen!!!');
		}
		if ($korisnik->vratiTipKorisnika() != self::STUDENT) {
			throw new Exception('Korisnik nije student!!!');
		}
		$prijavljen = DBConnection::fetch("SELECT * FROM prijave WHERE ispit_id = {$ispit_id} AND korisnik_id = {$korisnik_id};");
		if (!empty($prijavljen)) {
			return false;
		}
		return DBConnection::exec("INSERT INTO prijave VALUES (NULL, {$ispit_id}, {$korisnik_id})");
	}

	public static function proveraDaLiJePrijavljenZaIspit($ispit_id, $korisnik_id) {
		if (empty($ispit_id)) {
			throw new Exception('Id Ispit je prazan!!!');
		}
		if (empty($korisnik_id)) {
			throw new Exception('Id Korisnika je prazan!!!');
		}
		$ispit = Ispit::nadjiPoId($ispit_id);
		if (empty($ispit)) {
			throw new Exception('Ispit nije pronadjen!!!!');
		}
		$korisnik = self::nadjiPoId($korisnik_id);
		if (empty($korisnik)) {
			throw new Exception('Korisnik nije pronadjen!!!');
		}
		if ($korisnik->vratiTipKorisnika() != self::STUDENT) {
			throw new Exception('Korisnik nije student!!!');
		}
		$prijavljen = DBConnection::fetch("SELECT * FROM prijave WHERE ispit_id = {$ispit_id} AND korisnik_id = {$korisnik_id};");
		return !empty($prijavljen);
	}

	public static function nadjiPrijavnjeneIspiteZaStudenta($korisnik_id) {
		if (empty($korisnik_id)) {
			throw new Exception('Id Korisnika je prazan!!!');
		}
		$korisnik = self::nadjiPoId($korisnik_id);
		if (empty($korisnik)) {
			throw new Exception('Korisnik nije pronadjen!!!');
		}
		if ($korisnik->vratiTipKorisnika() != self::STUDENT) {
			throw new Exception('Korisnik nije student!!!');
		}
		$upit = "SELECT i.ispit_id, i.naziv_ispita, i.broj_pitanja, i.korisnik_id "
				. "FROM prijave AS p "
				. "INNER JOIN ispiti AS i ON i.ispit_id = p.ispit_id "
				. "WHERE p.korisnik_id = {$korisnik_id}";
		$ispiti = DBConnection::fetchAll($upit);
		if (empty($ispiti)) {
			return array();
		}
		$_ispiti = array();
		foreach ($ispiti as $ispit) {
			$polagao = DBConnection::fetch("SELECT * FROM rezultati WHERE ispit_id = {$ispit['ispit_id']} AND korisnik_id = {$korisnik_id};");
			if (!empty($polagao)) {
				continue;
			}
			$_ispit = new Ispit();
			$_ispit->postaviIspitId($ispit['ispit_id']);
			$_ispit->postaviNazivIspita($ispit['naziv_ispita']);
			$_ispit->postaviBrojPitanja($ispit['broj_pitanja']);
			$_ispit->postaviKorisnikId($ispit['korisnik_id']);
			array_push($_ispiti, $_ispit);
		}
		return$_ispiti;
	}

	public static function nadjiPolozeneIspiteZaStudenta($korisnik_id) {
		if (empty($korisnik_id)) {
			throw new Exception('Id Korisnika je prazan!!!');
		}
		$korisnik = self::nadjiPoId($korisnik_id);
		if (empty($korisnik)) {
			throw new Exception('Korisnik nije pronadjen!!!');
		}
		if ($korisnik->vratiTipKorisnika() != self::STUDENT) {
			throw new Exception('Korisnik nije student!!!');
		}
		$upit = "SELECT i.ispit_id, i.naziv_ispita, i.broj_pitanja, i.korisnik_id, r.rezultat "
			. "FROM rezultati AS r "
			. "INNER JOIN ispiti AS i ON i.ispit_id = r.ispit_id "
			. "WHERE r.korisnik_id = {$korisnik_id};";
		$ispiti = DBConnection::fetchAll($upit);
		if (empty($ispiti)) {
			return array();
		}
		$_ispiti = array();
		foreach ($ispiti as $ispit) {
			$_ispit = new Rezultat($ispit);
			array_push($_ispiti, $_ispit);
		}
		return$_ispiti;
	}

	public static function nadjiPrijavljeneStudenteZaIspit($ispit_id) {
		if (empty($ispit_id)) {
			throw new Exception('Id Ispit je prazan!!!');
		}
		$ispit = Ispit::nadjiPoId($ispit_id);
		if (empty($ispit)) {
			throw new Exception('Ispit nije pronadjen!!!!');
		}
		$student_ids = DBConnection::fetchAll("SELECT korisnik_id FROM prijave WHERE ispit_id = {$ispit_id};");;
		return array_map(function($student_id) {return $student_id['korisnik_id'];}, $student_ids);
	}

	public static function polazi($ispit_id, $korisnik_id, $odgovori) {
		if (empty($korisnik_id)) {
			throw new Exception('Id Korisnika je prazan!!!');
		}
		$korisnik = self::nadjiPoId($korisnik_id);
		if (empty($korisnik)) {
			throw new Exception('Korisnik nije pronadjen!!!');
		}
		if ($korisnik->vratiTipKorisnika() != self::STUDENT) {
			throw new Exception('Korisnik nije student!!!');
		}
		if (empty($ispit_id)) {
			throw new Exception('Id ispita je prazan!!!');
		}
		$ispit = Ispit::nadjiPoId($ispit_id);
		if (empty($ispit)) {
			throw new Exception('Nije pronadjen ispit!!!');
		}
		if (empty($odgovori)) {
			throw new Exception('Nisu poslati odgovori!!!');
		}
		$upit = "SELECT COUNT(*) AS broj_tacnih_odgovora "
			. "FROM pitanja "
			. "WHERE ispit_id = {$ispit->vratiIspitId()} AND tacan_odgovor_id IN (" . implode(',', $odgovori) . ");";
		$podaci = DBConnection::fetch($upit);

		$rezultat = !empty($podaci['broj_tacnih_odgovora']) ?
			($podaci['broj_tacnih_odgovora'] / $ispit->vratiBrojPitanja()) * 100
			: 0;
		return DBConnection::exec("INSERT INTO rezultati VALUES(NULL, {$ispit->vratiIspitId()}, {$korisnik->vratiKorisnikId()}, {$rezultat});");
	}

	public static function nadjiSveStudente()
	{
		$podaci = DBConnection::fetchAll("SELECT * FROM korisnici WHERE tip_korisnika = " . Korisnik::STUDENT . " ORDER BY korisnik_id ASC;");
		if (empty($podaci)) {
			return array();
		}
		$studenti = array();
		foreach ($podaci as $_korisnik) {
			$korisnik = new self;
			$korisnik->postaviKorisnikId($_korisnik['korisnik_id']);
			$korisnik->postaviKorisnickoIme($_korisnik['korisnicko_ime']);
			$korisnik->postaviIme($_korisnik['ime']);
			$korisnik->postaviPrezime($_korisnik['prezime']);
			$korisnik->postaviTipKorisnika($_korisnik['tip_korisnika']);
			array_push($studenti, $korisnik);
		}
		return $studenti;
	}

	public function vratiKorisnikId()
	{
		return $this->korisnik_id;
	}

	public function postaviKorisnikId($korisnik_id)
	{
		$this->korisnik_id = $korisnik_id;
	}

	public function vratiKorisnickoIme()
	{
		return $this->korisnicko_ime;
	}

	public function postaviKorisnickoIme($korisnicko_ime)
	{
		$this->korisnicko_ime = $korisnicko_ime;
	}

	public function vratiSifra()
	{
		return $this->sifra;
	}

	public function postaviSifra($sifra)
	{
		$this->sifra = $sifra;
	}

	public function vratiIme()
	{
		return $this->ime;
	}

	public function postaviIme($ime)
	{
		$this->ime = $ime;
	}

	public function vratiPrezime()
	{
		return $this->prezime;
	}

	public function postaviPrezime($prezime)
	{
		$this->prezime = $prezime;
	}

	public function vratiTipKorisnika()
	{
		return $this->tip_korisnika;
	}

	public function postaviTipKorisnika($tip_korisnika)
	{
		$this->tip_korisnika = $tip_korisnika;
	}

}
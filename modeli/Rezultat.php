<?php

class Rezultat {

	protected $ispit_id;
	protected $naziv_ispita;
	protected $broj_pitanja;
	protected $rezultat;

	public function __construct($rezultat)
	{
		$this->ispit_id = !empty($rezultat['ispit_id']) ? $rezultat['ispit_id'] : null;
		$this->naziv_ispita = !empty($rezultat['naziv_ispita']) ? $rezultat['naziv_ispita'] : null;
		$this->broj_pitanja = !empty($rezultat['broj_pitanja']) ? $rezultat['broj_pitanja'] : null;
		$this->rezultat = !empty($rezultat['rezultat']) ? $rezultat['rezultat'] : null;
	}

	public function vratiIspitId()
	{
		return $this->ispit_id;
	}

	public function vratiNazivIspita()
	{
		return $this->naziv_ispita;
	}


	public function vratiBrojPitanja()
	{
		return $this->broj_pitanja;
	}

	public function vratiRezultat()
	{
		return $this->rezultat;
	}

}
<?php
include __DIR__ . '/config.php';
session_start();
$greske = array();
if (!isset($_SESSION['tip_korisnika']) || $_SESSION['tip_korisnika'] != Korisnik::PROFESOR) {
	array_push($greske, 'Morate biti profesor da bi ste pristupili ovoj stranici!');	
}
if (isset($_POST['submit'])) {
	$upozorenja = array();
	if (empty($_POST['naziv_ispita'])) {
		array_push($upozorenja, 'Naziv ispita je prazno!');
	}
	if (empty($_POST['broj_pitanja'])) {
		array_push($upozorenja, 'Broj pitanja je prazno!');
	}
	if (empty($upozorenja)) {
		$ispit = new Ispit();
		$ispit->postaviNazivIspita($_POST['naziv_ispita']);
		$ispit->postaviBrojPitanja($_POST['broj_pitanja']);
		$ispit->postaviKorisnikId($_SESSION['korisnik_id']);
		if($ispit->insertuj()) {
			$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
			header("Location: {$url}/ispit.php?ispit_id={$ispit->vratiIspitId()}");
			exit;
		}
		array_push($upozorenja, 'Doslo je do greske pilikom snimanja!');
	}
}
include __DIR__ . '/public/views/kreiraj_ispit.php';
?>



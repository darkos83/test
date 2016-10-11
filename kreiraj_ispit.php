<?php
require_once __DIR__ . '/config.php';
session_start();
if (!isset($_SESSION['tip_korisnika']) || $_SESSION['tip_korisnika'] != Korisnik::PROFESOR)  {
	?>
	<div class="alert alert-danger my-alert">
		Niste autorizovani za pregled ove stranice!!!
	</div>
	<?php
	die;
}
if (isset($_POST['submit'])) {
	$greske = array();
	if (empty($_POST['naziv_ispita'])) {
		array_push($greske, 'Naziv ispita je prazno!');
	}
	if (empty($_POST['broj_pitanja'])) {
		array_push($greske, 'Broj pitanja je prazno!');
	}
	if (empty($greske)) {
		$ispit = new Ispit();
		$ispit->postaviNazivIspita($_POST['naziv_ispita']);
		$ispit->postaviBrojPitanja($_POST['broj_pitanja']);
		$ispit->postaviKorisnikId($_SESSION['korisnik_id']);
		if($ispit->insertuj()) {
			$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
			header("Location: {$url}ispit.php?ispit_id={$ispit->vratiIspitId()}");
			exit;
		}
		array_push($greske, 'Doslo je do greske pilikom snimanja!');
	}
}
include_once __DIR__ . '/public/views/kreiraj_ispit.php';
?>



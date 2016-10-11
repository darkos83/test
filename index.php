<?php

require_once __DIR__ . '/config.php';
session_start();
if (isset($_SESSION['korisnik_id'])) {
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	if (!isset($_SESSION['tip_korisnika'])) {
		$korisnik = Korisnik::nadjiPoId($_SESSION['korisnik_id']);
		if (empty($korisnik)) {
			session_start();
			session_destroy();
			header("Location: {$url}index.php");
		}
		$_SESSION['tip_korisnika'] = $korisnik->vratiTipKorisnika();
	}
	if (Korisnik::PROFESOR == $_SESSION['tip_korisnika']) {
		header("Location: {$url}profesor.php");
	}
	if (Korisnik::STUDENT == $_SESSION['tip_korisnika']) {
		header("Location: {$url}student.php");
	}
}

if (isset($_POST['submit'])) {
	$greske = array();
	if (empty($_POST['korisnicko_ime'])) {
		array_push($greske, 'Korisnicko ime je prazno!');
	}
	if (empty($_POST['sifra'])) {
		array_push($greske, 'Sifra je prazna!');
	}
	$korisnik = Korisnik::nadjiPoKorisnickomImenuISifri($_POST['korisnicko_ime'], $_POST['sifra']);
	if (empty($korisnik)) {
		array_push($greske, 'Neispravni podaci za logovanje!');
	}
	if (empty($greske)) {
		$_SESSION['korisnik_id'] = $korisnik->vratiKorisnikId();
		$_SESSION['tip_korisnika'] = $korisnik->vratiTipKorisnika();
		$_SESSION['ime'] = $korisnik->vratiIme();
		$_SESSION['prezime'] = $korisnik->vratiPrezime();


		$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
		if (Korisnik::PROFESOR == $korisnik->vratiTipKorisnika()) {
			header('Location: ' . $url . 'profesor.php');
			exit;
		}
		if (Korisnik::STUDENT == $korisnik->vratiTipKorisnika()) {
			header('Location: ' . $url . 'student.php');
			exit;
		}
	}
}
include_once __DIR__ . '/public/views/login.php';
?>

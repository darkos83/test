<?php

include __DIR__ . '/config.php';
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
		header("Location: {$url}/profesor.php");
	}
	if (Korisnik::STUDENT == $_SESSION['tip_korisnika']) {
		header("Location: {$url}/student.php");
	}
}
if (isset($_POST['submit'])) {
	$upozorenja = array();
	if ($_POST['akcija'] == 'registracija_studenta' || $_POST['akcija'] == 'registracija_profesora') {
		if (empty($_POST['ime'])) {
			array_push($upozorenja, 'Ime je prazno!');
		}
		if (empty($_POST['prezime'])) {
			array_push($upozorenja, 'Prezimeime je prazno!');
		}
		if (empty($_POST['korisnicko_ime'])) {
			array_push($upozorenja, 'Emial je prazan!');
		}
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		if (!preg_match($regex, $_POST['korisnicko_ime'])) {
			array_push($upozorenja, 'Email nije validan!');
		}
		if (empty($_POST['sifra'])) {
			array_push($upozorenja, 'Sifra je prazna!');
		}
		$tip_korisnika = $_POST['akcija'] == 'registracija_studenta' ? Korisnik::STUDENT :
			($_POST['akcija'] == 'registracija_profesora' ? Korisnik::PROFESOR : NULL);
		if (empty($tip_korisnika)) {
			array_push($upozorenja, 'Tip korisnika nije validan!');
		}
		if (empty($upozorenja)) {
			$korisnik = new Korisnik();
			$korisnik->postaviIme($_POST['ime']);
			$korisnik->postaviPrezime($_POST['prezime']);
			$korisnik->postaviKorisnickoIme($_POST['korisnicko_ime']);
			$korisnik->postaviSifra($_POST['sifra']);
			$korisnik->postaviTipKorisnika($tip_korisnika);
			if (!$korisnik->insertuj()) {
				array_push($upozorenja, 'Doslo je do greske prilikom snimanja!');
			}
		}
	}
	if ($_POST['akcija'] == 'logovanje') {
		if (empty($_POST['korisnicko_ime'])) {
			array_push($upozorenja, 'Korisnicko ime je prazno!');
		}
		if (empty($_POST['sifra'])) {
			array_push($upozorenja, 'Sifra je prazna!');
		}
	}
	if (empty($upozorenja)) {
		$korisnik = Korisnik::nadjiPoKorisnickomImenuISifri($_POST['korisnicko_ime'], $_POST['sifra']);
		if (empty($korisnik)) {
			array_push($upozorenja, 'Neispravni podaci za logovanje!');
		}
	}

	if (empty($upozorenja)) {
		$_SESSION['korisnik_id'] = $korisnik->vratiKorisnikId();
		$_SESSION['tip_korisnika'] = $korisnik->vratiTipKorisnika();
		$_SESSION['ime'] = $korisnik->vratiIme();
		$_SESSION['prezime'] = $korisnik->vratiPrezime();


		$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
		if (Korisnik::PROFESOR == $korisnik->vratiTipKorisnika()) {
			header('Location: ' . $url . '/profesor.php');
			exit;
		}
		if (Korisnik::STUDENT == $korisnik->vratiTipKorisnika()) {
			header('Location: ' . $url . '/student.php');
			exit;
		}
	}
}
include __DIR__ . '/public/views/login.php';
?>

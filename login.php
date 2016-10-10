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
if (empty($_REQUEST['korisnicko_ime'])) {
	echo json_encode(array('greska' => 1, 'poruka' => 'Korisnicko ime je prazno!'));
	exit;
}
if (empty($_REQUEST['sifra'])) {
	echo json_encode(array('greska' => 1, 'poruka' => 'Sifra je prazna!'));
	exit;
}

$korisnik = Korisnik::nadjiPoKorisnickomImenuISifri($_REQUEST['korisnicko_ime'], $_REQUEST['sifra']);

if (empty($korisnik)) {
	echo json_encode(array('greska' => 1, 'poruka' => 'Neispravni podaci za logovanje!'));
	exit;
}

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

echo json_encode(array('greska' => 0, 'url' => 'Neispravni podaci za logovanje!'));
exit;
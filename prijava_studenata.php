<?php
include __DIR__ . '/config.php';
session_start();
if (!isset($_SESSION['korisnik_id'])) {
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	header('Location: ' . $url . '/index.php');
	exit;
}
$greske = array();
if (!isset($_SESSION['tip_korisnika']) || $_SESSION['tip_korisnika'] != Korisnik::PROFESOR) {
	array_push($greske, 'Morate biti profesor da bi ste pristupili ovoj stranici!');
}
$ispit = Ispit::nadjiPoId($_GET['ispit_id']);
if (empty($ispit)) {
	array_push($greske, 'Nije pronadjen ispit!!!');
}
if (empty($greske)){
	if (!empty($_POST['studenti'])) {
		$upozorenja = array();
		Korisnik::obrisiPrijaveZaIspit($ispit->vratiIspitId());
		foreach ($_POST['studenti'] as $student_id) {
			if (!Korisnik::proveraDaLiJePrijavljenZaIspit($ispit->vratiIspitId(), $student_id)) {
				Korisnik::prijaviStudentaZaIspit($ispit->vratiIspitId(), $student_id);
			}
		}
		$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
		header('Location: ' . $url . '/profesor.php');
		exit;
	}
}
$studenti = Korisnik::nadjiSveStudente();
$student_ids = Korisnik::nadjiPrijavljeneStudenteZaIspit($ispit->vratiIspitId());
include __DIR__ . '/public/views/prijava_studenata.php';
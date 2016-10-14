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
$ispiti = Ispit::nadjiPoKorisnikId($_SESSION['korisnik_id']);
include __DIR__ . '/public/views/profesor.php';

<?php
include __DIR__ . '/config.php';
session_start();
if (!isset($_SESSION['korisnik_id'])) {
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	header('Location: ' . $url . '/index.php');
	exit;
}
$greske = array();
if (!isset($_SESSION['tip_korisnika']) || $_SESSION['tip_korisnika'] != Korisnik::STUDENT) {
	array_push($greske, 'Morate biti student da bi ste pristupili ovoj stranici!');	
}
try {
	$upozorenja = array();
	$prijave = Korisnik::nadjiPrijavnjeneIspiteZaStudenta($_SESSION['korisnik_id']);
	$polaganje= Korisnik::nadjiPolozeneIspiteZaStudenta($_SESSION['korisnik_id']);
} catch (Exception $e) {
	array_push($upozorenja, $e->getMessage());
}
include __DIR__ . '/public/views/student.php';
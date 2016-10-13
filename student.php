<?php
include __DIR__ . '/config.php';
session_start();
$greske = array();
if (!isset($_SESSION['tip_korisnika']) || $_SESSION['tip_korisnika'] != Korisnik::STUDENT) {
	array_push($greske, 'Morate biti student da bi ste pristupili ovoj stranici!');	
}
$prijave = Korisnik::nadjiPrijavnjeneIspiteZaStudenta($_SESSION['korisnik_id']);
$polagani_ispiti = Korisnik::nadjiPolozeneIspiteZaStudenta($_SESSION['korisnik_id']);
var_dump($prijave);
var_dump($polagani_ispiti);
include __DIR__ . '/public/views/student.php';
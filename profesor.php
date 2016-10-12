<?php
include __DIR__ . '/config.php';
session_start();
$greske = array();
if (!isset($_SESSION['tip_korisnika']) || $_SESSION['tip_korisnika'] != Korisnik::PROFESOR) {
	array_push($greske, 'Morate biti profesor da bi ste pristupili ovoj stranici!');	
}
include __DIR__ . '/public/views/profesor.php';

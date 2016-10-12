<?php
include __DIR__ . '/config.php';
session_start();
$greske = array();
if (!isset($_SESSION['tip_korisnika']) || $_SESSION['tip_korisnika'] != Korisnik::STUDENT)  {
	array_push($greske, 'Morate biti student da bi ste pristupili ovoj stranici!');
}
include __DIR__ . '/public/views/polaganje_ispita.php';
?>
<?php
include __DIR__ . '/config.php';
session_start();
$greske = array();
if (!isset($_SESSION['tip_korisnika']) || $_SESSION['tip_korisnika'] != Korisnik::STUDENT)  {
	array_push($greske, 'Morate biti student da bi ste pristupili ovoj stranici!');
}
$ispit = Ispit::nadjiPoId($_GET['ispit_id']);
if (empty($ispit)) {
	array_push($greske, 'Nije pronadjen ispit!!!');
}
try {
	if (empty($greske) && !Korisnik::proveraDaLiJePrijavljenZaIspit($ispit->vratiIspitId(), $_SESSION['korisnik_id'])) {
		array_push($greske, 'Student nije prijavljen za ispit!!!');
	}
}catch (Exception $e) {
	array_push($greske, $e->getMessage());
}
if (empty($greske)) {
	$pitanja_i_odgovori = Pitanje::nadjiPitanjaIOdgovore($ispit->vratiIspitId());
	$upozorenja = array();
	if (empty($pitanja_i_odgovori)) {
		array_push($upozorenja, 'Jos uvek nisu definisana pitanja za ovaj ispit!');
	}
}

include __DIR__ . '/public/views/polazi_ispit.php';
?>
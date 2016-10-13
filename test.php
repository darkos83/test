<?php
require_once __DIR__ . '/config.php';

try {
	$a = Korisnik::nadjiPrijavnjeneIspiteZaStudenta(8);
	var_dump($a);
} catch (Exception $e) {
	var_dump($e->getMessage());
}
<?php
require_once __DIR__ . '/config.php';
session_start();

$greske = array();
$ispit = Ispit::nadjiPoId($_GET['ispit_id']);
if (empty($ispit)) {
	array_push($greske, 'Nije pronadjen ispit!!!');
}
var_dump($ispit);
<?php
include __DIR__ . '/config.php';
session_start();
$greske = array();
if (empty($_SESSION)) {
	array_push($greske, 'Morate biti ulogovani da bi ste pristupili ovoj stranici!');	
}
$ispit = Ispit::nadjiPoId($_GET['ispit_id']);
if (empty($ispit)) {
	array_push($greske, 'Nije pronadjen ispit!!!');
}
include __DIR__ . '/public/views/ispiti.php';
<?php
define("MYSQL_SET_NAMES_VALUE","SET NAMES utf8");
define ("ENCODING_FROM", "ASCII, UTF-8, ISO-8859-1, ISO-8859-15");
define ("ENCODING_TO", "UTF-8");
define ("ENCODE_ALL_DATA", true);

$db_server="127.0.0.1";
$db_login="root";
$db_pass="123123";
$db_name="ispiti";

define('DB_PATH', __DIR__ . '/db/');
define('DB_MODELS', __DIR__ . '/modeli/');

function dbClassLoader($class, $path = DB_PATH) {
	if (is_file("$path$class.php")) {
		require_once "$path$class.php";
	} elseif ($handle = opendir($path)) {
		while (($entry = readdir($handle)) !== FALSE) {
			if ($entry[0] !== "." && is_dir("$path$entry")) {
				dbClassLoader($class, "$path$entry/");
			}
		}
	}
}

function modelsClassLoader($class, $path = DB_MODELS) {
	if (is_file("$path$class.php")) {
		require_once "$path$class.php";
	} elseif ($handle = opendir($path)) {
		while (($entry = readdir($handle)) !== FALSE) {
			if ($entry[0] !== "." && is_dir("$path$entry")) {
				modelsClassLoader($class, "$path$entry/");
			}
		}
	}
}

spl_autoload_register('dbClassLoader');
spl_autoload_register('modelsClassLoader');

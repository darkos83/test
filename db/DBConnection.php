<?php

class DBConnection {
	
	private static $instance = null;

	private function __construct() {
	}
	
	public static function get($new = false) {
		if (empty(self::$instance) || $new) {
			global $db_server;
			global $db_login;
			global $db_pass;
			global $db_name;
			try {
				Log::info("Connecting to database...");
				self::$instance = new PDO("mysql:host=$db_server;dbname=$db_name", "$db_login", "$db_pass",  array(PDO::ATTR_PERSISTENT => false, PDO::MYSQL_ATTR_INIT_COMMAND => MYSQL_SET_NAMES_VALUE));
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			} catch (Exception $e) {
				Log::err("Exception: " . $e->getMessage());
				Log::err("Trace: " . $e->getTraceAsString());
				self::$instance = null;
			}
		}
		return self::$instance;
	}
	
	public static function setAttribute($attribute, $value) { 
		if (self::get()) {
			try {
				return self::$instance->setAttribute($attribute, $value);
			} catch (Exception $e) {
				Log::err("Exception: " . $e->getMessage());
				Log::err("Trace: " . $e->getTraceAsString());
			}
		} else {
			Log::err("Not connected to database.");
		}
		return false;
	}
	
	public static function exec($sql) {
		Log::info("Execute statement: $sql");
		if (self::get()) {
			try {
				return self::$instance->exec($sql);
			} catch (Exception $e) {
				Log::err("Exception: " . $e->getMessage());
				Log::err("Trace: " . $e->getTraceAsString());
			}
		} else {
			Log::err("Not connected to database.");
		}
		return null;
	}
	
	public static function query($sql) {
		Log::info("Query: $sql");
		if (self::get()) {
			try {
				return self::$instance->query($sql);
			} catch (PDOException $exception) {
				Log::err("PDO Exception: " . $exception->getMessage());
				Log::err("PDO Trace: " . $exception->getTraceAsString());
			} catch (Exception $e) {
				Log::err("Exception: " . $e->getMessage());
				Log::err("Trace: " . $e->getTraceAsString());
			}
		} else {
			Log::err("Not connected to database.");
		}
		return null;
	}
	
	public static function fetch($sql) {
		$result = self::query($sql);
		return empty($result) ? null : $result->fetch();
	}
	
	public static function fetchAll($sql, $safe = TRUE) {
		$result = self::query($sql);
		return empty($result) ? ($safe ? array() : null) : $result->fetchAll();
	}
	
	public static function lastInsertId() {
		return self::$instance->lastInsertId();
	}
	
	public static function prepareString($text, $encode = ENCODE_ALL_DATA, $from = ENCODING_FROM, $to = ENCODING_TO) {
		$text = addslashes(stripslashes(stripslashes(stripslashes(trim(html_entity_decode($text))))));
		if ($encode) {
			$enc = mb_detect_encoding($text, "$from", false);
			if (($enc == 'ASCII') and ($to == "UTF-8")) {
				$text = utf8_encode($text);
			} else {
				$text = mb_convert_encoding($text, "$to", mb_detect_encoding($text, "$from", false));
			}
		}
		return $text;
	}
}
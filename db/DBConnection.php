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
				self::$instance = new PDO(
					"mysql:host=$db_server;dbname=$db_name", "$db_login",
					"$db_pass",
					array(PDO::ATTR_PERSISTENT => false, PDO::MYSQL_ATTR_INIT_COMMAND => MYSQL_SET_NAMES_VALUE)
				);
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (Exception $e) {
				var_dump($e->getMessage());die;
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
			}
		}
		return false;
	}
	
	public static function exec($sql) {
		if (self::get()) {
			try {
				return self::$instance->exec($sql);
			} catch (Exception $e) {
			}
		}
		return null;
	}
	
	public static function query($sql) {
		if (self::get()) {
			try {
				return self::$instance->query($sql);
			} catch (PDOException $exception) {
			} catch (Exception $e) {
			}
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
	
	public static function prepareString($text) {
		$text = addslashes(stripslashes(stripslashes(stripslashes(trim(html_entity_decode($text))))));
		return $text;
	}
}
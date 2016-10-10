<?php

class Log {
	
	private static $log = null;
	
	private static function writeMessage($message, $type = "INFO") {
		if (empty(self::$log)) {
			self::$log = @fopen("ispiti.log", "a+");
		}
		@fwrite(self::$log, date("Y-m-d H:i:s") . " ($type) $message\n");
	}
	
	public static function err($message) {
		self::writeMessage($message, "ERROR");
	}
	
	public static function info($message) {
		self::writeMessage($message, "INFO");
	}
	
}

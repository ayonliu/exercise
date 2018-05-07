<?php

/**
* redis
*/
class MyRedis
{

	private static $instance = null;
	
	function __construct($argument)
	{
		# code...
	}

	public static function getInstance()
	{
		if (self::$instance) {
		} else {
			self::$instance = new Redis();
			self::$instance->connect('127.0.0.1', 6379);
		}
		return self::$instance;
	}

	final public static function __callStatic($method, $arrArguments)
	{
		$objInstance = self::getInstance();
		return call_user_func_array(array($objInstance, $method), $arrArguments);
	}
}

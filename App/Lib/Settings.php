<?php

namespace App\Lib;

use \Exception;

class Settings
{

	private static $environment;

	public function __construct()
	{
	}

	public static function setEnvironment($environment)
	{
		$protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
		$host = $protocol . $_SERVER['SERVER_NAME'];
		define('PATH', $host);
	}

	public static function getEnvironment()
	{
		return self::$environment;
	}
}

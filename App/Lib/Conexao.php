<?php

namespace App\Lib;

use App\Lib\Settings;
use \PDO;

class Conexao {

    protected static $connection;

    public function __construct () {}

    public static function getConnection () {

        $environment = Settings::getEnvironment();
        if (!is_null($environment)) {
            try {
                if (!isset(self::$connection)) {
                    self::$connection = new PDO("mysql:dbname=" . $environment['dbname'] . ";host=" . $environment['host'] . ";charset=utf8", $environment['dbuser'], $environment['dbpass']);
    				self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }

                return self::$connection;
            } catch (\Exception $e) {
                throw new \Exception("Erro ao conectar ao banco de dados.\n".$e->getMessage(), 500);
    			exit;
            }

        }
    }

}

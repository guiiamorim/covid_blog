<?php

namespace App\Lib;

use App\Models\DAO\ConfiguracaoDAO;
use App\Models\Entidades\Configuracao;

abstract class Configuracoes {

    private static $config;

    public function __construct() {}

    public static function getConfig() {

        $configDAO      = new ConfiguracaoDAO();
        self::$config   = $configDAO->listar();

        return self::$config;

    }

}

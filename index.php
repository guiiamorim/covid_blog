<?php

use App\App;
use App\Lib\Erro;
use App\Lib\Settings;
use App\Lib\Configuracoes;

require_once "vendor/autoload.php";
require_once "generated-conf/config.php";

session_start();
date_default_timezone_set('America/Sao_Paulo');

try {
	$app = new App();
	Settings::setEnvironment("production");

	$app->run();
} catch (\Exception $e) {
	$oError = new Erro($e);
	$oError->render();
}

/*$app = new App();
echo $app->run();*/
?>

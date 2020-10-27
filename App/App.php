<?php

namespace App;

use App\controllers\Controller;
use Exception;


// Identifica a url para achar o arquivo no controle
/**
 *
 */
class App {

    /**
     *
     */
    public function run() {

        $url = '/';
        if (isset($_GET['url'])) {
            $url .= $_GET['url'];
        }

        $params = array();

        if (!empty($url) and $url != '/') {
            $url = explode('/', $url);
            array_shift($url);

            $currentController = ucwords($url[0]) . 'Controller';

            array_shift($url);

            if (isset($url[0]) && !empty($url[0]) && !is_numeric($url[0])) {
                $currentAction = ucwords($url[0]);
                array_shift($url);
            } else { $currentAction = 'index';}

            if (isset($url[0]) > 0 && $url[0] != '') {
                $params = $url;
            }

        } else {

            $currentController = 'BlogController';
            $currentAction     = 'index';
        }

        $currentController = "\\App\\Controllers\\" . $currentController;

        if (!class_exists($currentController)) {

            throw new Exception("Página não encontrada.", 404);

        } else {
            $objetoController = new $currentController();
        }

        if (method_exists($objetoController, $currentAction)) {
            call_user_func_array(array($objetoController, $currentAction), $params);
            return;
        } else if (!$currentAction && method_exists($objetoController, 'index')) {
            $objetoController->index($params);
            return;
        } else {
            throw new Exception("Página não encontrada.", 404);
        }
        throw new Exception("Página não encontrada.", 404);
    }
}

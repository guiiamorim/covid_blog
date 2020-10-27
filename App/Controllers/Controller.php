<?php

namespace App\Controllers;

use App\Lib\Sessao;

/**
 * Classe base abstrata para controller
 */
abstract class Controller
{
    private $viewVar;

    public function __construct(){}

    /**
     * Renderiza a view com susas vaiáveis e sessão
     * @param mixed $view Caminho da view a ser renderizada
     */
    public function render($view, $endpoint)
    {
        if (!is_null($this->getViewVar()))
    		extract($this->getViewVar());
        
        $Sessao    = Sessao::class;
        $menus	   = [
        	'blog' => 'App/Views/layouts/blog-menu.php',
			'admin' => 'App/Views/layouts/admin-menu.php',
			'moderator' => 'App/Views/layouts/moderator-menu.php'
		];

        require_once 'App/Views/layouts/head.php';
        require_once $menus[$endpoint];
        require_once 'App/Views/' . $view . '.php';
        require_once 'App/Views/layouts/scripts.php';
    }

    /**
     * Renderiza a view com susas vaiáveis e sessão, sem incluir o menu do sistema
     * @param mixed $view Caminho da view a ser renderizada
     */
    public function renderWithoutMenu($view)
    {
		if (!is_null($this->getViewVar()))
			extract($this->getViewVar());
        $Sessao    = Sessao::class;

        require_once 'App/Views/layouts/head.php';
        require_once 'App/Views/' . $view . '.php';
        require_once 'App/Views/layouts/scripts.php';
    }

    /**
     * Renderiza a view com susas vaiáveis e sessão, sem incluir o menu, header e footer do sistema
     * @param mixed $view Caminho da view a ser renderizada
     */
    public function renderViewOnly($view)
    {
		if (!is_null($this->getViewVar()))
			extract($this->getViewVar());
        $Sessao     = Sessao::class;

        require_once 'App/Views/' . $view . '.php';
    }

    /**
     * Renderiza o layout com susas vaiáveis e sessão, sem incluir o menu, header e footer do sistema
     * @param mixed $view Caminho do layout a ser renderizada
     */
    public function renderLayout($layout)
    {
        $viewVar    = $this->getViewVar();
        $Sessao     = Sessao::class;

        require_once 'App/Views/layouts/' . $layout . '.php';
    }

    /**
     * Redireciona para uma view específica
     * @param  mixed $view Caminho da view para redirecionar
     */
    public function redirect($view)
    {
        header('Location:' . PATH .'/'. $view);
        exit;
    }

    /**
     * Retorna a variável da view
     * @return array array contendo as variáveis da view
     */
    public function getViewVar()
    {
        return $this->viewVar;
    }

    /**
     * Adiciona informações ao array da view
     * @param mixed $varName Índice do array
     * @param mixed $varValue Valor a ser guardado
     */
    public function setViewParam($varName, $varValue)
    {
        if ($varName != "") {
            $this->viewVar[$varName] = $varValue;
        }
    }

    /**
     * Verifica se o usuário logoado no sistema tem acesso a uma determinada função ou local
     * @param  mixed $target  Acesso ou permissão a ser verificado(a)
     * @return boolean         True se o usuário ter acesso ou false caso contrário ou se não houver usuário logado
     */
    public function verifyAccess($target = null)
    {
        $login = Sessao::retornaLogin();
        
        if (!is_null($login)) {
			if ($login->getTipo() == $target or is_null($target)) {
				return true;
			}
        }
        return false;
    }
}

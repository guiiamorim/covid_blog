<?php

namespace App\Lib;

use Exception;

class Erro
{
    private $message;
    private $code;

    public function __construct($objetoException = Exception::class)
    {
        $this->code     = $objetoException->getCode();
        $this->message  = $objetoException;
    }

    public function render()
    {
        $varMessage = $this->message;
        
        if(file_exists("App/Views/error/".$this->code.".php")){
            require_once "App/Views/error/".$this->code.".php";
        }else{
            require_once "App/Views/error/500.php";
        }
        exit;
    }
}

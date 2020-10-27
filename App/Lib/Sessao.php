<?php

namespace App\Lib;

use App\Models\Entidades\Funcionario;
use App\Models\Usuario;

class Sessao
{
	public static function gravaMensagem($mensagem)
	{
		$_SESSION['mensagem'] = $mensagem;
	}
	
	public static function limpaMensagem()
	{
		unset($_SESSION['mensagem']);
	}
	
	public static function retornaMensagem()
	{
		return (isset($_SESSION['mensagem'])) ? $_SESSION['mensagem'] : "";
	}
	
	public static function gravaFormulario($controller, $acao, $form)
	{
		$_SESSION['form'][$controller][$acao] = $form;
	}
	
	public static function limpaFormulario($controller = null, $acao = null)
	{
		if (is_null($controller)) {
			unset($_SESSION['form']);
		} elseif (is_null($acao)) {
			unset($_SESSION['form'][$controller]);
		} else {
			unset($_SESSION['form'][$controller][$acao]);
		}
	}
	
	public static function retornaValorFormulario($controller, $acao, $key)
	{
		return (isset($_SESSION['form'][$controller][$acao][$key])) ? $_SESSION['form'][$controller][$acao][$key] : "";
	}
	
	public static function retornaFormulario($controller, $acao)
	{
		return (isset($_SESSION['form'][$controller][$acao])) ? $_SESSION['form'][$controller][$acao] : "";
	}
	
	public static function existeFormulario()
	{
		return (isset($_SESSION['form'])) ? $_SESSION['form'] : "";
	}
	
	public static function gravaErro($erros)
	{
		$_SESSION['error'] = $erros;
	}
	
	public static function retornaErro()
	{
		return (isset($_SESSION['error'])) ? $_SESSION['error'] : false;
	}
	
	public static function limpaErro()
	{
		unset($_SESSION['error']);
	}
	
	public static function gravaLogin(Usuario $usuario)
	{
		$_SESSION['usuario'] = $usuario;
	}
	
	public static function retornaLogin(): ?Usuario
	{
		return isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
	}
	
	public static function limpaLogin()
	{
		unset($_SESSION['usuario']);
	}
	
	public static function gravaInfo($info, $data)
	{
		$_SESSION[$info] = $data;
	}
	
	public static function retornaInfo($info)
	{
		return isset($_SESSION[$info]) ? $_SESSION[$info] : null;
	}
	
	public static function limpaInfo($info)
	{
		unset($_SESSION[$info]);
	}
	
}

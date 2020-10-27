<?php


namespace App\Controllers;

use App\Lib\Sessao;
use App\Models\ComunidadeQuery;
use App\Models\Usuario;
use App\Models\UsuarioQuery;

class LoginController extends Controller
{
	public function index()
	{
		$usuario = Sessao::retornaLogin();
		if ($usuario !== null) {
			$location = "";
			switch ($usuario->getTipo()) {
				case 'adm':
				case 'mod':
					$location = 'admin';
					break;
				case 'usr':
					$location = '';
					break;
			}
			Sessao::limpaErro();
			Sessao::limpaFormulario();
			$this->redirect($location);
		}
		$this->renderWithoutMenu('login/index');
	}
	
	public function signIn()
	{
		extract($_POST);
		$usuario = UsuarioQuery::create()->findOneByEmail($email);
		
		if (!empty($usuario)) {
			if (password_verify($senha, $usuario->getSenha())) {
				$location = "";
				switch ($usuario->getTipo()) {
					case 'adm':
					case 'mod':
						$location = 'admin';
						break;
					case 'usr':
						break;
				}
				Sessao::gravaLogin($usuario);
				Sessao::limpaErro();
				Sessao::limpaFormulario();
				$this->redirect($location);
			}
		}
		
		Sessao::gravaErro("Login ou senha inválidos.");
		Sessao::gravaFormulario('LoginController', 'index', compact(['email', 'senha']));
		$this->redirect('login');
	}
	
	public function cadastro()
	{
		$comunidades = ComunidadeQuery::create()->find();
		$this->setViewParam('comunidades', $comunidades);
		$this->renderWithoutMenu('login/signup');
	}
	
	public function signUp()
	{
		extract($_POST);
		$usuario = UsuarioQuery::create()->findOneByEmail($email);
		
		if (empty($usuario)) {
			$newUsuario = new Usuario();
			$newUsuario->setNome($nome);
			$newUsuario->setEmail($email);
			$newUsuario->setTelefone($telefone);
			$newUsuario->setIdcomunidade($idComunidade);
			$newUsuario->setSenha(password_hash($senha, PASSWORD_BCRYPT));
			$newUsuario->save();
			
			Sessao::gravaLogin($newUsuario);
			Sessao::limpaErro();
			Sessao::limpaFormulario();
			$this->redirect('dashboard');
		}
		
		Sessao::gravaErro("Este e-mail já está cadastrado em nosso sistema.");
		Sessao::gravaFormulario('LoginController', 'index', compact(['email', 'senha']));
		$this->redirect('login');
	}
	
	public function signOut()
	{
		Sessao::limpaLogin();
		$this->redirect('login');
	}
}
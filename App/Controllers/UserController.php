<?php


namespace App\Controllers;


use App\Lib\Imagem;
use App\Lib\Sessao;
use App\Models\ComunidadeQuery;
use App\Models\Usuario;
use App\Models\UsuarioQuery;

class UserController extends Controller
{
	public function index($tipo = null)
	{
		if (!$this->verifyAccess('adm')) {
			Sessao::limpaErro();
			Sessao::limpaMensagem();
			Sessao::limpaFormulario();
			$this->redirect('');
		}
		
		$s = $_GET['s'] ?? '';
		$p = $_GET['p'] ?? 1;
		
		if (!is_null($tipo)) {
			$usuarios = UsuarioQuery::create()
				->where('Usuario.nome LIKE ?', "%{$s}%")
				->_or()
				->where('Usuario.email LIKE ?', "%{$s}%")
				->filterByTipo($tipo)
				->paginate($p, 15);
		} else {
			$usuarios = UsuarioQuery::create()
				->where('id <> ?', Sessao::retornaLogin()->getId())
				->_and()
				->where('Usuario.nome LIKE ?', "%{$s}%")
				->_or()
				->where('Usuario.email LIKE ?', "%{$s}%")
				->find();
		}
		$types = [
			'adm' => '<span class="py-1 px-2 rounded-sm bg-red-400 text-white">ADMINISTRADOR</span>',
			'mod' => '<span class="py-1 px-2 rounded-sm bg-black text-white">MODERADOR</span>',
			'adm' => '<span class="py-1 px-2 rounded-sm bg-blue-400 text-white">USUÁRIO</span>',
		];
		
		$this->setViewParam('usuarios', $usuarios);
		$this->setViewParam('tipos', $types);
		$this->setViewParam('s', $s);
		$this->setViewParam('p', $p);
		$this->render('admin/user/index', 'admin');
	}
	
	public function moderator()
	{
		$this->index('mod');
	}
	
	public function admin()
	{
		$this->index('adm');
	}
	
	public function user()
	{
		$this->index('usr');
	}
	
	public function block($id)
	{
		try {
			
			if (!$this->verifyAccess('adm'))
				$this->redirect('');
			
			$usuario = UsuarioQuery::create()->findPk($id);
			$usuario->setStatus(0)->save();
			
			Sessao::gravaMensagem("Usuário {$usuario->getNome()} bloqueado.");
			$this->redirect('admin');
		} catch (\Exception $e) {
			Sessao::gravaErro("Falha ao bloquear usuário, entre em contato com o suporte.");
			$this->redirect('admin');
		}
	}
	
	public function unlock($id)
	{
		try {
			
			if (!$this->verifyAccess('adm'))
				$this->redirect('');
			
			$usuario = UsuarioQuery::create()->findPk($id);
			$usuario->setStatus(1)->save();
			
			Sessao::gravaMensagem("Usuário {$usuario->getNome()} desbloqueado.");
			$this->redirect('admin');
		} catch (\Exception $e) {
			Sessao::gravaErro("Falha ao desbloquear usuário, entre em contato com o suporte.");
			$this->redirect('admin');
		}
	}
	
	public function show($id)
	{
		if (!$this->verifyAccess('adm')) {
			Sessao::limpaErro();
			Sessao::limpaMensagem();
			Sessao::limpaFormulario();
			$this->redirect('');
		}
		
		$usuario = UsuarioQuery::create()->findPk($id);
		$comunidades = ComunidadeQuery::create()->find();
		$this->setViewParam('usuario', $usuario);
		$this->setViewParam('comunidades', $comunidades);
		
		$this->render('admin/user/show', 'admin');
	}
	
	public function update($id)
	{
		extract($_POST);
		$usuario = UsuarioQuery::create()->findPk($id);
		$emailExist = UsuarioQuery::create()->findOneByEmail($email);
		$emailExist = (empty($emailExist) or $emailExist->getId() == $id) ? false : true;
		
		if ($emailExist) {
			Sessao::gravaErro("O e-mail {$email} ja está cadastrado em nosso sistema.");
			Sessao::gravaFormulario("UserController", "show", $_POST);
			$this->redirect($tipo == 'profile' ? "user/profile" : "user/show/{$id}");
		}
		
		$usuario->setNome($nome);
		$usuario->setEmail($email);
		$usuario->setTelefone($telefone);
		
		if (isset($idComunidade))
			$usuario->setIdComunidade($idComunidade);
		
		if (isset($senha) and !empty($senha))
			$usuario->setSenha(password_hash($senha, PASSWORD_BCRYPT));
		
		if (isset($_FILES['foto']) and !empty($_FILES['foto']['name'])) {
			if (empty($_FILES['foto']['tmp_name'])) {
				Sessao::gravaErro("Arquivo não suportado ou muito grande.");
				Sessao::gravaFormulario("UserController", "show", $_POST);
				$this->redirect($tipo == 'profile' ? "user/profile" : "user/show/{$id}");
			} else {
				$img = Imagem::resize(
					$_FILES['foto']['tmp_name'],
					[
						'encodeType' => Imagem::ENCODE_TYPE_FILE,
						'type' => $_FILES['foto']['type'],
						'photoPath' => dirname(__DIR__, 2) . '/public/img/profile/',
						'iconPath' => dirname(__DIR__, 2) . '/public/img/profile/icon/',
					]
				);
				$usuario->setFoto($img);
			}
		}
		
		$usuario->save();
		Sessao::gravaLogin($usuario);
		
		Sessao::gravaMensagem($tipo == 'profile' ? 'Perfil atualizado.' : 'Usuário editado com sucesso.');
		$this->redirect($tipo == 'profile' ? "user/profile" : "user/{$tipo}");
	}
	
	public function create($type)
	{
		if (!$this->verifyAccess('adm')) {
			Sessao::limpaErro();
			Sessao::limpaMensagem();
			Sessao::limpaFormulario();
			$this->redirect('');
		}
		
		$comunidades = ComunidadeQuery::create()->find();
		$this->setViewParam('tipo', $type);
		$this->setViewParam('comunidades', $comunidades);
		$this->render('admin/user/create', 'admin');
	}
	
	public function store()
	{
		extract($_POST);
		
		$emailExist = UsuarioQuery::create()->findOneByEmail($email);
		$emailExist = (empty($emailExist)) ? false : true;
		
		if ($emailExist) {
			Sessao::gravaErro("O e-mail {$email} ja está cadastrado em nosso sistema.");
			Sessao::gravaFormulario("UserController", "cadastro", $_POST);
			$this->redirect("user/create/{$tipo}");
		}
		
		$tipos = ['moderator' => 'mod', 'admin' => 'adm', 'user' => 'usr'];
		
		$usuario = new Usuario();
		$usuario->setNome($nome);
		$usuario->setIdcomunidade($idComunidade);
		$usuario->setTelefone($telefone);
		$usuario->setEmail($email);
		$usuario->setTipo($tipos[$tipo]);
		$usuario->setSenha(password_hash($senha, PASSWORD_BCRYPT));
		
		$usuario->save();
		
		Sessao::gravaMensagem('Usuário cadastrado com êxito.');
		Sessao::limpaFormulario();
		Sessao::limpaErro();
		$this->redirect("user/{$tipo}");
	}
	
	public function profile()
	{
		$usuario = Sessao::retornaLogin();
		
		$this->setViewParam('usuario', $usuario);
		$this->render('admin/user/profile', 'admin');
	}
}
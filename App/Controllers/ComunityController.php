<?php


namespace App\Controllers;

use App\Lib\Sessao;
use App\Models\CidadeQuery;
use App\Models\Comunidade;
use App\Models\ComunidadeQuery;

class ComunityController extends Controller
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
		
		$comunidades = ComunidadeQuery::create()
			->where('Comunidade.nome LIKE ?', "%{$s}%")
			->paginate($p, 15);
			
		$this->setViewParam('comunidades', $comunidades);
		$this->setViewParam('s', $s);
		$this->setViewParam('p', $p);
		$this->render('admin/comunity/index', 'admin');
	}
	
	public function show($id)
	{
		if (!$this->verifyAccess('adm')) {
			Sessao::limpaErro();
			Sessao::limpaMensagem();
			Sessao::limpaFormulario();
			$this->redirect('');
		}
		
		$comunidade = ComunidadeQuery::create()->findPk($id);
		$cidades = CidadeQuery::create()->find();
		$this->setViewParam('comunidade', $comunidade);
		$this->setViewParam('cidades', $cidades);
		
		$this->render('admin/comunity/show', 'admin');
	}
	
	public function update($id)
	{
		extract($_POST);
		$comunidade = ComunidadeQuery::create()->findPk($id);
		$comunidadeExist = ComunidadeQuery::create()->findOneByNomeAndIdCidade($nome, $idCidade);
		$comunidadeExist = (empty($comunidadeExist) or $comunidadeExist->getId() == $id) ? false : true;
		
		if ($comunidadeExist) {
			Sessao::gravaErro("A comunidade {$nome} ja está cadastrada em nosso sistema.");
			Sessao::gravaFormulario("ComunityController", "edicao", $_POST);
			$this->redirect("comunity/show/{$id}");
		}
		
		$comunidade->setNome($nome);
		$comunidade->setIdcidade($idCidade);
		$comunidade->save();
		
		Sessao::gravaMensagem('Comunidade editada com sucesso.');
		$this->redirect('comunity');
	}
	
	public function create()
	{
		if (!$this->verifyAccess('adm')) {
			Sessao::limpaErro();
			Sessao::limpaMensagem();
			Sessao::limpaFormulario();
			$this->redirect('');
		}
		
		$cidades = CidadeQuery::create()->find();
		$this->setViewParam('cidades', $cidades);
		$this->render('admin/comunity/create', 'admin');
	}
	
	public function store()
	{
		extract($_POST);
		
		$comunidade = new Comunidade();
		$comunidade->setNome($nome);
		$comunidade->setIdcidade($idCidade);
		$comunidade->save();
		
		Sessao::gravaMensagem('Comunidade cadastrada com êxito.');
		Sessao::limpaErro();
		Sessao::limpaFormulario();
		$this->redirect('comunity');
	}
}
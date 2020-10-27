<?php


namespace App\Controllers;

use App\Lib\Sessao;
use App\Models\CidadeQuery;
use App\Models\CategoriaPost;
use App\Models\CategoriaPostQuery;
use App\Models\CategoriaReport;
use App\Models\CategoriaReportQuery;

class CategoryController extends Controller
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
		
		if ($tipo === 'post')
			$categorias = CategoriaPostQuery::create()
				->where('CategoriaPost.nome LIKE ?', "%{$s}%")
				->paginate($p, 15);
		else
			$categorias = CategoriaReportQuery::create()
				->where('CategoriaReport.nome LIKE ?', "%{$s}%")
				->paginate($p, 15);
			
		$this->setViewParam('categorias', $categorias);
		$this->setViewParam('s', $s);
		$this->setViewParam('p', $p);
		$this->render('admin/category/index', 'admin');
	}
	
	public function post()
	{
		$this->index('post');
	}
	
	public function report()
	{
		$this->index('report');
	}
	
	public function show($tipo, $id)
	{
		if (!$this->verifyAccess('adm')) {
			Sessao::limpaErro();
			Sessao::limpaMensagem();
			Sessao::limpaFormulario();
			$this->redirect('');
		}
		
		$categoria = $tipo === 'post' ? CategoriaPostQuery::create()->findPk($id) : CategoriaReportQuery::create()
			->findPk($id);
		$this->setViewParam('categoria', $categoria);
		
		$this->render('admin/category/show', 'admin');
	}
	
	public function update($id)
	{
		extract($_POST);
		if ($tipo === 'post') {
			$categoria = CategoriaPostQuery::create()->findPk($id);
			$categoriaExist = CategoriaPostQuery::create()->findOneByNome($nome);
		} else {
			$categoria = CategoriaReportQuery::create()->findPk($id);
			$categoriaExist = CategoriaReportQuery::create()->findOneByNome($nome);
		}
		$categoriaExist = (empty($categoriaExist) or $categoriaExist->getId() == $id) ? false : true;
		
		if ($categoriaExist) {
			Sessao::gravaErro("A categoria {$nome} ja está cadastrada em nosso sistema.");
			Sessao::gravaFormulario("CategoryController", "edicao", $_POST);
			$this->redirect("category/show/{$id}");
		}
		
		$categoria->setNome($nome);
		$categoria->setDescricao($descricao);
		$categoria->save();
		
		Sessao::gravaMensagem('Categoria editada com sucesso.');
		$this->redirect("category/{$tipo}");
	}
	
	public function create()
	{
		if (!$this->verifyAccess('adm')) {
			Sessao::limpaErro();
			Sessao::limpaMensagem();
			Sessao::limpaFormulario();
			$this->redirect('');
		}
		
		$this->render('admin/category/create', 'admin');
	}
	
	public function store()
	{
		extract($_POST);
		
		$categoria = $tipo = $tipo === 'post' ? new CategoriaPost() : new CategoriaReport();
		$categoria->setNome($nome);
		$categoria->setDescricao($descricao);
		$categoria->save();
		
		Sessao::gravaMensagem('Categoria cadastrada com êxito.');
		Sessao::limpaErro();
		Sessao::limpaFormulario();
		$this->redirect("category/{$tipo}");
	}
}
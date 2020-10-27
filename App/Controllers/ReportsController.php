<?php


namespace App\Controllers;


use App\Lib\Sessao;
use App\Models\PostQuery;
use App\Models\UsuarioQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class ReportsController extends Controller
{
	public function views()
	{
		$s = $_GET['s'] ?? '';
		$p = $_GET['p'] ?? 1;
		
		$posts = PostQuery::create()
			->where('Post.titulo LIKE ?', "%{$s}%")
			->orderByVisualizacoes(Criteria::DESC)
			->paginate($p, 15);
		
		foreach ($posts as $post) {
			$usuarios[$post->getId()] = UsuarioQuery::create()->findOneById($post->getIdusuario());
		}
		
		$this->setViewParam('posts', $posts);
		$this->setViewParam('usuarios', $usuarios);
		$this->setViewParam('s', $s);
		$this->setViewParam('p', $p);
		
		$this->render('admin/reports/views', Sessao::retornaLogin()->getTipo() === 'adm' ? 'admin' : 'moderator');
	}
}
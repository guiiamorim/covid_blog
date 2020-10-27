<?php


namespace App\Controllers;


use App\Models\PostQuery;
use App\Models\UsuarioQuery;

class BlogController extends Controller
{
	public function index()
	{
		$pagination = PostQuery::create()->where('post.status = ?', 'AGUARDANDO')->paginate($_POST['p'] ?? 1, 20);
		if (isset($_POST['json'])) {
			echo $pagination->getResults()->toJSON(false);
			return;
		}
		
		$this->setViewParam('pagination', $pagination);
		$this->render('blog/index', 'blog');
	}
}
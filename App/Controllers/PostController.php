<?php


namespace App\Controllers;


use App\Lib\Sessao;
use App\Models\CategoriaPostQuery;
use App\Models\Post;
use App\Models\PostCategoria;
use App\Models\PostQuery;
use App\Models\PostTags;
use App\Models\PostTagsQuery;
use App\Models\TagsQuery;
use Intervention\Image\ImageManagerStatic as Image;
use Propel\Runtime\ActiveQuery\Criteria;

class PostController extends Controller
{
	public function index($id)
	{
		$this->setViewParam('post', PostQuery::create()->findOneById($id));
		$this->render('blog/post/index', 'blog');
	}
	
	public function create()
	{
		if ($this->verifyAccess()) {
			$this->setViewParam('categorias', CategoriaPostQuery::create()->find());
			$this->render('blog/post/create', 'blog');
		}
	}
	
	public function store()
	{
		extract($_POST);
		
		$post = new Post();
		$post->setIdusuario(Sessao::retornaLogin()->getId());
		$post->setTitulo($titulo);
		$post->setTexto($texto);
		
		if (isset($_FILES['capa']) and !empty($_FILES['capa']['name'])) {
			$ext = explode('.', $_FILES['capa']['name']);
			$fileName = 'image_' . date('YmdHisu') . hexdec(bin2hex(openssl_random_pseudo_bytes(2))) . '.' .
				array_pop($ext);
			$img = Image::make($_FILES['capa']['tmp_name'])->widen(800, function ($constraint) {
				$constraint->upsize();
			})->save("public/img/posts/{$fileName}");
			$post->setCapa($fileName);
		}
		
		$post->save();
		
		foreach ($tags as $tag) {
			$tag = TagsQuery::create()->findOneById($tag);
			$postTag = new PostTags();
			$postTag->setIdpost($post->getId());
			$postTag->setIdtag($tag->getId());
			$postTag->save();
			$post->addPostTagsRelatedByIdpost($postTag);
		}
		
		foreach ($categorias as $categoria) {
			$categoria = CategoriaPostQuery::create()->findOneById($categoria);
			$postCategoria = new PostCategoria();
			$postCategoria->setIdpost($post->getId());
			$postCategoria->setIdcategoria($categoria->getId());
			$postCategoria->save();
			$post->addPostCategoria($postCategoria);
		}
		
		http_response_code(200);
		echo json_encode($post->toArray());
	}
	
	public function edit($post)
	{
		$post = PostQuery::create()->findOneById($post);
		$tags = TagsQuery::create()->filterByPrimaryKeys(array_map(fn($pt) => $pt->getIdTag(), PostTagsQuery::create
		()->filterByIdpost($post->getId())->find()->getData()))->find()->getData();
		$catP = $post->getPostCategoriasJoinCategoriaPost()->getData();
		$categorias = CategoriaPostQuery::create()->find();
		
		$this->setViewParam('post', $post);
		$this->setViewParam('tags', $tags);
		$this->setViewParam('catP', $catP);
		$this->setViewParam('categorias', $categorias);
		
		$this->render('blog/post/edit', 'blog');
	}
	
	public function update()
	{
		extract($_POST);
		
		$post = PostQuery::create()->findOneById($id);
		$post->setTitulo($titulo);
		$post->setTexto($texto);
		
		if (isset($_FILES['capa']) and !empty($_FILES['capa']['name'])) {
			$ext = explode('.', $_FILES['capa']['name']);
			$fileName = 'image_' . date('YmdHisu') . hexdec(bin2hex(openssl_random_pseudo_bytes(2))) . '.' .
				array_pop($ext);
			$img = Image::make($_FILES['capa']['tmp_name'])->widen(800, function ($constraint) {
				$constraint->upsize();
			})->save("public/img/posts/{$fileName}");
			$post->setCapa($fileName);
		}
		
		$post->save();
		
		foreach ($tags as $tag) {
			if (empty(array_filter($post->getPostTagssRelatedByIdpost()->getData(), fn($t) => $t->getIdTag() === intval($tag)))) {
				$tag = TagsQuery::create()->findOneById($tag);
				$postTag = new PostTags();
				$postTag->setIdpost($post->getId());
				$postTag->setIdtag($tag->getId());
				$postTag->save();
				$post->addPostTagsRelatedByIdpost($postTag);
			}
		}
		
		foreach ($categorias as $categoria) {
			if (empty(array_filter($post->getPostCategorias()->getData(), fn($c) => $c->getIdCategoria() === intval
				($categoria)))) {
				$categoria = CategoriaPostQuery::create()->findOneById($categoria);
				$postCategoria = new PostCategoria();
				$postCategoria->setIdpost($post->getId());
				$postCategoria->setIdcategoria($categoria->getId());
				$postCategoria->save();
				$post->addPostCategoria($postCategoria);
			}
		}
		
		http_response_code(200);
		echo json_encode($post->toArray());
	}
	
	public function myPosts()
	{
		$usuario = Sessao::retornaLogin();
		
		$posts = PostQuery::create()->findByIdusuario($usuario->getId());
		$tags = [];
		
		foreach ($posts as $post) {
			$tags[$post->getId()] = TagsQuery::create()->filterByPrimaryKeys(array_map(fn($pt) => $pt->getIdTag(), PostTagsQuery::create
			()->filterByIdpost($post->getId())->find()->getData()))->find()->getData();
		}
		
		$this->setViewParam('posts', $posts);
		$this->setViewParam('tags', $tags);
		$this->render('blog/post/myposts', 'blog');
	}
}
<?php


namespace App\Controllers;


use App\Lib\Sessao;
use App\Models\CidadeQuery;

class AdminController extends Controller
{
	public function index()
	{
		if (!$this->verifyAccess('adm') and !$this->verifyAccess('mod')) {
			$this->redirect('');
			return;
		}
		
		$this->render('admin/index', Sessao::retornaLogin()->getTipo() === 'adm' ? 'admin' : 'moderator');
	}
	
	public function cidades($uf)
	{
		$cidades = CidadeQuery::create()->findByUf($uf);
		$cidadesJson = [];
		
		foreach ($cidades as $cidade) {
			$cidadesJson[] = (object) ['nome' => $cidade->getNome(), 'id' => $cidade->getId()];
		}
		
		echo json_encode($cidadesJson);
	}
}
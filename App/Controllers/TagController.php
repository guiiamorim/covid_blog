<?php


namespace App\Controllers;


use App\Models\Tags;
use App\Models\TagsQuery;

class TagController extends Controller
{
	public function store()
	{
		if (!empty($_POST['element']) and $this->verifyAccess()) {
			$tag = new Tags();
			$tag->setNome($_POST['element']);
			$tag->save();
			
			echo json_encode($tag->toArray());
		}
	}
	
	public function list()
	{
		echo TagsQuery::create()->find()->toJson(false);
	}
}
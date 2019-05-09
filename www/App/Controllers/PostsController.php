<?php

namespace App\Controllers;

class PostsController
{
	public function index()
	{
		echo 'Tous les posts sont ici !';
		require 'App/Views/Posts/index.php';
		//$params = [];
		//$view = new \App\Views\Posts\Index();
		//$view->render($params);
	}

	public function show($id)
	{
		echo "Voici l'article $id";
	}

}

<?php

namespace App\Controllers;

class PostsController
{
	public function index()
	{
		echo 'Tous les posts sont ici !';
	}

	public function show($id)
	{
		echo "Voici l'article $id";
	}

}

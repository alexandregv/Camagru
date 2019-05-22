<?php

namespace App\Controllers;

class PostsController extends Controller
{
	public function index()
	{
		$this->posts = \App\Models\Post::getAll();
		$this->render('Posts#index');
	}

	//public function show($id)
	//{
	//	$this->render('Posts#show');
	//}
		
}

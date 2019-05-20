<?php

namespace App\Controllers;

class PostsController extends Controller
{
	public function index()
	{
		var_dump(\App\Models\Post::getAll());exit;
		$this->render('Posts#index');
	}

	//public function show($id)
	//{
	//	$this->render('Posts#show');
	//}
		
}

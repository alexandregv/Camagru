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

	public function user($user)
	{
		//$creator_id  = array_values(\App\Models\User::getBy('username', $user, 1))[0]->getId();
		$user = \App\Models\User::getBy('username', $user, 1);
		if ($user == false)
		{
			$this->redirect('Posts#index'); //TODO: flasm message --> redir Posts#index ?
			//$this->errors[] = 'user_not_found';
			//$this->render('Posts#user');
		}
		else
		{
			$creator_id  = array_values($user)[0]->getId();
			$this->posts = \App\Models\Post::getBy('creator_id', $creator_id);
			$this->render('Posts#user');
		}
	}

}

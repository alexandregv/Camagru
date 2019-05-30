<?php

namespace App\Controllers;
use \App\Facades\Query;
use \App\Models\{Post, User, Like, Comment};

class PostsController extends Controller
{
	public function index()
	{
		$this->posts = Post::getAll();
		$this->render('Posts#index');
	}

	public function show($id)
	{
		$this->post = Post::get($id);
		$this->likes_count = count(Like::getBy(['post_id' => $id]));
		$this->comments = Comment::getBy(['post_id' => $id]);
		$this->render('Posts#show');
	}

	public function user($user)
	{
		$user = User::getBy(['username' => $user], 1);
		if ($user == false)
		{
			$this->router->redirect('Posts#index'); //TODO: flasm message --> redir Posts#index ?
			//$this->errors[] = 'user_not_found';
			//$this->render('Posts#user');
		}
		else
		{
			$creator_id  = array_values($user)[0]->getId();
			$this->posts = Post::getBy(['creator_id' => $creator_id]);
			$this->render('Posts#user');
		}
	}
	
	public function trending()
	{
		$datas = Query::select('id', 'post_id')->from('likes')->orderBy('createdAt', 'desc')->limit(3)->fetchAll();
		if ($datas === false)
			return;

		$likes = [];
		foreach ($datas as $data)
		{
			$data = array_map('htmlspecialchars', $data);
			$likes[$data['id']] = new Like($data);
		}
		
		$this->posts = [];
		foreach ($likes as $like)
			$this->posts[] = Post::get($like->getPost_id());
		$this->render('Posts#trending');
	}

	public function favs()
	{
		$likes = Like::getBy(['author_id' => $_SESSION['id']]);
		$this->posts = [];
		foreach ($likes as $like)
		{
			$post = $like->getPost();
			//$likes_count = count(Like::getBy('post_id', $post->getId()));
			//$post->setLikesCount($likes_count);
			$this->posts[] = $post;
		}
		$this->render('Posts#favs');
	}
}

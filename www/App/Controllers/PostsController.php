<?php

namespace App\Controllers;

class PostsController extends Controller
{
	public function index()
	{
		$this->posts = \App\Models\Post::getAll();
		$this->render('Posts#index');
	}

	public function show($id)
	{
		$this->post = \App\Models\Post::get($id);
		$this->likes_count = count(\App\Models\Like::getBy('post_id', $id));
		$this->comments = \App\Models\Comment::getBy('post_id', $id);
		$this->render('Posts#show');
	}

	public function user($user)
	{
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
	
	public function trending()
	{
		$datas = \App\Database::getInstance()->query("SELECT id, post_id FROM likes ORDER BY createdAt DESC LIMIT 3", []);
		if ($datas === false)
			return;

		$likes = [];
		foreach ($datas as $data)
		{
			$data = array_map('htmlspecialchars', $data);
			$likes[$data['id']] = new \App\Models\Like($data);
		}
		
		$this->posts = [];
		foreach ($likes as $like)
			$this->posts[] = \App\Models\Post::get($like->getPost_id());
		$this->render('Posts#trending');
	}

	public function favs()
	{
		$likes = \App\Models\Like::getBy('author_id', $_SESSION['id']);
		foreach ($likes as $like)
		{
			$post = $like->getPost();
			//$likes_count = count(\App\Models\Like::getBy('post_id', $post->getId()));
			//$post->setLikesCount($likes_count);
			$this->posts[] = $post;
		}
		$this->render('Posts#favs');
	}
}

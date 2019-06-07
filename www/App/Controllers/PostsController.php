<?php

namespace App\Controllers;
use \App\Facades\Query;
use \App\Models\{Post, User, Like, Comment};
use \App\Database;

class PostsController extends Controller
{
	public function index()
	{
		$this->page = $_GET['page'] ?? 1;
		$this->pages_count = ceil(count(Post::getAll()) / 6);

		if ($this->page == 0 || $this->page > $this->pages_count)
			$this->page = 1;

		$datas = Query::select('*')->from('posts')->orderBy('createdAt', 'DESC')->limit(6)->offset($this->page * 6 - 6)->fetchAll();
		$this->posts = [];
		foreach ($datas as $data)
			$this->posts[] = new Post(array_map('htmlspecialchars', $data));

		return $this->render('Posts#index');
	}

	public function show(int $id)
	{
		$this->post = Post::get($id);
		$this->likes_count = count(Like::getBy(['post_id' => $id]));
		$this->comments = Comment::getBy(['post_id' => $id]);
		return $this->render('Posts#show');
	}

	public function user(string $user)
	{
		$user = User::getBy(['username' => $user], 1);
		if ($user == false)
		{
			\App\Helpers::flash('danger', 'Utilisateur introuvable');
			return $this->router->redirect('Posts#index');
		}
		else
		{
			$creator_id  = array_values($user)[0]->getId();
			$this->posts = Post::getBy(['creator_id' => $creator_id]);
			return $this->render('Posts#user');
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
		return $this->render('Posts#trending');
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
		return $this->render('Posts#favs');
	}

	public function like(int $id)
	{
		$db = 
		$post = Post::get($id);
		if ($post == false)
			return 'error';
		$like = Query::select('id')->from('likes')->where("post_id = $id")->where("author_id = {$_SESSION['id']}")->fetch();
		if ($like == false)
			Database::getInstance()->query("INSERT INTO `likes` (`post_id`, `author_id`) VALUES (:post_id, :author_id)", ['post_id' => $id, 'author_id' => $_SESSION['id']], 0);
		return $this->router->redirect('Posts#show', ['id' => $id]);
	}
}

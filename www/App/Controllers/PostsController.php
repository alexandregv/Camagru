<?php

namespace App\Controllers;
use \App\Facades\Query;
use \App\Models\{Post, User, Like, Comment};
use \App\{Database, Helpers};

class PostsController extends Controller
{
	public function index()
	{
		$this->page = $_GET['page'] ?? 1;
		$this->pages_count = ceil(count(Post::getAll()) / 6);

		if ($this->page == 0)
			$this->page = 1;
		else if ($this->page > $this->pages_count)
			$this->page = $this->pages_count;

		$datas = Query::select('*')->from('posts')->orderBy('createdAt', 'DESC')->limit(6)->offset($this->page * 6 - 6)->fetchAll();
		$this->posts = [];
		foreach ($datas as $data)
			$this->posts[] = new Post(array_map('htmlspecialchars', $data));

		return $this->render('Posts#index');
	}

	public function show(int $id)
	{
		$this->post = Post::get($id);
		if ($this->post == false)
		{
			\App\Helpers::flash('danger', 'Publication introuvable');
			return $this->router->redirect('Posts#index');
		}
		$this->likes_count = count(Like::getBy(['post_id' => $id]));
		$this->comments = Comment::getBy(['post_id' => $id]);
		return $this->render('Posts#show');
	}

	public function user(string $user)
	{
		$this->username = $user;
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

			$this->page = $_GET['page'] ?? 1;
			$this->pages_count = ceil(count($this->posts) / 6);

			if ($this->page == 0)
				$this->page = 1;
			else if ($this->page > $this->pages_count)
				$this->page = $this->pages_count;

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

		$this->page = $_GET['page'] ?? 1;
		$this->pages_count = ceil(count($this->posts) / 6);
		if ($this->page == 0)
			$this->page = 1;
		else if ($this->page > $this->pages_count)
			$this->page = $this->pages_count;

		return $this->render('Posts#favs');
	}

	public function like(int $id)
	{
		$post = Post::get($id);
		if ($post == false)
			return $this->router->redirect('Posts#index');
		$like = Query::select('id')->from('likes')->where("post_id = $id")->where("author_id = {$_SESSION['id']}")->fetch();
		if ($like == false)
		{
			$liker = User::get($_SESSION['id'])->getUsername();
			Database::getInstance()->query("INSERT INTO `likes` (`post_id`, `author_id`) VALUES (:post_id, :author_id)", ['post_id' => $id, 'author_id' => $_SESSION['id']], 0);
			$creator = $post->getCreator();
			if ($creator->getLikeNotifications() == 1)
				mail($creator->getEmail(), 'Someone liked your post!', "Hey, you have a fan! @$liker just liked one of your posts!");
		}
		return $this->router->redirect('Posts#show', ['id' => $id]);
	}
	
	public function new()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET')
			return $this->render('Posts#new');
		else if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if (!is_uploaded_file($_FILES['picture']['tmp_name']))
				Helpers::flash('danger', 'Attaque potentielle par téléchargement de fichiers!');
			else
			{
				$res  = Database::getInstance()->query("INSERT INTO posts (`creator_id`, `description`) VALUES ('{$_SESSION['id']}', :desc)", ['desc' => $_POST['description']], 0);
				$post = Query::select('id')->from('posts')->orderBy('id', 'DESC')->limit(1)->fetch();
				if ($res != false || $post != false)
				{	
					Helpers::flash('success', 'Post cree');
					$uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/public/assets/uploads/posts_images/';
					$uploadfile = $uploaddir . $post['id'] . '.png';
					move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile);
				}
				else
				{
					Helpers::flash('danger', 'capout :c');
					return $this->render('Posts#new');
				}
			}
			return $this->router->redirect('Posts#index');
		}
	}
}

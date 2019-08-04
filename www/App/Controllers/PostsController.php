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
		$this->likes_count = count(Like::getBy(['post_id' => $id]));
		$this->comments = Comment::getBy(['post_id' => $id]);
		$this->liked = (isset($_SESSION['id']) && Query::select('*')->from('likes')->where("post_id = $id")->where("author_id = {$_SESSION['id']}")->limit(1)->fetch(1) != false);

		$this->loggedin_mail = '';
		if (isset($_SESSION['id']))
		{
			$loggedin_user = User::get($_SESSION['id']);
			if ($loggedin_user != false)
				$this->loggedin_mail = $loggedin_user->getEmail();
		}
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
			//$this->posts = Post::getBy(['creator_id' => $creator_id]);
			$count = Query::select('COUNT(*)')->from('posts')->where("creator_id = $creator_id")->fetch()['COUNT(*)']; //TODO: :nauseated_face:

			$this->page = $_GET['page'] ?? 1;
			$this->pages_count = ceil($count / 6);
			//$this->pages_count = ceil(count($this->posts) / 6);

			if ($this->page == 0)
				$this->page = 1;
			else if ($this->page > $this->pages_count)
				$this->page = $this->pages_count;

			$datas = Query::select('*')->from('posts')->where("creator_id = $creator_id")->orderBy('createdAt', 'DESC')->limit(6)->offset($this->page * 6 - 6)->fetchAll();
			$this->posts = [];
			foreach ($datas as $data)
				$this->posts[] = new Post(array_map('htmlspecialchars', $data));

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

		$this->page = $_GET['page'] ?? 1;
		$this->pages_count = ceil(count($likes) / 6);
		if ($this->page == 0)
			$this->page = 1;
		else if ($this->page > $this->pages_count)
			$this->page = $this->pages_count;

		$this->posts = [];
		foreach ($likes as $like)
			$this->posts[] = $like->getPost();

		for($i = 0; $i < ($this->page - 1) * 6; $i++)
			array_shift($this->posts);

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
			{
				$headers = "From: \"Camagru\"<no-reply@camagru.fr>\n";
				$headers .= "Reply-To: no-repy@camagru.fr\n";
				$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
				mail($creator->getEmail(), "Vous avez un nouveau J'aime.", "Hey, vous avez un fan! <a href=\"http://localhost:8080". Helpers::route('Posts#user', ['user' => $liker]) . "\">@$liker</a> vient d'aimer une de vos <a href=\"http://localhost:8080". Helpers::route('Posts#show', ['id' => $id]) . "\">publications</a> !", $headers);
			}
		}
		else
			Database::getInstance()->query("DELETE FROM likes WHERE id = :id", ['id' => $like['id']], 0);
		return $this->router->redirect('Posts#show', ['id' => $id]);
	}
	
	public function comment(int $id)
	{
		$post = Post::get($id);
		if ($post == false)
			return $this->router->redirect('Posts#index');
		$liker = User::get($_SESSION['id'])->getUsername();
		Database::getInstance()->query("INSERT INTO `comments` (`post_id`, `author_id`, `content`) VALUES (:post_id, :author_id, :content)", ['post_id' => $id, 'author_id' => $_SESSION['id'], 'content' => $_POST['comment']], 0);
		$creator = $post->getCreator();
		if ($creator->getLikeNotifications() == 1)
		{
			$headers = "From: \"Camagru\"<no-reply@camagru.fr>\n";
			$headers .= "Reply-To: no-repy@camagru.fr\n";
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
			mail($creator->getEmail(), "Vous avez un nouveau J'aime.", "Hey, vous avez un fan! <a href=\"http://localhost:8080". Helpers::route('Posts#user', ['user' => $liker]) . "\">@$liker</a> vient de commenter une de vos <a href=\"http://localhost:8080". Helpers::route('Posts#show', ['id' => $id]) . "\">publications</a> !", $headers);
		}

		//$comment = Comment::get(26);
		$comment = Query::select('id')->from('comments')->where("post_id = $id")->where("author_id = {$_SESSION['id']}")->orderBy('createdAt', 'desc')->limit(1)->fetch();
		$comment = Comment::get($comment['id']);
		return $this->render('Posts#_comment', ['comment' => $comment]);
	}
	
	public function new()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$dir = $_SERVER['DOCUMENT_ROOT'] . '/public/assets/img/borders';
			$this->borders = array_values(array_diff(scandir($dir), array('..', '.')));
			return $this->render('Posts#new');
		}
		else if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if (1==1 || $_FILES['picture']['size'] == 0)
			{
				if (!isset($_POST['img']) || empty(trim($_POST['img'])) || !isset($_POST['border']) || empty(trim($_POST['border'])))
				{
					Helpers::flash('danger', 'Vous devez choisir une image et un cadre !');
					return $this->router->redirect('Posts#new');
				}

				$b64 = explode(',', $_POST['img'])[1];
				$res  = Database::getInstance()->query("INSERT INTO posts (`creator_id`, `description`) VALUES ('{$_SESSION['id']}', :desc)", ['desc' => $_POST['description']], 0);
				$post = Query::select('id')->from('posts')->orderBy('id', 'DESC')->limit(1)->fetch();
				if ($res != false || $post != false)
				{	
					Helpers::flash('success', 'Post créé');
					$uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/public/assets/uploads/posts_images/';
					$uploadfile = $uploaddir . $post['id'] . '.png';
					$img = @imagecreatefromstring(base64_decode($b64));

					if ($img == false)
					{
						Helpers::flash('danger', 'Ca joue les hackers ?');
						return $this->router->redirect('Posts#new');
					}

					$border = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . '/public/assets/img/borders/' . $_POST['border']);
					imagecopyresampled($img, $border, 0, 0, 0, 0, imagesx($img), imagesy($img), imagesx($border), imagesy($border));
					//imagecopy($img, $border, 0, 0, 0, 0, 800, 800);
					//imagecopymerge($img, $border, 0, 0, 0, 0, 800, 800, 50);

					$ret = imagepng($img, $uploadfile);
				}
				else
				{
					Helpers::flash('danger', 'capout :c');
					return $this->render('Posts#new');
				}
				return $this->router->redirect('Posts#show', ['id' => $post['id']]);
			}
			else
			{
				if (!is_uploaded_file($_FILES['picture']['tmp_name']))
					Helpers::flash('danger', 'Attaque potentielle par téléchargement de fichiers!');
				else
				{
					$res  = Database::getInstance()->query("INSERT INTO posts (`creator_id`, `description`) VALUES ('{$_SESSION['id']}', :desc)", ['desc' => $_POST['description']], 0);
					$post = Query::select('id')->from('posts')->orderBy('id', 'DESC')->limit(1)->fetch();
					if ($res != false || $post != false)
					{	
						Helpers::flash('success', 'Post créé');
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
	
	public function delete(int $id)
	{
		$post = Post::get($id);
		if ($post != false)
		{
			if ($post->getCreator_id() == $_SESSION['id'])
			{
				$username = User::get($post->getCreator_id())->getUsername();
				Database::getInstance()->query("DELETE FROM posts WHERE id = :id", ['id' => $id], 0);
				Database::getInstance()->query("DELETE FROM likes WHERE post_id = :post_id", ['post_id' => $id], 0);
				Database::getInstance()->query("DELETE FROM comments WHERE post_id = :post_id", ['post_id' => $id], 0);
				Helpers::flash('success', 'La publication a bien été supprimée.');
				return $this->router->redirect('Posts#user', ['user' => $username]);
			}
			else
			{
				Helpers::flash('danger', 'Vous ne pouvez pas supprimer cette publication !');
				return $this->router->redirect('Posts#show', ['id' => $post->getId()]);
			}
		}
		else
		{
			Helpers::flash('danger', 'Une erreur est survenue, publication introuvable.');
			return $this->router->redirect('Posts#index');
		}
	}
}

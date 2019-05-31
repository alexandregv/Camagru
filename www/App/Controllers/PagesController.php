<?php

namespace App\Controllers;
use \App\Facades\Query;
use \App\Models\{Post, User, Like, Comment};

class PagesController extends Controller
{
	public function home()
	{
		$this->users_count = count(User::getAll());
		$this->posts_count = count(Post::getAll());
		$this->comments_count = count(Comment::getAll());
		$this->likes_count = count(Like::getAll());
		return $this->render('Pages#home');
	}
}

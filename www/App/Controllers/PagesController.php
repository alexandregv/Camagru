<?php

namespace App\Controllers;

class PagesController extends Controller
{
	public function home()
	{
		$this->users_count = count(\App\Models\User::getAll());
		$this->posts_count = count(\App\Models\Post::getAll());
		$this->render('Pages#home');
	}
}

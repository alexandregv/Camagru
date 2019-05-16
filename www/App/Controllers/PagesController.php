<?php

namespace App\Controllers;

class PagesController extends Controller
{
	public function home()
	{
		//echo \App\Models\User::getAll();

		//print_r(new \App\Models\User([
		//	'username' => 'aguiot--',
		//	'firstname' => 'Alexandre',
		//	'lastname' => 'Guiot--Valentin'
		//]));
		$this->users_count = count(\App\Models\User::getAll());
		$this->render('Pages#home');
	}
}

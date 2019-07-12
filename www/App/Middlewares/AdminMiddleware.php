<?php

namespace App\Middlewares;
use \App\Helpers;
use \App\Models\User;
use \App\Middlewares\AuthMiddleware;

class AdminMiddleware extends Middleware
{
	public function call(string &$body)
	{
		(new AuthMiddleware($this->router->getCurrentRoute()))->call($body);
		
		$user = User::get($_SESSION['id']);
		if ($user == false || $user->getAdmin() != 1)
		{
			Helpers::flash('danger', 'Vous devez etre administrateur !');
			return $this->router->redirect('Pages#home');
		}
	}
}

?>

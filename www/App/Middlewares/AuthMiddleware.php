<?php

namespace App\Middlewares;
use \App\Helpers;

class AuthMiddleware extends Middleware
{
	public function call(string &$body)
	{
		if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
		{
			Helpers::flash('danger', 'Vous devez être connecté !');
			$_SESSION['redirect'] = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
			return $this->router->redirect('Users#login');
		}
	}
}

?>

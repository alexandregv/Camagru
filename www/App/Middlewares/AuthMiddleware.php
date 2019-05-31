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
			return $this->router->redirect('Users#login');
		}
	}
}

?>

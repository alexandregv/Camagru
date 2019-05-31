<?php

namespace App\Middlewares;
use \App\Helpers;

class AuthMiddleware extends Middleware
{
	public function call()
	{
		if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
		{
			Helpers::flash('danger', 'Vous devez être connecté !');
			$this->router->redirect('Users#login');
		}
	}
}

?>

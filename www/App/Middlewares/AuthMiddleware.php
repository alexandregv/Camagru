<?php

namespace App\Middlewares;

class AuthMiddleware extends Middleware
{
	public function call()
	{
		if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
			$this->router->redirect('Users#login');
	}
}

?>

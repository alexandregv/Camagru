<?php

namespace App\Middlewares;
use \App\Helpers;

class CsrfCheckMiddleware extends Middleware
{
	public function call(string &$body)
	{
		if (!isset($_SERVER['HTTP_REFERER']) || explode('/', $_SERVER['HTTP_REFERER'])[2] != 'localhost:8080' || !isset($_SESSION['csrf']) || !isset($_POST['csrf']) || $_POST['csrf'] != $_SESSION['csrf'])
		{
			Helpers::flash('danger', 'Ça joue les hackers ?');
			return $this->router->redirect('Pages#home');
		}
	}
}

?>

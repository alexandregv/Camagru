<?php

namespace App\Middlewares;
use \App\Helpers;

class CsrfCheckMiddleware extends Middleware
{
	public function call(string &$body)
	{
		if (/*!isset($_SERVER['HTTP_REFERER']) || explode('/', $_SERVER['HTTP_REFERER'])[2] != 'camagru.gq' || */ !isset($_SESSION['csrf']) || !isset($_POST['csrf']) || $_POST['csrf'] != $_SESSION['csrf'])
		{
			Helpers::flash('danger', 'Ça joue les hackers ?');
			return $this->router->redirect('Pages#home');
		}
		else $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(24));
	}
}

?>

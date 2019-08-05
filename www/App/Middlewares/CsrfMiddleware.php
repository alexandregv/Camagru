<?php

namespace App\Middlewares;
use \App\Helpers;

class CsrfMiddleware extends Middleware
{
	public function call(string &$body)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') // Before
		{
			if (!isset($_SERVER['HTTP_REFERER']) || explode('/', $_SERVER['HTTP_REFERER'])[2] != 'localhost:8080' || !isset($_SESSION['csrf']) || !isset($_POST['csrf']) || $_POST['csrf'] != $_SESSION['csrf'])
			{
				Helpers::flash('danger', 'Ça joue les hackers ?');
				return $this->router->redirect('Pages#home');
			}
		}
		else if ($_SERVER['REQUEST_METHOD'] == 'GET') // After
		{
			$csrf = '<input name="csrf" type="text" value="' . (isset($_SESSION['csrf']) ? $_SESSION['csrf'] : '') . '" hidden>';
			$body = preg_replace('/(^\s*<form.*>\s*$)/im', "$1\n$csrf", $body);
		}
	}
}

?>

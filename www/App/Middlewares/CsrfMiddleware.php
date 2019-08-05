<?php

namespace App\Middlewares;
use \App\Helpers;

class CsrfMiddleware extends Middleware
{
	public function call(string &$body)
	{
		//if ($body == '') // Before
		if ($_SERVER['REQUEST_METHOD'] == 'POST') // Before
		{
			if (!isset($_SESSION['csrf']) || !isset($_POST['csrf']) || $_POST['csrf'] != $_SESSION['csrf'])
			{
				Helpers::flash('danger', 'Ça joue les hackers ?');
				return $this->router->redirect('Pages#home');
			}
		}
		//else // After
		else if ($_SERVER['REQUEST_METHOD'] == 'GET') // After
		{
			$csrf = '<input name="csrf" type="text" value="' . (isset($_SESSION['csrf']) ? $_SESSION['csrf'] : '') . '" hidden>';
			$body = preg_replace('/(^\s*<form.*>\s*$)/im', "$1\n$csrf", $body);
		}
	}
}

?>

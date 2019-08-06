<?php

namespace App\Middlewares;
use \App\Helpers;

class CsrfDomMiddleware extends Middleware
{
	public function call(string &$body)
	{
		$csrf = '<input name="csrf" type="text" value="' . (isset($_SESSION['csrf']) ? $_SESSION['csrf'] : '') . '" hidden>';
		$body = preg_replace('/(^\s*<form.*>\s*$)/im', "$1\n$csrf", $body);
	}
}

?>

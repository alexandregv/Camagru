<?php

namespace App\Controllers;

class Controller
{
	public $router;

	public function __construct()
	{
		$this->router = \App\Router\Router::getInstance();
	}

	public function render($full)
	{
		$full = explode('#', $full);
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/App/Views/$full[0]/$full[1].php"))
			require "App/Views/$full[0]/$full[1].php";
		else $this->render('Errors#404');
	}

	public function __call($action, $params = [])
	{
		$controller = str_replace('Controller', '', end(explode('\\', get_class($this))));
		$this->render("$controller#$action", $params);
	}
}

?>

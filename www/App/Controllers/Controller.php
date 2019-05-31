<?php

namespace App\Controllers;

class Controller
{
	public $router;

	public function __construct()
	{
		$this->router = \App\Router\Router::getInstance();
	}

	public function render(string $full)
	{
		$full = explode('#', $full);
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/App/Views/$full[0]/$full[1].php"))
			require "App/Views/$full[0]/$full[1].php";
		else $this->render('Errors#404');
	}

	public function __call(string $action, array $params = [])
	{
		$controller = explode('\\', get_class($this));
		$controller = str_replace('Controller', '', end($controller));
		$this->render("$controller#$action", $params);
	}
}

?>

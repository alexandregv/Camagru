<?php

namespace App\Middlewares;

class Middleware
{
	public  $_router;
	private $_route = null;
	
	public function __construct(\App\Router\Route $route)
	{
		$this->router = \App\Router\Router::getInstance();
		$this->_route = $route;
	}

	public function call()
	{

	}
}

?>

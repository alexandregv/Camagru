<?php

namespace App\Router;

class Router {

	private $url;
	private $routes = [];
	private $namedRoutes = [];

	private static $_instance = null;

	private function __construct($url = null){
		if (is_null($url))
			$url = $_GET['url'];
		$this->url = $url;
	}

	public function __call(string $method, array $args): Route
	{
		$path		= $args[0];
		$action 	= $args[1];
		//$name		= $args[2] ?? $action;
		if (isset($args[2]))
			$name = $args[2];
		else
		{
			if(is_string($action))
				$name = $action;
			else
				$name = null;
		}

		$route = new Route($path, $action);
		$this->routes[strtoupper($method)][] = $route;
		if(is_string($action) && $name === null)
			$name = $action;
		if($name)
			$this->namedRoutes[$name] = $route;
		return $route;
	}	

	public function run(){
		if(!isset($this->routes[$_SERVER['REQUEST_METHOD']]))
			throw new RouterException('REQUEST_METHOD does not exist');
		foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route)
			if($route->match($this->url))
				return $route->call($this);
		
		return $this->namedRoutes['Errors#_404']->call($this);
		//throw new RouterException("No route matching '$this->url'");
	}

	public function url(string $name, array $params = []): string
	{
		if(!isset($this->namedRoutes[$name]))
			//return $this->namedRoutes['Errors#_404']->call();
			throw new RouterException("No route matches '$name'");
		return $this->namedRoutes[$name]->getUrl($params);
	}

	public function redirect(string $route, array $params = [])
	{
		header('Location: ' . $this->url($route, $params));
		exit;
	}

	public static function getInstance(string $url = null): Router
	{
		if (is_null(self::$_instance))
			self::$_instance = new Router($url);
		return self::$_instance;
	}

}

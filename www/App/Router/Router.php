<?php

namespace App\Router;

class Router {

	private $_url;
	private $_routes = [];
	private $_namedRoutes = [];
	private $_currentRoute = null;

	private static $_instance = null;

	private function __construct($_url = null){
		if (is_null($_url))
			$_url = $_GET['url'];
		$this->url = $_url;
	}

	public function getCurrentRoute()
	{
		return $this->_currentRoute;
	}

	public function setCurrentRoute(Route $route)
	{
		$this->_currentRoute = $route;
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
		$this->_routes[strtoupper($method)][] = $route;
		if(is_string($action) && $name === null)
			$name = $action;
		if($name)
			$this->_namedRoutes[$name] = $route;
		return $route;
	}	

	public function run(){
		if(!isset($this->_routes[$_SERVER['REQUEST_METHOD']]))
			throw new RouterException('REQUEST_METHOD does not exist');
		foreach($this->_routes[$_SERVER['REQUEST_METHOD']] as $route)
			if($route->match($this->url))
				return $route->call($this);
		
		return $this->_namedRoutes['Errors#_404']->call($this);
		//throw new RouterException("No route matching '$this->url'");
	}

	public function url(string $name, array $params = []): string
	{
		if(!isset($this->_namedRoutes[$name]))
			return $name;	
		return $this->_namedRoutes[$name]->getUrl($params);
	}

	public function redirect(string $route, array $params = [])
	{
		if ($this->getCurrentRoute()->getAction() == 'Users#login' && isset($_SESSION['redirect']) && !empty($_SESSION['redirect']))
		{
			$redirect = $_SESSION['redirect'];
			$_SESSION['redirect'] = '';
			header("Location: $redirect");
		}
		else
			header('Location: ' . $this->url($route, $params));
		exit;
	}

	public function getRoutes(): array
	{
		return $this->_routes;
	}

	public function getNamedRoutes(): array
	{
		return $this->_namedRoutes;
	}

	public static function getInstance(string $_url = null): Router
	{
		if (is_null(self::$_instance))
			self::$_instance = new Router($_url);
		return self::$_instance;
	}

}

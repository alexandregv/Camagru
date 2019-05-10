<?php

namespace App\Router;

class Router {

	private $url;
	private $routes = [];
	private $namedRoutes = [];

	public function __construct($url){
		$this->url = $url;
	}

	public function __call($method, $args)
	{
		$path		= $args[0];
		$callable 	= $args[1];
		$name		= $args[2];

		$route = new Route($path, $callable);
		$this->routes[strtoupper($method)][] = $route;
		if(is_string($callable) && $name === null)
			$name = $callable;
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

	public function url($name, $params = []){
		if(!isset($this->namedRoutes[$name]))
			//return $this->namedRoutes['Errors#_404']->call();
			throw new RouterException("No route matches '$name'");
		return $this->namedRoutes[$name]->getUrl($params);
	}

}

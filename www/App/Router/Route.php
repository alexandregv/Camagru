<?php

namespace App\Router;

class Route {

	private $_path;
	private $_action;
	private $_matches = [];
	private $_params = [];
	private $_middlewares = [];

	public function __construct($_path, $action)
	{
		$this->_path = trim($_path, '/');
		$this->_action = $action;
	}

	public function match($url)
	{
		$url = trim($url, '/');
		$path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->_path);
		$regex = "#^$path$#i";
		if(!preg_match($regex, $url, $matches))
			return false;
		array_shift($matches);
		$this->_matches = $matches;
		return true;
	}

	private function paramMatch($match)
	{
		if(isset($this->_params[$match[1]]))
			return '(' . $this->_params[$match[1]] . ')';
		return '([^/]+)';
	}

	public function with($param, $regex)
	{http://192.168.1.28:8080/posts/mine
		$this->_params[$param] = str_replace('(', '(?:', $regex);
		return $this;
	}

	public function middleware($middleware)
	{
		$this->_middlewares[] = $middleware;
		return $this;
	}

	public function getUrl($params)
	{
		$path = $this->_path;
		foreach($params as $k => $v)
			$path = str_replace(":$k", $v, $path);
		return '/' . $path;
	}

	public function call()
	{
		$this->call_middlewares();

		if(is_string($this->_action)){
			$params = explode('#', $this->_action);
			$controller = 'App\\Controllers\\' . $params[0] . 'Controller';
			$controller = new $controller();
			return call_user_func_array([$controller, $params[1]], $this->_matches);
		}
		else return call_user_func_array($this->_action, $this->_matches);
	}

	private function call_middlewares()
	{
		foreach ($this->_middlewares as $name)
		{
			$middleware = 'App\\Middlewares\\' . ucfirst($name) . 'Middleware';
			$middleware = new $middleware($this);
			$middleware->call();
			return $this; // temp, to keep ?	
		}
	}

}

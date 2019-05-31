<?php

namespace App\Router;

class Route {

	private $_path				= '';
	private $_action			= '';
	private $_matches			= [];
	private $_params			= [];
	private $_beforeMiddlewares	= [];
	private $_afterMiddlewares	= [];

	public function __construct(string $path, $action)
	{
		$this->_path = trim($path, '/');
		$this->_action = $action;
	}

	public function match(string $url): bool
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

	private function paramMatch(array $match): string
	{
		if(isset($this->_params[$match[1]]))
			return '(' . $this->_params[$match[1]] . ')';
		return '([^/]+)';
	}

	public function with(string $param, string $regex): Route
	{http://192.168.1.28:8080/posts/mine
		$this->_params[$param] = str_replace('(', '(?:', $regex);
		return $this;
	}

	public function middleware(string $middleware, string $order = 'before'): Route
	{
		if ($order == 'after')
			$this->_afterMiddlewares[] = $middleware;
		else
			$this->_beforeMiddlewares[] = $middleware;
		return $this;
	}

	public function getUrl(array $params): string
	{
		$path = $this->_path;
		foreach($params as $k => $v)
			$path = str_replace(":$k", $v, $path);
		return '/' . $path;
	}

	public function call()
	{
		$body = '';
		$this->callBeforeMiddlewares($body);

		if(is_string($this->_action)){
			$params = explode('#', $this->_action);
			$controller = 'App\\Controllers\\' . $params[0] . 'Controller';
			$controller = new $controller();
			$body = call_user_func_array([$controller, $params[1]], $this->_matches);
		}
		else
			$body = call_user_func_array($this->_action, $this->_matches);

		$this->callAfterMiddlewares($body);
		echo $body;
	}

	private function callBeforeMiddlewares(string &$body): Route
	{
		foreach ($this->_beforeMiddlewares as $name)
		{
			$middleware = 'App\\Middlewares\\' . ucfirst($name) . 'Middleware';
			$middleware = new $middleware($this);
			$middleware->call($body);
		}
		return $this;
	}

	private function callAfterMiddlewares(string &$body): Route
	{
		foreach ($this->_afterMiddlewares as $name)
		{
			$middleware = 'App\\Middlewares\\' . ucfirst($name) . 'Middleware';
			$middleware = new $middleware($this);
			$middleware->call($body);
		}
		return $this;
	}

}

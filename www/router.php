<?php

class Router
{
    private $url;
    private $routes = [];

	public function __construct($url)
	{
        $this->url = $url;
    }

	public function get($path, $callable)
	{
		$route = new Route($path, $callable);
		$this->routes["GET"][] = $route;
		return $route;
	}

	public function run()
	{

	}
}

?>

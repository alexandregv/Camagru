<?php

namespace App;

class Helpers
{
	const ASSETS_PATH = '/public/assets/';

	public static function asset($name, $type = null)
	{
		return self::ASSETS_PATH . ($type ?? '') . '/' . $name;
	}

	public static function image($name)
	{
		return self::asset($name, 'img');
	}

	public static function css($name)
	{
		return self::asset($name, 'css') . '.css';
	}

	public static function render($name, $vars = [])
	{
		extract($vars);
		require "App/Views/$name.php";
	}

	public static function partial($name, $vars = [])
	{
		extract($vars);
		require "App/Views/Partials/_$name.php";
	}

	public static function route($route, array $params = [])
	{
		return Router\Router::getInstance()->url($route, $params);
	}

}

?>

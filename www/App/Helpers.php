<?php

namespace App;

class Helpers
{
	const ASSETS_PATH = '/public/assets/';

	# --- Views --- #

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

	# --- Flash Message ---

	public static function has_flash()
	{
		return isset($_SESSION['flash']);
	}

	public static function flash($type = null, $message = null)
	{
		
		if ($type == null)
			return isset($_SESSION['flash']);
		else if ($message != null)
			$_SESSION['flash'] = ['type' => $type, 'message' => $message];
		else if ($type == 'type')
			return $_SESSION['flash']['type'];
		else if ($type == 'message')
			return $_SESSION['flash']['message'];
	}

	public static function clear_flash()
	{
		$_SESSION['flash'] = null;
	}

}

?>

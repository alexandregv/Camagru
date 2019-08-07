<?php

namespace App;
use \App\Router\Router;

class Helpers
{
	const ASSETS_PATH = '/public/assets/';

	# --- Views --- #

	public static function asset(string $name, string $type = null): string
	{
		return self::ASSETS_PATH . ($type ?? '') . '/' . $name;
	}

	public static function image(string $name): string
	{
		return self::asset($name, 'img');
	}

	public static function css(string $name): string
	{
		return self::asset($name, 'css') . '.css';
	}

	public static function render(string $name, array $vars = [])
	{
		extract($vars);
		require "App/Views/$name.html.php";
	}

	public static function partial(string $name, array $vars = [])
	{
		extract($vars);
		require "App/Views/Partials/_$name.html.php";
	}

	public static function route(string $route, array $params = []): string
	{
		return Router::getInstance()->url($route, $params);
	}

	public static function date($date): string
	{
		return strftime('%Hh%M', strtotime($date)) . ' - ' . ucwords(strftime('%A %d %B', strtotime($date)));
	}

	public static function parse($text)
	{
		$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
		$tagp = '~#([a-zA-z0-9]+)~i';
		$tagu = '~@([a-zA-z0-9-_]+)~i';
		$formatted = $text ;
		$formatted = preg_replace($url, '<a href="$0" target="_blank" title="$2">$2</a>', $formatted);
		$formatted = preg_replace($tagu, '<a href="' . Helpers::route('Posts#show', ['id' => '$1']) . '" title="$1">$0</a>', $formatted);
		$formatted = preg_replace($tagp, '<a href="' . Helpers::route('Posts#user', ['user' => '$1']) . '" title="$1">$0</a>', $formatted);
		return $formatted;
	}

	# --- Flash Message ---

	public static function has_flash(): bool
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

	# --- Active navbar ---

	public static function active(string $action)
	{
		return $action == Router::getInstance()->getCurrentRoute()->getAction() ? 'is-active' : '';
	}

}

?>

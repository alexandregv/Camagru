<?php

namespace App;

class Helpers
{
	const ASSETS_PATH = 'public/assets/';

	public function asset($name, $type = null)
	{
		return self::ASSETS_PATH . ($type ?? '') . '/' . $name;
	}

	public function image($name)
	{
		return self::asset($name, 'img');
	}

	public function css($name)
	{
		return self::asset($name, 'css') . '.css';
	}
}

?>

<?php

namespace App\Models;

class Model
{
	public static function get($id)
	{
		$model = explode('\\', get_called_class());
		$model = end($model);
		$data = \App\Database::getInstance()->query("SELECT * FROM {$model}s WHERE id = '$id' LIMIT 1", [], 1);
		$kwargs = [];
		foreach ($data as $k => $v)
			$kwargs[$k] = $v;
		$model = get_called_class();
		return new $model($kwargs);
	}
	
	public static function getAll()
	{
		$db = \App\Database::getInstance();
		$model = explode('\\', get_called_class());
		$model = end($model);
		return $db->query("SELECT * FROM {$model}s", []);
	}

	public function __call($method, $params)
	{
		$var = lcfirst(substr($method, 3));

		if (strncasecmp($method, "get", 3) === 0)
		{
			if (isset($this->$var))
				return $this->$var;
			else if (isset($this->{"_$var"}))
				return $this->{"_$var"};
			else
				throw new \Exception("Unknown model property $$k.");

		}
		else if (strncasecmp($method, "set", 3) === 0)
		{
			if (isset($this->$var))
				$this->$var = $params[0];
			else if (isset($this->{"_$var"}))
				$this->{"_$var"} = $params[0];
			else
				throw new \Exception("Unknown model property $$k.");

		}
	}

	public function __construct(array $kwargs)
	{
		foreach ($kwargs as $k => $v)
		{
			if (isset($this->$k))
				self::{'set' . ucfirst($k)}($v);
			else if (isset($this->{"_$k"}))
				self::{'set' . ucfirst("_$k")}($v);
			else
				throw new \Exception("Unknown model property $$k.");
		}
	}
}

?>

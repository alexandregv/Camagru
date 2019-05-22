<?php

namespace App\Models;

class Model
{
	public static function get($id)
	{
		$model = explode('\\', get_called_class());
		$model = end($model);
		$data  = \App\Database::getInstance()->query("SELECT * FROM {$model}s WHERE id = '$id' LIMIT 1", [], 1);
		if ($data === false)
			return false;
		$data = array_map('htmlspecialchars', $data);
		$model = get_called_class();
		return new $model($data);
	}
	
	public static function getAll()
	{
		$model = explode('\\', get_called_class());
		$model = end($model);
		$datas = \App\Database::getInstance()->query("SELECT * FROM {$model}s", []);
		if ($datas === false)
			return false;
		$models = [];
		$model = get_called_class();
		foreach ($datas as $data)
		{
			$data = array_map('htmlspecialchars', $data);
			$models[$data['id']] = new $model($data);
		}
		return $models;
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
			else if (isset($this->{"${var}_id"}) || isset($this->{"_${var}_id"}))
			{
				$model = 'App\\Models\\' . $this->foreign_keys["${var}_id"];
				$func  = 'get' . ucfirst($var) . '_id';
				return $model::get($this->$func());
			}
			else
				throw new \Exception("Unknown model property $$var.");

		}
		else if (strncasecmp($method, "set", 3) === 0)
		{
			if (isset($this->$var))
				$this->$var = $params[0];
			else if (isset($this->{"_$var"}))
				$this->{"_$var"} = $params[0];
			else
				$this->$var = $params[0];
			//else
			//	throw new \Exception("Unknown model property $$var.");

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

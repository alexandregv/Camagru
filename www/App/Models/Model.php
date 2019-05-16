<?php

namespace App\Models;

class Model
{
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
			return $this->$var;
		if (strncasecmp($method, "set", 3) === 0)
			$this->$var = $params[0];
	}

	public function __construct(array $kwargs)
	{
		foreach ($kwargs as $k => $v)
		{
			if (isset($this->$k))
				self::{'set' . ucfirst($k)}($v);
			else if (isset($this->{'_' . $k}))
				self::{'set' . ucfirst('_' . $k)}($v);
			else
				throw new \Exception("Unknown model property $$k.");
		}
	}
}

?>

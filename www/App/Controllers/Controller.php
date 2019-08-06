<?php

namespace App\Controllers;

class Controller
{
	public $router;
	public $errors = [];

	public function __construct()
	{
		$this->router = \App\Router\Router::getInstance();
	}

	public function render(string $full, array $vars = [])
	{
		$full = explode('#', $full);
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/App/Views/$full[0]/$full[1].php"))
		{
			extract($vars);
			ob_start();
			require "App/Views/$full[0]/$full[1].php";
			return ob_get_clean();
		}
		else return $this->render('Errors#404');
	}
	
	public function validate(array $attributes)
	{
		foreach ($attributes as $attribute => $all_params)
		{
			$all_params = explode('|', $all_params);
			$attr_value = $_POST[$attribute] ?? null;

			if (in_array('required', $all_params) && (is_null($attr_value) || (!is_null($attr_value) && empty(trim($attr_value)))))
			{
				$this->errors[] = 'invalid_' . $attribute;
			}

			foreach ($all_params as $params)
			{
				list($param, $value) = explode(':', $params . ':');
				switch ($param)
				{
					case 'min':
						if (strlen($attr_value) < $value)
							$this->errors[] = 'invalid_' . $attribute;
							//$this->errors[] = $attribute . '_min';
						break;
					case 'max':
						if (strlen($attr_value) > $value)
							$this->errors[] = 'invalid_' . $attribute;
							//$this->errors[] = $attribute . '_max';
						break;
					case 'numeric':
						if (!is_numeric($attr_value))
							$this->errors[] = 'invalid_' . $attribute;
							//$this->errors[] = $attribute . '_numeric';
						break;
					case 'mail':
						if (!filter_var($attr_value, FILTER_VALIDATE_EMAIL))
							$this->errors[] = 'invalid_' . $attribute;
							//$this->errors[] = $attribute . '_mail';
						break;
				}	
			}
		}
		return empty($this->errors);
	}

	public function __call(string $action, array $params = [])
	{
		$controller = explode('\\', get_class($this));
		$controller = str_replace('Controller', '', end($controller));
		return $this->render("$controller#$action", $params);
	}
}

?>

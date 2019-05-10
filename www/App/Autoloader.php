<?php

spl_autoload_register(function($className) {
	$className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
	if(file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $className . '.php'))
		include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $className . '.php';
});

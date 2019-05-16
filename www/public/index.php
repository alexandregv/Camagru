<?php
error_reporting(E_ALL);

session_start();

set_include_path('/var/www/html/');
require_once 'App/Autoloader.php';

require_once 'public/routes.php';

?>

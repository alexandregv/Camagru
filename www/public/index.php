<?php
error_reporting(E_ALL);

set_include_path('/var/www/html/');
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8');
setlocale(LC_ALL,  'fr_FR.utf8');
ini_set('memory_limit', '-1');

session_start();
require_once 'App/Autoloader.php';

require_once 'public/routes.php';

?>

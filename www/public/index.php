<?php

set_include_path('/var/www/html/');
require 'App/Autoloader.php';

$router = App\Router\Router::getInstance();
$router->get('/posts/:id', 'Posts#show');
$router->get('/posts', 'Posts#index');
$router->get('/trending', 'Posts#trending');
$router->get('/favs', 'Posts#favs');

$router->get('/404', 'Errors#_404');

$router->get('/', 'Posts#index');

$router->get('/register', 'Users#register');
$router->get('/login', 'Users#login');
$router->get('/logout', 'Users#logout');
$router->get('/profile', 'Users#profile');
$router->get('/settings', 'Users#settings');

$router->run();

?>

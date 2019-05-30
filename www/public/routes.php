<?php
use \App\Router\Router;
use \App\Models\User;

$router = Router::getInstance();

# ----------
# GET
$router->get('/posts/mine', function () use ($router) {
	$router->redirect('Posts#user', ['user' => User::get($_SESSION['id'])->getUsername()]);
})->middleware('auth');
$router->get('/posts/:id', 'Posts#show')->with('id', '[0-9]+');
$router->get('/posts/:user', 'Posts#user');
$router->get('/posts', 'Posts#index');

$router->get('/trending', 'Posts#trending');
$router->get('/favs', 'Posts#favs')->middleware('auth');

$router->get('/register', 'Users#register');
$router->get('/login', 'Users#login');
$router->get('/logout', 'Users#logout');
$router->get('/profile', 'Users#profile')->middleware('auth');
$router->get('/settings', 'Users#settings')->middleware('auth');

$router->get('/404', 'Errors#_404');

$router->get('/', 'Pages#home');

# ----------
# POST
$router->post('/login', 'Users#login');
$router->post('/register', 'Users#register');
$router->post('/profile', 'Users#profile')->middleware('auth');

# ----------
$router->run();

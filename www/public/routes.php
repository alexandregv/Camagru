<?php
use \App\Router\Router;
use \App\Models\User;

$router = Router::getInstance();

# ----------
# GET
$router->get('/posts/mine', function () use ($router) {
	$router->redirect('Posts#user', ['user' => User::get($_SESSION['id'])->getUsername()]);
}, 'Posts#mine')->middleware('auth');
$router->get('/posts/:id', 'Posts#show')->with('id', '[0-9]+');
$router->get('/posts/:user', 'Posts#user');
$router->get('/posts', 'Posts#index');

$router->get('/trending', 'Posts#trending');
$router->get('/favs', 'Posts#favs')->middleware('Auth');

$router->get('/register', 'Users#register')->middleware('NoAuth');
$router->get('/login', 'Users#login')->middleware('NoAuth');
$router->get('/logout', 'Users#logout');
$router->get('/profile', 'Users#profile')->middleware('Auth');

$router->get('/404', 'Errors#_404');

$router->get('/', 'Pages#home');

# ----------
# POST
$router->post('/login', 'Users#login')->middleware('NoAuth');
$router->post('/register', 'Users#register')->middleware('NoAuth');
$router->post('/profile', 'Users#profile')->middleware('Auth');

$router->post('/posts/:id/like', 'Posts#like')->with('id', '[0-9]+')->middleware('Auth');

# ----------
$router->run();

<?php
use \App\Router\Router;
use \App\Models\User;

$router = Router::getInstance();

# ----------
# GET
$router->get('/posts/mine', function () use ($router) {
	$router->redirect('Posts#user', ['user' => User::get($_SESSION['id'])->getUsername()]);
}, 'Posts#mine')->middleware('auth')->middleware('Csrf', 'after');
$router->get('/posts/:id', 'Posts#show')->with('id', '[0-9]+')->middleware('Csrf', 'after');
$router->get('/posts/:user', 'Posts#user')->middleware('Csrf', 'after');
$router->get('/posts', 'Posts#index')->middleware('Csrf', 'after');
$router->get('/new', 'Posts#new')->middleware('Auth')->middleware('Csrf', 'after');

$router->get('/trending', 'Posts#trending')->middleware('Csrf', 'after');
$router->get('/favs', 'Posts#favs')->middleware('Auth')->middleware('Csrf', 'after');

$router->get('/register', 'Users#register')->middleware('NoAuth')->middleware('Csrf', 'after');
$router->get('/login', 'Users#login')->middleware('NoAuth')->middleware('Csrf', 'after');
$router->get('/logout', 'Users#logout')->middleware('Csrf', 'after');
$router->get('/profile', 'Users#profile')->middleware('Auth')->middleware('Csrf', 'after');
$router->get('/confirm/:token', 'Users#confirm')->middleware('NoAuth')->middleware('Csrf', 'after');
$router->get('/reset/:token', 'Users#reset')->middleware('Csrf', 'after');
$router->get('/reset', 'Users#sendReset')->middleware('Csrf', 'after');

$router->get('/404', 'Errors#_404')->middleware('Csrf', 'after');

//$router->get('/admin', 'Pages#admin')->middleware('Admin');
$router->get('/', 'Pages#home')->middleware('Csrf', 'after');

# ----------
# POST
$router->post('/login', 'Users#login')->middleware('NoAuth')->middleware('Csrf');
$router->post('/register', 'Users#register')->middleware('NoAuth')->middleware('Csrf');
$router->post('/profile', 'Users#profile')->middleware('Auth')->middleware('Csrf');
$router->post('/reset/:token', 'Users#reset')->middleware('Csrf');
$router->post('/reset', 'Users#sendReset')->middleware('Csrf');

$router->post('/new', 'Posts#new')->middleware('Auth')->middleware('Csrf')->middleware('Csrf');
$router->post('/posts/:id/like', 'Posts#like')->with('id', '[0-9]+')->middleware('Auth')->middleware('Csrf');
$router->post('/posts/:id/comment', 'Posts#comment')->with('id', '[0-9]+')->middleware('Auth')->middleware('Csrf');
$router->post('/posts/:id/delete', 'Posts#delete')->with('id', '[0-9]+')->middleware('Csrf');

# ----------
$router->run();

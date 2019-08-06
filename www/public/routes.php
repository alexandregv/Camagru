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
$router->get('/new', 'Posts#new')->middleware('Auth');

$router->get('/trending', 'Posts#trending');
$router->get('/favs', 'Posts#favs')->middleware('Auth');

$router->get('/register', 'Users#register')->middleware('NoAuth');
$router->get('/login', 'Users#login')->middleware('NoAuth');
$router->get('/logout', 'Users#logout');
$router->get('/profile', 'Users#profile')->middleware('Auth');
$router->get('/confirm/:token', 'Users#confirm')->middleware('NoAuth');
$router->get('/reset/:token', 'Users#reset');
$router->get('/reset', 'Users#sendReset');

$router->get('/404', 'Errors#_404');

//$router->get('/admin', 'Pages#admin')->middleware('Admin');
$router->get('/', 'Pages#home');

# ----------
# POST
$router->post('/login', 'Users#login')->middleware('NoAuth');
$router->post('/register', 'Users#register')->middleware('NoAuth');
$router->post('/profile', 'Users#profile')->middleware('Auth');
$router->post('/reset/:token', 'Users#reset');
$router->post('/reset', 'Users#sendReset');

$router->post('/new', 'Posts#new')->middleware('Auth');
$router->post('/posts/:id/like', 'Posts#like')->with('id', '[0-9]+')->middleware('Auth');
$router->post('/posts/:id/comment', 'Posts#comment')->with('id', '[0-9]+')->middleware('Auth');
$router->post('/posts/:id/delete', 'Posts#delete')->with('id', '[0-9]+');

# ----------
# Global middlwwares (CSRF)
foreach ($router->getRoutes()['GET'] as $route)
	if ($route->getAction() != 'Users#register' && $route->getAction() != 'Users#login')
		$route->middleware('CsrfDom', 'after');
foreach ($router->getRoutes()['POST'] as $route)
	if ($route->getAction() != 'Users#register' && $route->getAction() != 'Users#login')
		$route->middleware('CsrfCheck', 'before')->middleware('CsrfDom', 'after');

# ----------
$router->run();

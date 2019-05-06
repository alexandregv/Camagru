<?php

require '../App/Autoloader.php';

$router = new App\Router\Router($_GET['url']); 
$router->get('/posts/:id', "Posts#show"); 
$router->get('/posts', "Posts#index"); 
$router->get('/404', "Errors#_404"); 
$router->get('/', function(){ echo "Bienvenue sur ma homepage !"; }); 
$router->run(); 

?>

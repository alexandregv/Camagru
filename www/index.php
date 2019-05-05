<?php

require 'autoloader.php';

$router = new App\Router\Router($_GET['url']); 
$router->get('/', function(){ echo "Bienvenue sur ma homepage !"; }); 
$router->get('/posts/:id', "Posts#show"); 
$router->get('/posts', "Posts#index"); 
$router->run(); 

?>

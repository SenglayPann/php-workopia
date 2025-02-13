<?php
  require '../helper.php';

  $routes = [
    '/' => 'home',
    '/listings' => 'listings/index',
    '/listings/create' => 'listings/create',
    '404' => 'errors/404'
  ];

  $uri = $_SERVER['REQUEST_URI'];

  if (array_key_exists($uri, $routes)) {
    loadController($routes[$uri]);
  } else {
    loadController($routes['404']);
    // echo "not found $uri";	
  }
?>

<?php
  session_start();
  require __DIR__ . '/../vendor/autoload.php';
  require '../helper.php';

  use Framework\Router;
  
  // Instantiating the router
  $router = new Router();

  // Registering routes
  require basePath('routes.php');
  
  // getting the request uri and http method
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // parse_url() returns the path part of the URL
  $method = $_SERVER['REQUEST_METHOD'];
  
  // Routing
  $router->route($uri, $method);

?>

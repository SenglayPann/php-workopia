<?php

  $routes = require basePath('routes.php');
  
  if (array_key_exists($uri, $routes)) {
    loadController($routes[$uri]);
  } else {
    http_response_code(404);
    loadController($routes['404']);
    // echo "not found $uri";	
  }
?>
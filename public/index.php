<?php
  require '../helper.php';

  $dbConfig =  require basePath('config/db.php');

  require basePath('Database.php');
  
  $connection = new Database($dbConfig);
  
  require basePath('Router.php');
  
  $router = new Router();

  require basePath('routes.php');
  
  $uri = $_SERVER['REQUEST_URI'];
  $method = $_SERVER['REQUEST_METHOD'];
  

  $router->route($uri, $method);

?>

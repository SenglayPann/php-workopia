<?php
  require '../helper.php';
  // Requiring files
  require basePath('Database.php');
  require basePath('Router.php');

  // $dbConfig = require basePath('config/db.php');
  // $db = new Database($dbConfig);

  // $listings = $db->query('SELECT * FROM listings')->fetchAll();

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

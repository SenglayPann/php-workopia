<?php
  
  $router->get('/', 'home');
  $router->get('/listings', 'listings/index');
  $router->get('/listings/create', 'listings/create');
?>
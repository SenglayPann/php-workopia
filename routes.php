<?php
  
  $router->get('/', 'homeController@index');
  $router->get('/listings', 'ListingsController@index');
  $router->get('/listings/create', 'ListingsController@create');
  $router->get('/listing', 'ListingsController@details');
  // $router->get('/', 'home');
  // $router->get('/listings', 'listings/index');
  // $router->get('/listings/create', 'listings/create');
  // $router->get('/listing', 'listings/details');
?>
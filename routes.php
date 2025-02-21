<?php
  
  $router->get('/', 'HomeController@index');
  $router->get('/listings', 'ListingsController@index');
  $router->get('/listings/create', 'ListingsController@create');
  $router->get('/listings/{id}', 'ListingsController@details');

  $router->post('/listings', 'ListingsController@store');
  $router->delete('/listings/{id}', 'ListingsController@destroy');
  // $router->get('/', 'home');
  // $router->get('/listings', 'listings/index');
  // $router->get('/listings/create', 'listings/create');
  // $router->get('/listing', 'listings/details');
?>
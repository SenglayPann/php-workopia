<?php
  
  $router->get('/', 'HomeController@index');
  $router->get('/listings', 'ListingsController@index');
  $router->get('/listings/create', 'ListingsController@create');
  $router->get('/listings/edit/{id}', 'ListingsController@edit');
  $router->get('/listings/{id}', 'ListingsController@details');

  $router->post('/listings', 'ListingsController@store');
  $router->delete('/listings/{id}', 'ListingsController@destroy');
  $router->put('/listings/edit/{id}', 'ListingsController@update');
  
  $router->get('/auth/register', 'UsersController@register');
  $router->post('/auth/register', 'UsersController@signup');
  $router->get('/auth/login', 'UsersController@login');
  $router->post('/auth/login', 'UsersController@startLogin');

  $router->get('/auth/verify/{token}', 'UsersController@verify');
  $router->post('/auth/logout', 'UsersController@logout');
?>
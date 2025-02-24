<?php

  $router->get('/', 'HomeController@index');
  $router->get('/search', 'ListingsController@search');
  $router->get('/listings', 'ListingsController@index');
  $router->get('/listings/create', 'ListingsController@create', ['Auth@Authenticated']);
  $router->get('/listings/edit/{id}', 'ListingsController@edit', ['OwnerShip@checkListingOwnership']);
  $router->get('/listings/{id}', 'ListingsController@details');

  $router->post('/listings', 'ListingsController@store', ['Auth@Authenticated']);
  $router->delete('/listings/{id}', 'ListingsController@destroy', ['OwnerShip@checkListingOwnership']);
  $router->put('/listings/edit/{id}', 'ListingsController@update', ['OwnerShip@checkListingOwnership']);
  
  $router->get('/auth/register', 'UsersController@register', ['Auth@Guest']);
  $router->post('/auth/register', 'UsersController@signup', ['Auth@Guest']);
  $router->get('/auth/login', 'UsersController@login', ['Auth@Guest']);
  $router->post('/auth/login', 'UsersController@startLogin', ['Auth@Guest']);

  $router->get('/auth/verify/{token}', 'UsersController@verify', ['Auth@Guest']);
  $router->post('/auth/logout', 'UsersController@logout', ['Auth@Authenticated']);

  // inspectAndDie($router->routes[0]);
?>
<?php
  require_once basePath('Router.php');
  $dbConfig = require basePath('config/db.php');
  $db = new Database($dbConfig);

  $id = $_GET['id'] ?? null;
  $router = new Router();

  // inspect($_GET['id']);

  if (!isset($id)) {
    $router->error();
    exit;
  }

  $params = [
    'id' => $id,
  ];

  $job = $db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();
  // inspectAsJson($listings);

  loadView('listings/details', [
    'job' => $job,
  ]);
  

  
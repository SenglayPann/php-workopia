<?php

  $dbConfig = require basePath('config/db.php');
  $db = new Database($dbConfig);

  $listings = $db->query('SELECT * FROM listings')->fetchAll();
  // inspectAsJson($listings);

  loadView('home');
<?php
  require basePath('vendor/autoload.php');

  $dotenv = Dotenv\Dotenv::createImmutable(basePath());
  $dotenv->load();

  // var_dump($_ENV);

  return [
    "host" => $_ENV['DB_HOST'],
    "port" => $_ENV['DB_PORT'],
    "username" => $_ENV['DB_USERNAME'],
    "password" => $_ENV['DB_PASSWORD'],
    "dbname" => $_ENV['DB_NAME']
  ];
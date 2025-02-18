<?php

class database {

  public $connection;

  public function __construct($config) {
    $dsn = "mysql:host={$config["host"]};port={$config["port"]};dbname={$config["dbname"]};charset=utf8";

    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ];

    try {
      $this->connection = new PDO($dsn, $config["username"], $config["password"], $options);
      // echo "Connected to database";
    } catch (PDOException $e) {
      echo "Failed to connect to database: " . $e->getMessage();
    }
  }
  
  public function query($query, $params = []) {
    try {
      $statement = $this->connection->prepare($query);

      foreach ($params as $param => $value) {
        $statement->bindValue(":" . $param, $value);
      }
      // inspect($statement);
      $statement->execute($params);
      return $statement;
    } catch (PDOException $e) {
      throw new Exception("Failed to execute query: " . $e->getMessage());
    }
  }
}
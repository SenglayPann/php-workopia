<?php

class database {

  public $connection;

/**
 * Constructs a new database connection instance.
 *
 * Initializes a PDO connection using the provided configuration array.
 * Sets the connection options for error mode and default fetch mode.
 *
 * @param array $config An associative array containing the database configuration:
 *                      - 'host': Database host
 *                      - 'port': Database port
 *                      - 'dbname': Database name
 *                      - 'username': Database username
 *                      - 'password': Database password
 *
 * @throws PDOException If the connection fails
 */

  public function __construct($config) {
    $dsn = "mysql:host={$config["host"]};port={$config["port"]};dbname={$config["dbname"]};charset=utf8";

    // Set PDO options
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ];

    // Connect to database
    try {
      $this->connection = new PDO($dsn, $config["username"], $config["password"], $options);
      // echo "Connected to database";
    } catch (PDOException $e) {
      echo "Failed to connect to database: " . $e->getMessage();
    }
  }
  
  
  /**
   * Executes a SQL query and returns the PDOStatement object
   *
   * @param string $query The SQL query to execute
   * @param array $params An associative array of parameters to bind to the query
   * @return PDOStatement The PDOStatement object
   * @throws Exception If the query fails to execute
   */
  public function query($query, $params = []) {
    try {
      $statement = $this->connection->prepare($query);
      
      // Bind parameters
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
<?php

namespace App\Controllers;
use Framework\Database, Framework\Validation;

class UsersController {
  public $dbConfig;
  protected $db;

  /**
   * Constructor
   *
   * Require the database configuration file and create a new
   * Database instance with it.
   *
   * @return void
   */
  public function __construct() {
    $this->dbConfig = require basePath('config/db.php');
    $this->db = new Database($this->dbConfig);
  }


  public function register() {
    loadView('users/create');
  }

  public function login() {
    loadView('users/login');
  }
}
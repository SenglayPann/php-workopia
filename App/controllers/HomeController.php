<?php
  namespace App\Controllers;
  use Framework\Database;

  class HomeController {
    public $dbConfig;
    public $db;
    
    public function __construct() {
      // $this->dbConfig = require basePath('config/db.php');
      // $this->db = new Database($dbConfig);
    }
    
    public function index(){

      // $listings = $this->db->query('SELECT * FROM listings')->fetchAll();
      // // inspectAsJson($listings);

      // loadView('home', [
      //   'listings' => $listings,
      // ]);

      die("HomeController@index");
    }
  }
<?php
  namespace App\Controllers;
  use Framework\Database, Framework\Router;

  class ListingsController {
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
    
    /**
     * Index
     *
     * Queries all listings from the database and loads the
     * 'listings/index' view with the result.
     *
     * @return void
     */
    public function index(){

      $listings = $this->db->query('SELECT * FROM listings')->fetchAll();
      // inspectAsJson($listings);

      loadView('listings/index', [
        'listings' => $listings,
      ]);
    }

    /**
     * Details
     *
     * Queries a listing by its ID from the database and loads the
     * 'listings/details' view with the result.
     *
     * @return void
     */
    public function details() {
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

      $job = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();
      // inspectAsJson($listings);

      loadView('listings/details', [
        'job' => $job,
      ]);
    }

    /**
     * Create
     *
     * Loads the 'listings/create' view, which displays a form to
     * create a new job listing.
     *
     * @return void
     */
    public function create() {
      loadView('listings/create');
    }
  }
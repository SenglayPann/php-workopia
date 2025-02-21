<?php
  namespace App\Controllers;
  use Framework\Database;
  use App\Controllers\ErrorsController;

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
    public function details($params) {

      $job = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();
      // inspectAsJson($listings);

      if (!$job) {
        ErrorsController::notFound('there is not job with this id');
      }

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

    public function store() {
      
      $allowedFields = [
        'title', 'description', 'salary', 'requirements', 'benefits', 'address', 'city', 'tags', 'company', 'state', 'phone', 'email'
      ];

      // intersect the $_POST array with the allowed fields
      $newListingsData = array_intersect_key($_POST, array_flip($allowedFields));

      $newListingsData['user_id'] = 0;

      // sanitize the data avoid SQL injection
      $sanitizedData = array_map('sanitize', $newListingsData);

      $sanitizedData = array_map(fn($value) => $value === '' || null ? null : $value, $sanitizedData);

      $requireFields = [
        'title', 'description', 'email', 'city', 'state'
      ];

      $errors = [];

      // check if the required fields are empty
      foreach ($requireFields as $field) {
        if (empty($sanitizedData[$field])) {
          $errors[$field] = ucfirst($field) . ' is required';
        }
      }

      if (!empty($errors)) {
        // go back to the form

        loadView('listings/create', [
          'errors' => $errors,
          'filledData' => $sanitizedData
        ]);
        return;
      }

      // insert the data into the database

      $fields = array_keys($sanitizedData);

      $fieldsString =implode(', ', $fields);
      $valuesString = implode(', ', array_map(fn($value) => ":$value", $fields));

      // inspect($fieldsString);
      // inspectAndDie($valuesString);

      $this->db->query("INSERT INTO listings ($fieldsString) VALUES ($valuesString)", $sanitizedData);

      redirect('/listings');
    }

    function destroy($params) {
      $id = $params['id'];

      $params = [
        'id' => $id
      ];

      $job = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();

      if (!$job) {
        ErrorsController::notFound('there is not job with this id');
      }

      $_SESSION['success_message'] = 'Job deleted successfully';

      $this->db->query("DELETE FROM listings WHERE id = :id", $params);

      redirect('/listings');
    }
  }
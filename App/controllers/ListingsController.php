<?php
  namespace App\Controllers;
  use Framework\Database;
  use App\Controllers\ErrorsController;
  use Framework\Session;
  use Framework\Validation;

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
        ErrorsController::notFound('there is no job with this id');
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

    function sanitizeData() {
      $allowedFields = [
        'title', 'description', 'salary', 'requirements', 'benefits', 'address', 'city', 'tags', 'company', 'state', 'phone', 'email'
      ];

      // intersect the $_POST array with the allowed fields
      $newListingsData = array_intersect_key($_POST, array_flip($allowedFields));

      // sanitize the data avoid SQL injection
      $sanitizedData = array_map('sanitize', $newListingsData);

      $sanitizedData = array_map(fn($value) => $value === '' || null ? null : $value, $sanitizedData);

      $requireFields = [
        'title', 'description', 'email', 'city', 'state'
      ];

      $errors = [];

      // check if the required fields are empty
      foreach ($requireFields as $field) {
        if (empty($sanitizedData[$field]) || !Validation::string($sanitizedData[$field])) {
          $errors[$field] = ucfirst($field) . ' is required';
        }
      }

      // check if the email is valid
      if (!Validation::email($sanitizedData['email'])) {
        $errors['email'] = 'Email is invalid';
      }

      return [$errors, $sanitizedData];
    }

    public function store() {
      
      list($errors, $sanitizedData) = $this->sanitizeData();

      if (!empty($errors)) {
        // go back to the form

        loadView('listings/create', [
          'errors' => $errors,
          'filledData' => $sanitizedData
        ]);
        return;
      }

      $sanitizedData['user_id'] = Session::get('user')['id'];

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

      $this->db->query("DELETE FROM listings WHERE id = :id", $params);
      
      $_SESSION['success_message'] = 'Job deleted successfully';
      Session::clear('job');

      redirect('/listings');
    }

    function edit() {

      $job = Session::get('job');

      // inspectAndDie($job);

      loadView('listings/edit', [
        'filledData' => (array) $job,
      ]);
    }

    function update($params) {
      list($errors, $sanitizedData) = $this->sanitizeData();

      if (!empty($errors)) {
        // go back to the form

        loadView('listings/edit', [
          'errors' => $errors,
          'filledData' => $sanitizedData
        ]);
        return;
      }

      $id = $params['id'];

      $params = [
        'id' => $id
      ];

      $updateString = '';

      foreach ($sanitizedData as $key => $value) {
        $updateString .= "$key = :$key, ";
      }

      $updateString = rtrim($updateString, ', ');

      // inspectAndDie($updateString);

      $sanitizedData['id'] = $id;

      // inspect($fieldsString);
      // inspectAndDie($valuesString);

      $this->db->query("UPDATE listings SET $updateString WHERE id = :id", $sanitizedData);

      $_SESSION['success_message'] = 'Job updated successfully';
      Session::clear('job');

      redirect('/listings');
    }

    function search() {
      $keywords = $_GET['keywords'] ?? '';
      $location = $_GET['location'] ?? '';

      $params = [
        'keywords' => "%$keywords%",
        'location' => "%$location%"
      ];

      // inspectAndDie($params);
      $listings = $this->db->query("SELECT * FROM listings WHERE (title LIKE :keywords OR description LIKE :keywords OR tags LIKE :keywords) AND (city LIKE :location OR state LIKE :location)", $params)->fetchAll();

      loadView('home', [
        'listings' => $listings,
        'keywords' => $keywords,
        'location' => $location
      ]);
    }
  }
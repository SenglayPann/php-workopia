<?php

namespace App\Controllers;
require basePath('vendor/autoload.php');
use Framework\Database, Framework\Validation, Framework\Mail;

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

  /**
   * Sanitizes the data from the register form and checks if the
   * required fields are empty and if the email is valid.
   *
   * @return array An array containing the errors and the sanitized data
   */
  function sanitizeData() {
    $allowedFields = ['name', 'email', 'password', 'confirmPassword', 'city', 'state'];

    // intersect the $_POST array with the allowed fields
    $newListingsData = array_intersect_key($_POST, array_flip($allowedFields));

    // sanitize the data avoid SQL injection
    $sanitizedData = array_map('sanitize', $newListingsData);

    $sanitizedData = array_map(fn($value) => $value === '' || null ? null : $value, $sanitizedData);

    $requireFields = ['name', 'email', 'password', 'confirmPassword', 'city', 'state'];

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

  /**
   * Register
   *
   * Loads the 'users/create' view, which displays a form to
   * create a new user.
   *
   * @return void
   */
  public function register() {
    loadView('users/create');
  }
  /**
   * Login
   *
   * Loads the 'users/login' view, which displays a form to
   * login to the application.
   *
   * @return void
   */
  public function login() {
    loadView('users/login');
  }

  /**
   * Signup
   *
   * Handles the submission of the registration form, validates the
   * input and either creates a new user or updates an existing user's
   * verification token if the email is already in use.
   *
   * @return void
   */
  public function signup() {

    list($errors, $sanitizedData) =$this->sanitizeData();
    $notice = '';

    // check if the email is valid
    if (!Validation::email($sanitizedData['email'])) {
      $errors['email'] = 'Email is invalid';
    }

    // check if the password and confirm_password match
    if ($sanitizedData['password'] !== $sanitizedData['confirmPassword']) {
      $errors['confirmPassword'] = 'Passwords do not match';
    }

    $filledData = $sanitizedData;

    // check if email is already in use or not verified
    $user = $this->db->query('SELECT * FROM users WHERE email = :email', ['email' => $sanitizedData['email']])->fetch();

    if ($user && $user->is_verified) {
      $notice = 'Email is already in use. Please login';
      $errors['email'] = 'Email is already in use';
      loadView('users/create', ['errors' => $errors, 'filledData' => $filledData, 'notice' => $notice]);
      return;
    }

    if (!empty($errors)) {
      loadView('users/create', ['errors' => $errors, 'filledData' => $filledData]);
      return;
    }

    // generate a verification verification_token
    $verification_token = bin2hex(random_bytes(32));

    // set verification_token expiration time
    $tokenExpires = getTimestamp(5);
    $sanitizedData['token_expires'] = $tokenExpires;
    $to = $sanitizedData['email'];

    if (!$user) {
      // hash the password
      $sanitizedData['password'] = password_hash($sanitizedData['password'], PASSWORD_DEFAULT);

      $sanitizedData['verification_token'] = $verification_token;


      // unset the confirm password field
      unset($sanitizedData['confirmPassword']);

      // insert the user into the database
      $this->db->query('INSERT INTO users (name, email, password, city, state, verification_token, token_expires) VALUES (:name, :email, :password, :city, :state, :verification_token, :token_expires)', $sanitizedData);

      // send verification email
      Mail::sendConfirmationEmail($to, $verification_token);

      loadView('success/200', ['message' => 'Your registration was successfully submitted', 'tip' => 'Please check your email to verify your account']);

      return;
    }

    // update the user's account with the new verification_token and token_expires
    if ($user && !$user->is_verified) {
      $this->db->query('UPDATE users SET verification_token = :verification_token, token_expires = :token_expires WHERE email = :email', ['verification_token' => $verification_token, 'token_expires' => $tokenExpires, 'email' => $sanitizedData['email']]);
      // send verification email
      Mail::sendConfirmationEmail($to, $verification_token);
      //
      loadView('success/200', ['message' => 'Your registration was successfully submitted', 'tip' => 'Please check your email to verify your account']);
    }

  }

  /**
   * Verify a user's account
   *
   * @param array $params
   * @return void
   */
  public function verify($params) {
    // inspectAndDie($params);

    $params = ['verification_token' => $params['token']];

    $user = $this->db->query('SELECT * FROM users WHERE verification_token = :verification_token', $params)->fetch();

    if (!$user) {
      loadView('errors/400', ['message' => 'Invalid verification link']);
      return;
    }
    
    $tokenExpires = $user->token_expires;
    
    // check if the verification_token has expired
    if (convertTimestamp($tokenExpires) < convertTimestamp(getTimestamp())) {
      loadView('errors/400', ['message' => 'Your verification link has expired']);
      return;
    }

    $params['is_verified'] = 1;
    $params['token_expires'] = null;
    
    // update the user's account to verified and remove the verification_token
    $user = $this->db->query('UPDATE users SET is_verified = :is_verified, token_expires = :token_expires, verification_token = null WHERE verification_token = :verification_token', $params)->fetch();
    // inspectAndDie($user);

    loadView('success/201', ['message' => 'Your account has been verified']);
  }
}
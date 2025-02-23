<?php

namespace App\Controllers;
require basePath('vendor/autoload.php');
use Framework\Database, Framework\Validation, Framework\Mail, Framework\Session;

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
  function sanitizeRegisterData() {
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
   * Sanitizes the data from the login form and checks if the
   * required fields are empty.
   *
   * @return array An array containing the errors and the sanitized data
   */
  public function senitizeLoginData() {
    $allowedFields = ['email', 'password'];

    // intersect the $_POST array with the allowed fields
    $loginData = array_intersect_key($_POST, array_flip($allowedFields));

    // sanitize the data avoid SQL injection
    $sanitizedData = array_map('sanitize', $loginData);

    $requireFields = ['email', 'password'];

    $errors = [];

    // check if the required fields are empty
    foreach ($requireFields as $field) {
      if (empty($sanitizedData[$field]) || !Validation::string($sanitizedData[$field])) {
        $errors[$field] = ucfirst($field) . ' is required';
      }
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
    list($errors, $sanitizedData) = $this->sanitizeRegisterData();

    if (!Validation::email($sanitizedData['email'])) {
      $errors['email'] = 'Email is invalid';
    }

    if ($sanitizedData['password'] !== $sanitizedData['confirmPassword']) {
      $errors['confirmPassword'] = 'Passwords do not match';
    }

    if (!empty($errors)) {
      loadView('users/create', ['errors' => $errors, 'filledData' => $sanitizedData]);
      return;
    }

    $existingUser = $this->db->query('SELECT * FROM users WHERE email = :email', ['email' => $sanitizedData['email']])->fetch();

    if ($existingUser && $existingUser->is_verified) {
      $errors['email'] = 'Email is already in use';
      loadView('users/create', ['errors' => $errors, 'filledData' => $sanitizedData]);
      return;
    }

    $verificationToken = bin2hex(random_bytes(32));
    $tokenExpires = getTimestamp(5);

    if (!$existingUser) {
      $sanitizedData['password'] = password_hash($sanitizedData['password'], PASSWORD_DEFAULT);
      $sanitizedData['verification_token'] = $verificationToken;
      $sanitizedData['token_expires'] = $tokenExpires;

      unset($sanitizedData['confirmPassword']);

      $this->db->query('INSERT INTO users (name, email, password, city, state, verification_token, token_expires) VALUES (:name, :email, :password, :city, :state, :verification_token, :token_expires)', $sanitizedData);

      Mail::sendConfirmationEmail($sanitizedData['email'], $verificationToken);

      loadView('success/200', ['message' => 'Your registration was successfully submitted', 'tip' => 'Please check your email to verify your account']);
      return;
    }

    if ($existingUser && !$existingUser->is_verified) {
      if (expired($existingUser->token_expires, getTimestamp())) {
        $this->db->query('UPDATE users SET verification_token = :verification_token, token_expires = :token_expires WHERE email = :email', ['verification_token' => $verificationToken, 'token_expires' => $tokenExpires, 'email' => $existingUser->email]);

        Mail::sendConfirmationEmail($sanitizedData['email'], $verificationToken);
      }

      loadView('success/200', ['message' => 'This email has already been submitted and waiting for verification', 'tip' => 'Please check your email to verify your account']);
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
    if (expired($tokenExpires, getTimestamp())) {
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
  
  function startLogin() {
    list($errors, $sanitizedData) = $this->senitizeLoginData();

    $notice = '';

    if (!empty($errors)) {
      loadView('users/login', ['errors' => $errors, 'filledData' => $sanitizedData]);
      return;
    }

    // find the user in the database
    $user = $this->db->query('SELECT * FROM users WHERE email = :email', ['email' => $sanitizedData['email']])->fetch();

    if (!$user || !password_verify($sanitizedData['password'], $user->password)) {
      $notice = 'Incorrect email or password';
      loadView('users/login', ['errors' => $errors,'filledData' => $sanitizedData, 'notice' => $notice]);
      return;
    }

    if ($user && !$user->is_verified) {

      if (expired($user->token_expires, getTimestamp())) {
        $newVerificationToken = bin2hex(random_bytes(32));
        $newTokenExpires = getTimestamp(5);
        $this->db->query('UPDATE users SET verification_token = :verification_token, token_expires = :token_expires WHERE email = :email', ['verification_token' => $newVerificationToken, 'token_expires' => $newTokenExpires, 'email' => $user->email]);

        Mail::sendConfirmationEmail($user->email, $newVerificationToken);
      }

      $errors['email'] = 'this email is not verified';

      $notice = 'Your account is not verified. We have sent you an email to verify your account';
      loadView('users/login', ['errors' => $errors,'filledData' => $sanitizedData, 'notice' => $notice]);
      return;
    }

    Session::set('user', $user);
    header('Location: /');
  }

  function logout() {
    Session::clearAll();
    $params = session_get_cookie_params();
    // inspectAndDie(session_name());
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain']);

    header('Location: /');
  }
}
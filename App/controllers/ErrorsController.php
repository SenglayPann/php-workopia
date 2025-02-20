<?php
  namespace App\Controllers;

  class ErrorsController {
    /**
     * Constructor
     *
     * This class doesn't need any instance variables, so this is empty.
     *
     * @return void
     */
    public function __construct() {
    }
    

    /**
     * Shows a 404 error page when the requested page is not found.
     *
     * Sets the HTTP response code to 404 and loads the 'errors' view
     * with an appropriate error message.
     *
     * @return void
     */

    public static function notFound($message = 'This page does not exist'){
      http_response_code(404);
      loadView('errors', [
        'errorCode' => '404',
        'message' => $message
      ]);
      exit;
    }
    /**
     * Shows a 403 error page when the user is not authorized to access a page.
     *
     * @return void
     */

    public static function unautorized($message = 'You are not authorized to view this page'){
      http_response_code(403);
      loadView('errors', [
        'errorCode' => '403',
        'message' => $message
      ]);
      exit;
    }
    
  }
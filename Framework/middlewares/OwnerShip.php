<?php

namespace Framework\Middlewares;
use Framework\Middlewares\Auth, Framework\Session;
use Framework\Database;
use App\Controllers\ErrorsController;

class OwnerShip {

  protected $db;

  public static function checkListingOwnership($params) {

    $dbConfig = require basePath('config/db.php');
    $db = new Database($dbConfig);

    Auth::Authenticated();

    // inspectAndDie(Session::get('user'));

    
    $userId = Session::get('user')['id'];
    $job = (array) $db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();
      // inspectAsJson($listings);

    if (!$job) {
      ErrorsController::notFound('there is no job with this id');
    }

    if ($job['user_id'] !== $userId) {
      ErrorsController::unauthorized('You are not authorized to view this page');
    }

    Session::set('job', $job);
  }
}
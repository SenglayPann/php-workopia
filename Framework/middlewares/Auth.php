<?php

namespace Framework\Middlewares;
use Framework\Session;

class Auth {
  
  public static function Authenticated() {
    if (!Session::has('user')) {
      header('Location: /auth/login');
      exit;
    }
  }

  public static function Guest() {
    if (Session::has('user')) {
      header('Location: /');
      exit;
    }
  }
}
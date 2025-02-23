<?php
namespace Framework;

class Session {
  

  /**
   * Ensures that a session is started.
   *
   * This function checks if there is no active session.
   * If none exists, it starts a new session.
   */

  public static function start() {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
  }

  /**
   * Sets a session variable.
   *
   * @param string $key The session key you want to set.
   * @param mixed $value The value to set the session key to.
   */
  public static function  set($key, $value) {
    $_SESSION[$key] = $value;
  }

  /**
   * Retrieves a session variable.
   *
   * @param string $key The session key you want to retrieve.
   * @param mixed $defualt The value to return if the key does not exist.
   *
   * @return mixed The value of the session key, or $defualt if the key does not exist.
   */
  public static function get($key, $defualt = null) {
    return $_SESSION[$key] ?? $defualt ?? null;
  }

  /**
   * Checks if a session key exists.
   *
   * @param string $key The session key to check.
   * @return bool True if the session key exists, false otherwise.
   */

  public static function has($key) {
    return isset($_SESSION[$key]);
  }

  /**
   * Clears a session variable.
   *
   * @param string $key The session key you want to clear.
   */
  public static function clear($key) {
    if (self::has($key)) {
      unset($_SESSION[$key]);
    }
  }

  /**
   * Clears all session variables and destroys the session.
   *
   * This function unsets all session variables and destroys the session, effectively logging out
   * the user and resetting any session-based data.
   */

  public static function clearAll() {
    session_unset();
    session_destroy();
  }
}
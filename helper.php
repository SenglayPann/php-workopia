<?php 
  
/**
 * Returns the path to the given file or directory, relative to the root
 * of the project.
 *
 * @param string $path The path to the file or directory.
 *
 * @return string The path to the file or directory.
 */
  function basePath($path = '') {
    return __DIR__ . '/' .  $path;
  }
  

/**
 * Requires a file relative to the root of the project.
 *
 * @param string $path The path to the file.
 *
 * @throws RuntimeException If the file does not exist.
 */
  function requireFile($path, $data = []) {

    $file = basePath($path);

    if (file_exists($file)) {
      extract($data);
      require $file;
    } else {
      echo "File named --- $path --- does not exist";
      // die();
    }
  }

/**
 * Loads the full path to a view file.
 *
 * @param string $view The name of the view file without extension.
 *
 * @return string The full path to the view file.
 */
  function loadView($view, $data = []) {
    return requireFile('App/views/' . $view . '.view.php', $data);
  }

/**
 * Loads the full path to a component file.
 *
 * @param string $component The name of the component file without extension.
 *
 * @return string The full path to the component file.
 */
  function loadComponent($component) {
    return requireFile('App/components/' . $component . '.php');
  }

/**
 * Outputs the value of the given variable to the page.
 *
 * Useful for inspecting a variable quickly without having to
 * worry about the rest of the code executing.
 *
 * @param mixed $value The value to inspect.
 */
  function inspect($value)
  {
    echo "<pre>";
    echo var_dump($value);
    echo "</pre>";
  }

/**
 * Outputs the value of the given variable to the page.
 *
 * Useful for inspecting a variable quickly without having to
 * worry about the rest of the code executing.
 *
 * @param mixed $value The value to inspect.
 */
  function inspectAsJson($value)
  {
    echo "<pre>";
    echo json_encode($value, JSON_PRETTY_PRINT);
    echo "</pre>";
  }

/**
 * Outputs the value of the given variable and then dies.
 *
 * Useful for inspecting a variable quickly without having to
 * worry about the rest of the code executing.
 *
 * @param mixed $value The value to inspect and die on.
 */
  function inspectAndDie($value) {
    echo '<pre>';
    die(var_dump($value));
    echo '</pre>';
  } 

/**
 * Loads the full path to a controller file.
 *
 * @param string $controller The name of the controller file without extension.
 *
 * @return string The full path to the controller file.
 */
  function loadController($controller) {
    return requireFile('App/controllers/' . $controller . '.php');
  }
  

/**
 * Formats the given salary as a string with a dollar sign and 
 * comma-separated thousands.
 *
 * @param mixed $salary The salary amount to format. It can be a number 
 *                      or a string representing a number.
 *
 * @return string The formatted salary string with a dollar sign and
 *                comma-separated thousands.
 */

  function formatSalary($salary) {
    return "$" .number_format(floatval($salary));
  }
  
/**
 * Automatically loads any PHP files in the Framework directory
 * that are referenced elsewhere in the codebase.
 *
 * @return void
 */
  function autoLoadFrameworks() {
    spl_autoload_register(function ($class) {
      $file = basePath('Framework/' . $class . '.php');
      if (file_exists($file)) {
        require $file;
      } else {
        echo "File named --- $class --- does not exist";
      }
    });
  }

/**
 * Sanitizes the given string by removing any whitespace from the beginning
 * and end and encoding any special characters to HTML entities.
 *
 * @param string $dirty The string to sanitize.
 *
 * @return string The sanitized string.
 */
  function sanitize($dirty) {
    $dirty = trim($dirty);
    $sanitized = filter_var($dirty, FILTER_SANITIZE_SPECIAL_CHARS);

    return $sanitized;
  }

/**
 * Redirects to the given URL.
 *
 * @param string $location The URL to redirect to.
 *
 * @return void
 */
  function redirect($location) {
    header('Location: ' . $location);
    exit;
  }

/**
 * Returns the current timestamp in 'Y-m-d H:i:s' format with optional added minutes.
 *
 * This function generates the current timestamp and adds the specified number of
 * extra minutes to it before formatting it as a string.
 *
 * @param int $extraMinutes The number of minutes to add to the current timestamp.
 *                          Defaults to 0 if not provided.
 * @return string The formatted timestamp with added minutes.
 */
  function getTimestamp($extraMinutes = 0) {
    return date('Y-m-d H:i:s', time() + ($extraMinutes * 60));
  }
  
  
/**
 * Converts the given timestamp string to a Unix timestamp.
 *
 * @param string $timestamp The timestamp string to convert.
 *
 * @return int The Unix timestamp equivalent of the given string.
 */
  function convertTimestamp($timestamp) {
    return strtotime($timestamp);
  }

/**
 * Checks if $timestamp1 is older than $timestamp2.
 *
 * @param string $timestamp1 The first timestamp to compare.
 * @param string $timestamp2 The second timestamp to compare.
 *
 * @return bool True if $timestamp1 is older than $timestamp2, false if not.
 */
  function expired($timestamp1, $timestamp2) {
    return convertTimestamp($timestamp1) < convertTimestamp($timestamp2);
  }
?>
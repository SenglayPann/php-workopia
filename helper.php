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
    return requireFile('views/' . $view . '.view.php', $data);
  }

/**
 * Loads the full path to a component file.
 *
 * @param string $component The name of the component file without extension.
 *
 * @return string The full path to the component file.
 */
  function loadComponent($component) {
    return requireFile('components/' . $component . '.php');
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
    return requireFile('controllers/' . $controller . '.php');
  }
  

  function formatSalary($salary) {
    return "$" .number_format(floatval($salary));
  }
  
?>
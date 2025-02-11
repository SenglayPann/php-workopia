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
  

  function requireFile($path) {

    $file = basePath($path);

    if (file_exists($file)) {
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
  function loadView($view) {
    return requireFile('views/' . $view . '.view.php');
  }

  function loadComponent($component) {
    return requireFile('components/' . $component . '.php');
  }
?>
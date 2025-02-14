<?php

  class Router {
    Protected $routes = [];

    /**
     * Registers a route by storing it in the $routes array.
     * 
     * @param string $method The HTTP request method.
     * @param string $uri The URI for the route.
     * @param string $controller The controller for the route.
     * @return void
     */
    public function registerRoute($method, $uri, $controller) {
    
      $this->routes[] = [
        'method' => $method,
        'uri' => $uri,
        'controller' => $controller,
      ];
    }

  /**
   * Registers a new GET route with the specified URI and controller.
   *
   * @param string $uri The URI pattern for the route.
   * @param string $controller The controller that handles the route.
   */
    public function get($uri, $controller) {
      $this->registerRoute('GET', $uri, $controller);
    }

    /**
     * Registers a new POST route with the specified URI and controller.
     *
     * @param string $uri The URI pattern for the route.
     * @param string $controller The controller that handles the route.
     */
    public function post($uri, $controller) {
      $this->registerRoute('POST', $uri, $controller);
    }
    
    /**
     * Registers a new PATCH route with the specified URI and controller.
     *
     * @param string $uri The URI pattern for the route.
     * @param string $controller The controller that handles the route.
     */
    public function put($uri, $controller) {
      $this->registerRoute('PUT', $uri, $controller);
    }
    
    /**
     * Registers a new DELETE route with the specified URI and controller.
     *
     * @param string $uri The URI pattern for the route.
     * @param string $controller The controller that handles the route.
     */
    public function delete($uri, $controller) {
      $this->registerRoute('DELETE', $uri, $controller);
    }

    /**
     * Sets the HTTP response code to the specified status code and loads the
     * corresponding error controller.
     *
     * @param int $statusCode The HTTP status code to respond with.
     *
     * @return void
     */
    public function error($statusCode = 404) {
      http_response_code(404);
      loadController("errors/$statusCode");
      exit;
    }


    /**
     * Routes the specified URI and HTTP method to the appropriate controller.
     *
     * @param string $uri The URI to route.
     * @param string $method The HTTP method to route.
     *
     * @return void
     */
    public function route($uri, $method) {
      foreach ($this->routes as $route) {
        if ($route['uri'] === $uri && $route['method'] === $method) {
          // echo $uri;
          // echo '</br>';
          // echo $route['controller'];
          return loadController($route['controller']);
          return;
        }
      }

      $this->error();
    }
  }
?>
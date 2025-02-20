<?php

  namespace Framework;

  use App\Controllers\ErrorsController;


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
    public function registerRoute($method, $uri, $action) {

      list($controller, $controllerMethod) = explode('@', $action);
    
      $this->routes[] = [
        'method' => $method,
        'uri' => $uri,
        'controller' => $controller,
        'controllerMethod' => $controllerMethod
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
     * Routes the specified URI and HTTP method to the appropriate controller.
     *
     * @param string $uri The URI to route.
     * @param string $method The HTTP method to route.
     *
     * @return void
     */
    public function route($uri, $method) {
      $uriSegements = explode('/', trim($uri, '/'));

      foreach ($this->routes as $route) {
        $routeSegements = explode('/', trim($route['uri'], '/'));

        // inspect($uriSegements);
        
        // if the number of uri segements === number of route segements
        if (count($uriSegements) === count($routeSegements) && $route['method'] === $method) {
          // inspect($routeSegements);
          $match = true;
          $params = [];

          // loop through to see if either each segement is matched or is a wildcard
          for ($i = 0; $i < count($routeSegements); $i++) {

            // echo $i;

            // figure out the uri segement doesn't match the route segement and is also not a wildcard (completely mismatched)
            if ($uriSegements[$i] !== $routeSegements[$i] && !preg_match('/\{(.+?)\}/', $routeSegements[$i])) {
              $match = false;
              break;
            }

            // 
            if (preg_match('/\{(.+?)\}/', $routeSegements[$i], $matches)) {
              // inspect($matches);
              $params[$matches[1]] = $uriSegements[$i];
              // inspectAndDie($matches);
            }
          }

          if ($match) {
              // exstract controller and action method 
              $controller = "App\\Controllers\\" . $route['controller'];
              $controllerMethod = $route['controllerMethod'];
              
              // instantiate controller and call the action method
              $instanceController = new $controller();
              $instanceController->$controllerMethod($params);
              return;
          }
          // inspect($params);
        }
      }
      // return notFound page in case no route is matched
      ErrorsController::notFound();
    }
  }
?>
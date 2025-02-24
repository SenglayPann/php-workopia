<?php

  namespace Framework;

  use App\Controllers\ErrorsController;
use Middlewares;

  class Router {
    public $routes = [];

    /**
     * Registers a route by storing it in the $routes array.
     * 
     * @param string $method The HTTP request method.
     * @param string $uri The URI for the route.
     * @param string $controller The controller for the route.
     * @return void
     */
    public function registerRoute($method, $uri, $action, $middlewares = []) {

      list($controller, $controllerMethod) = explode('@', $action);

      if (!empty($middlewares)) {
        $middlewares = array_map(function($middleware) {
          list($middleware, $middlewareMethod) = explode('@', $middleware);
          return [
            'middleware' => $middleware,
            'middlewareMethod' => $middlewareMethod
          ];
        }, $middlewares);
      }
    
      $this->routes[] = [
        'method' => $method,
        'uri' => $uri,
        'controller' => $controller,
        'controllerMethod' => $controllerMethod,
        'middlewares' => $middlewares
      ];
    }

  /**
   * Registers a new GET route with the specified URI and controller.
   *
   * @param string $uri The URI pattern for the route.
   * @param string $controller The controller that handles the route.
   */
    public function get($uri, $controller, $middlewares = []) {
      $this->registerRoute('GET', $uri, $controller, $middlewares);
    }

    /**
     * Registers a new POST route with the specified URI and controller.
     *
     * @param string $uri The URI pattern for the route.
     * @param string $controller The controller that handles the route.
     */
    public function post($uri, $controller, $middlewares = []) {
      $this->registerRoute('POST', $uri, $controller, $middlewares);
    }
    
    /**
     * Registers a new PATCH route with the specified URI and controller.
     *
     * @param string $uri The URI pattern for the route.
     * @param string $controller The controller that handles the route.
     */
    public function put($uri, $controller, $middlewares = []) {
      $this->registerRoute('PUT', $uri, $controller, $middlewares);
    }
    
    /**
     * Registers a new DELETE route with the specified URI and controller.
     *
     * @param string $uri The URI pattern for the route.
     * @param string $controller The controller that handles the route.
     */
    public function delete($uri, $controller, $middlewares = []) {
      $this->registerRoute('DELETE', $uri, $controller, $middlewares);
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
      // inspectAndDie($_GET);
      // inspectAndDie(explode('?',$uri));

      // check for _method input
      if ($method === 'POST' && isset($_POST['_method'])) {

        // override the actual request method
        $method = strtoupper($_POST['_method']);
      }

      // inspectAndDie($_POST);

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
            foreach ($route['middlewares'] as $middlewares) {
              $middleware = "Framework\\Middlewares\\" . $middlewares['middleware'];
              $middlewareMethod = $middlewares['middlewareMethod'];
              
              $middleware::$middlewareMethod($params);
            }

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
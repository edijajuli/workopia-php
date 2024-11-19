<?php

namespace Framework;

use App\Controllers\ErrorController;

class Router
{
    protected $routes = [];

    /**
     * Add new route
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */

    public function regiterRoute($method, $uri, $action)
    {
        list($controller, $controllerMethod) = explode('@', $action);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }

    /**
     *  Add a Get route
     * @param string $uri
     * @param string $controller
     */

    public function get($uri, $controller)
    {
        $this->regiterRoute('GET', $uri, $controller);
    }

    /**
     *  Add a POST route
     * @param string $uri
     * @param string $controller
     */

    public function post($uri, $controller)
    {
        $this->regiterRoute('POST', $uri, $controller);
    }

    /**
     *  Add a put route
     * @param string $uri
     * @param string $controller
     */

    public function PUT($uri, $controller)
    {
        $this->regiterRoute('PUT', $uri, $controller);
    }

    /**
     *  Add a DELETE route
     * @param string $uri
     * @param string $controller
     */

    public function delete($uri, $controller)
    {
        $this->regiterRoute('DELETE', $uri, $controller);
    }


    /**
     * Route the request
     * @param string $uri
     * @param string $$method
     * @return void
     */

    public function route($uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Check for _method input
        if ($requestMethod == 'POST' && isset($_POST['_method'])) {
            // Override the request method with the value of _method
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            // Split the current URI into segments
            $uriSegments = explode('/', trim($uri, '/'));
            // inspectAndDie($uriSegments[1]);

            // Split the route URI into segments
            $routeSegments = explode('/', trim($route['uri'], '/'));
            // inspect($routeSegments);

            $match = true;

            // Check if the cnumber of segments match
            if (count($uriSegments) === count($routeSegments) && strtoupper($route['method']) === $requestMethod) {
                $params = [];
                $match = true;
                // If the uri's do not match and there are no param
                for ($i = 0; $i < count($uriSegments); $i++) {
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }
                    // Check for the paramas and add to the params array
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        // inspectAndDie($matches[1]);
                        // inspectAndDie($uriSegments[$i]);
                        $params[$matches[1]] = $uriSegments[$i];
                        // inspectAndDie($params);
                    }
                }
                if ($match) {
                    // Extract controller and controller method
                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    // Instantiate the controller and call the method
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }


            // if ($route) {
            //     if ($route['uri'] === $uri && $route['method'] === $method) {
            //         //Extract controller and controller method
            //         $controller = 'App\\Controllers\\' . $route['controller'];
            //         $controllerMethod = $route['controllerMethod'];

            //         // Instantiate the controller and call the method
            //         $controllerInstance = new $controller();
            //         $controllerInstance->$controllerMethod();
            //         return;
            //     }
            // }
        }

        ErrorController::notFound();
    }
}

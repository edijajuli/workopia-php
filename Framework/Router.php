<?php

namespace Framework;

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
     * Load error page
     * @param int $httpCode
     * @return void
     */
    public function error($httpCode = 404)
    {
        http_response_code($httpCode);
        loadView("error/{$httpCode}");
        exit;
    }

    /**
     * Route the request
     * @param string $uri
     * @param string $$method
     * @return void
     */

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route) {
                if ($route['uri'] === $uri && $route['method'] === $method) {
                    //Extract controller and controller method
                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    // Instantiate the controller and call the method
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod();
                    return;
                }
            }
        }

        $this->error();
    }
}




















// $routes = require basePath('routes.php');

// if (array_key_exists($uri, $routes)) {
//     require(basePath($routes[$uri]));
// } else {
//     http_response_code(404);
//     require(basePath($routes['404']));
// }
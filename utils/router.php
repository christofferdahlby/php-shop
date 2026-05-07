<?php

class Router
{
    private $routes = [];

    public function addRoute($route, $function)
    {
        $this->routes[$route] = $function;
    }

    public function dispatch()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = rtrim($url, '/') ?: '/';

        if (isset($this->routes[$url])) {
            call_user_func($this->routes[$url]);
        } else {
            http_response_code(404);
            echo "Page not found";
        }
    }
}

?>
<?php

namespace App\Services;

class Router
{
    protected $routes = [];

    public function get($uri, $action)
    {
      $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
      $this->routes['POST'][$uri] = $action;
    }

    public function patch($uri, $action)
    {
      $this->routes['PATCH'][$uri] = $action;
    }

    public function delete($uri, $action)
    {
      $this->routes['DELETE'][$uri] = $action;
    }

    public function handle($uri, $method)
    {
      if (isset($this->routes[$method][$uri])) {
          $action = $this->routes[$method][$uri];
          $this->dispatch($action);
      } else {
          echo "Not Found";
      }
    }

    protected function dispatch($action)
    {
      list($controller, $method) = $action;
      $controller = new $controller;

      if (method_exists($controller, $method)) {

        $data = json_decode(file_get_contents('php://input'), true);
        $controller->$method($data);

      }
    }
}

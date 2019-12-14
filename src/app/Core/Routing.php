<?php

namespace App\Core;

use App\Controllers\Controller;
use App\Exceptions\ValidationException;

class Routing
{
    public function run()
    {
        $request = $_SERVER['REQUEST_URI'];
        $array = explode("/", $request);
        $id = intval(end($array));


        $routes = $this->getRoutes($id);

        try {
            $this->runAction($routes, $request, $id);
        } catch (ValidationException $exception) {
            $controller = new Controller();
            $controller->error(['code' => '403', 'message' => $exception->getMessage()]);
        } catch (\Exception $exception) {
            $controller = new Controller();
            $controller->error(['code' => '500', 'message' => $exception->getMessage()]);
        }

    }

    private function getRoutes(int $id)
    {
        return [
            'POST:/api/product/generate' => 'ProductController@generate',
            'GET:/api/product' => 'ProductController@list',
            'POST:/api/order' => 'OrderController@create',
            "PATCH:/api/order/$id" => 'OrderController@patch',
        ];
    }

    /**
     * @param array    $router
     * @param string   $request
     * @param int|null $id
     */
    private function runAction(array $router, string $request, int $id = null): void
    {
        if ($this->checkRouting($router, $request)) {
            $data = explode('@', $router[$_SERVER['REQUEST_METHOD'] . ":" . $request]);
            $controllerName = "\App\Controllers\\" . $data[0];
            $actionName = $data[1];

            $controller = new $controllerName;
            $controller->{$actionName}($id);

        } else {
            $controller = new Controller();
            $controller->error(['code' => '404', 'message' => 'Not found']);
        }
    }

    /**
     * @param array  $router
     * @param string $requestUri
     *
     * @return bool
     */
    private function checkRouting(array $router, string $requestUri): bool
    {
        return isset($router[$_SERVER['REQUEST_METHOD'] . ":" . $requestUri]);
    }
}
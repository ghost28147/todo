<?php

namespace Todos;

use PDO;
use Todos\Controller\Impl\ApiController;
use Todos\Controller\Impl\DefaultController;
use Todos\Controller\ModelAndView;
use Todos\Controller\Route;
use Todos\Model\IllegalArgumentException;
use Todos\Model\ItemModel;
use Todos\Model\ItemRepository;
use Twig_Environment;
use Twig_Loader_Filesystem;

class App
{
    public static function main($config)
    {
        $pdo = new PDO($config['dsn'], $config['user'], $config['password']);

        $repo = new ItemRepository($pdo);
        $model = new ItemModel($repo);

        $routes = [];
        $knownControllers = [
            new ApiController($model),
            new DefaultController($model)
        ];

        foreach ($knownControllers as $controller) {
            $controller->register($routes);
        }

        list($method, $path, $requestParams) = self::parseRequest();
        $found = self::findSuitableController($routes, $path, $method);

        if (!$found) {
            self::notFound();
            return;
        }

        try {
            $modelAndView = call_user_func(
                [$found->handlerObj, $found->handlers[$method]],
                $requestParams);

            echo self::render($modelAndView);
        } catch (IllegalArgumentException $e) {
            echo self::clientError($e->getMessage());
        }
    }

    /**
     * @param array $routes
     * @param string $path
     * @param string $method
     * @return false|Route Контроллер для обработки запроса или false
     */
    private static function findSuitableController(array $routes, $path, $method)
    {
        $suitable = array_filter(
            $routes,
            function (Route $r) use ($path, $method) {
                return ($r->path === $path
                    && !empty($r->handlers[$method]));
            });

        return empty($suitable)? false : array_pop($suitable);
    }

    /**
     * @return array http метод, путь и параметры запроса
     */
    private static function parseRequest()
    {
        $requestParams = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        $parsedRequestParams = [];
        parse_str($requestParams, $parsedRequestParams);

        return [
            $_SERVER['REQUEST_METHOD'],
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH ),
            $parsedRequestParams
        ];
    }

    private static function render(ModelAndView $mv)
    {
        $loader = new Twig_Loader_Filesystem('src/templates');
        $twig   = new Twig_Environment($loader); /*, ['cache' => 'cache']);*/

        return $twig->render($mv->view, $mv->model);
    }

    private static function clientError($message) {
        header("HTTP/1.1 400 Bad Request");
        header('Content-Type: application/json; charset=UTF-8');

        return json_encode([ 'message' => $message]);
    }

    private static function notFound() {
        header("HTTP/1.1 404 Not Found");
    }
}



<?php

namespace App\Kernel\Router;

use App\Kernel\Controller\Controller;
use App\Kernel\View\View;
use const APP_PATH;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function __construct(
        private View $view                                              //1. Объявляем переменную класса
    )
    {
        $this->initRoutes();                                            //2. Вызываем метод
    }

    public function dispatch(string $uri, string $method): void
    {
        $route = $this->findRoute($uri, $method);                       //6. Проверяем если в только созданном массиве наши переданные данные

        if (!$route){
            $this->notFound();                                          //7. Если данные не найдены
        }

        if (is_array($route->getAction())){                             //8. Проверяем передаем метод контроллера или анонимную функцию
            [$controller, $action] = $route->getAction();               //9. Получаем класс контролерра, которые наследуются от класса Controller

            /**
             * @var Controller $controller
             */
            $controller = new $controller();                            //10. Получаем экземпляр

            call_user_func([$controller, 'setView'], $this->view);      //11. Вызаваем метод у родителя
            call_user_func([$controller, $action]);                     //12. Вызываем метод у потомка
        } else {
            call_user_func($route->getAction());

        }
    }

    private function notFound(): void
    {
        echo '404 | Not Found';
        exit;
    }

    private function initRoutes()
    {
        $routes = $this->getRoutes();                                           //3. Вызываем метод

        foreach ($routes as $route){

            $this->routes[$route->getMethod()][$route->getUri()] = $route;      //5. Вызываем у экземпляра класс, соответствующие методы. Экземпляр класса получен из routes.php
                                                                                //Заполняем массив
        }
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return require_once APP_PATH.'/config/routes.php';                      //4. Получаем массив экземпляров класса Route
    }

    private function findRoute(string $uri, string $method): Route|false
    {
        if(!isset($this->routes[$method][$uri])){
            return false;
        }
        return $this->routes[$method][$uri];
    }
}

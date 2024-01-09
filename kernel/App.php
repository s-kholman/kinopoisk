<?php

namespace App\Kernel;

use App\Kernel\Container\Container;

class App
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container(); //В конструкторе получаем экземпляр класса Container, construct вызван из index.php
    }

    public function run() //Непосредственно сам метод вызван из index.php
    {

        $this->container                                //Обращаяемся к переменной в которой экземпляр класса положенный туда при construct
            ->router                                    //Обращаемся к экземпляру класса Router которому передан экземляр класса View
            ->dispatch(                                 //Вызываем метод dispatch класса Router, передав ему две переменные:
                $this->container->request->uri(),       //uri - часть урла
                $this->container->request->method()     //метод каким передается POST || GET
            );
    }
}

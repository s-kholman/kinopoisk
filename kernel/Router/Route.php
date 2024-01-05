<?php

namespace App\Kernel\Router;

class Route
{
    public function __construct(
        private string $uri,
        private string $method,
        private $action
    )
    {
    }


    public static function get(string $uri, $action): static
    {
        return new static($uri, 'GET', $action);
    }

    public static function post(string $uri, $action): static
    {
        return new static($uri, 'POST', $action);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return callable
     */
    public function getAction(): mixed
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }



}
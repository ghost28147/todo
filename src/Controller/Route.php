<?php

namespace Todos\Controller;

class Route
{
    public $path;

    public $handlerObj;

    public $handlers;

    /**
     * @param $path string
     * @param $handlerObj Controller
     * @param $handlers
     */
    public function __construct($path, $handlerObj, $handlers)
    {
        $this->path = $path;
        $this->handlerObj = $handlerObj;
        $this->handlers = $handlers;
    }

    public const GET    = 'GET';
    public const PATCH  = 'PATCH';
    public const POST   = 'POST';
    public const DELETE = 'DELETE';
}



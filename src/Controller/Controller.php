<?php

namespace Todos\Controller;

interface Controller
{
    /**
     * @param array $routes
     * @return mixed
     */
    function register(array &$routes);
}
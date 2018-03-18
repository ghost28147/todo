<?php

namespace Todos\Controller\Impl;

use Todos\Controller\Controller;
use Todos\Controller\ModelAndView;
use Todos\Controller\Route;
use Todos\Model\ItemModel;

class DefaultController implements Controller {

    private $model;

    public function __construct(ItemModel $model)
    {
        $this->model = $model;
    }

    public function masterPage($ignored)
    {
        $itemsList =  $this->model->findAll();

        return new ModelAndView(['itemsList' => $itemsList], 'layout.html');
    }

    public function register(array &$routes)
    {
        $masterPageRoute = new Route('/', $this, [Route::GET => 'masterPage']);
        array_push($routes, $masterPageRoute);
    }
}


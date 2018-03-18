<?php

namespace Todos\Controller\Impl;

use Todos\Controller\Controller;
use Todos\Controller\ModelAndView;
use Todos\Controller\Route;
use Todos\Model\ItemModel;

class ApiController implements Controller {

    private $model;

    public function __construct(ItemModel $model)
    {
        $this->model = $model;
    }

    function register(array &$routes)
    {
        array_push($routes,
            new Route('/api/items', $this, [Route::POST => 'create']),
            new Route('/api/items', $this, [Route::DELETE => 'remove']),
            new Route('/api/items/completed', $this, [Route::DELETE => 'removeCompleted']),
            new Route('/api/items', $this, [Route::PATCH => 'update'])
        );
    }

    public function create($requestParams)
    {
        $content = $requestParams['content'];
        $this->model->create($content);

        return $this->updatedState();
    }

    public function remove($requestParams)
    {
        $this->model->remove($requestParams['id']);
        return $this->updatedState();
    }

    public function removeCompleted()
    {
        $this->model->removeCompleted();
        return $this->updatedState();
    }

    public function update($requestParams) {
        $this->model->update(
            $requestParams['id'],
            $requestParams['content'],
            $requestParams['state']);

        return $this->updatedState();
    }

    private function updatedState()
    {
        $itemsList = $this->model->findAll();
        return new ModelAndView(['itemsList' => $itemsList], 'component.html');
    }
}

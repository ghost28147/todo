<?php

namespace Todos\Controller;

class ModelAndView {

    public $model;
    public $view;

    public function __construct(array $model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }
}

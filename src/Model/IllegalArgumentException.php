<?php

namespace Todos\Model;

class IllegalArgumentException extends \Exception
{

    public function __construct($cause)
    {
        parent::__construct($cause);
    }
}
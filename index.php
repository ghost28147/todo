<?php

require_once 'vendor/autoload.php';

use Todos\App;

App::main(
    parse_ini_file('config.ini')
);

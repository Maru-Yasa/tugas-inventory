<?php

namespace Maru\Inventory\Core;

use duncan3dc\Laravel\BladeInstance;
use duncan3dc\Laravel\Directives;

class Controller
{
    protected function render($view, $data = []) 
    {
        $directives = (new Directives);

        $blade = new BladeInstance(
            ROOT_PATH . 'Views',
            ROOT_PATH . '../public/cache'
        );

        echo $blade->render($view, $data);
    }
}
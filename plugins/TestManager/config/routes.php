<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'TestManager',
    ['path' => '/test-manager'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);

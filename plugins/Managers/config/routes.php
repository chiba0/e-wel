<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Managers',
    ['path' => '/managers'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    },
    'ManagersCampany',
    ['path' => '/managersCampany'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);

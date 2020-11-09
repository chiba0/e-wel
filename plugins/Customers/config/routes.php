<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Customers',
    ['path' => '/customers'],
    function (RouteBuilder $routes) {
        $routes->get('/app/*', ['controller' => 'app', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/app/lists/*', ['controller' => 'app', 'action' => 'lists']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/app/sendmailstatus/*', ['controller' => 'app', 'action' => 'sendmailstatus']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/detail/index/*', ['controller' => 'detail', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/detail/eabj/*', ['controller' => 'detail', 'action' => 'eabj']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/menu1/*', ['controller' => 'menu1', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/pdf/*', ['controller' => 'pdf', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/idlist/*', ['controller' => 'idlist', 'action' => 'index']);
    }
);

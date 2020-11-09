<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Partners',
    ['path' => '/partners'],
    function (RouteBuilder $routes) {
        
        $routes->get('/app/*', ['controller' => 'app', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/temp/delete/*', ['controller' => 'temp', 'action' => 'delete']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/temp/setTemp/*', ['controller' => 'temp', 'action' => 'setTemp']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/temp/download/*', ['controller' => 'temp', 'action' => 'download']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/temp/*', ['controller' => 'temp', 'action' => 'lists']);
        $routes->fallbacks(DashedRoute::class);

        $routes->get('/menu2/edit/*', ['controller' => 'menu2', 'action' => 'edit']);
        $routes->fallbacks(DashedRoute::class);
        $routes->get('/delete/*', ['controller' => 'delete', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);

    }
    
);



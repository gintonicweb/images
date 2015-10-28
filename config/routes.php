<?php
use Cake\Routing\Router;

Router::scope('/', ['plugin' => 'Images'], function ($routes) {

    $routes->connect('/images', ['controller' => 'Images']);
    $routes->connect('/images/:action/*', ['controller' => 'Images'], ['routeClass' => 'DashedRoute']);
    $routes->fallbacks('DashedRoute');

    $routes->prefix('admin', function ($routes) {
        $routes->connect('/images', ['controller' => 'Images']);
        $routes->connect('/images/:action/*', ['controller' => 'Images']);
        $routes->fallbacks('DashedRoute');
    });
});


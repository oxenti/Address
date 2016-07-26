<?php
use Cake\Routing\Router;

Router::plugin('Address', function ($routes) {
    
    $routes->extensions(['json']);
    
    $routes->resources('Addresses');
    $routes->resources('Cities');
    $routes->resources('States', function ($routes) {
        $routes->resources('Cities');
    });
    $routes->resources('Countries', function ($routes) {
        $routes->resources('States');
    });
    $routes->fallbacks('DashedRoute');
});

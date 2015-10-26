<?php
use Cake\Routing\Router;

Router::plugin('Address', function ($routes) {
    $routes->fallbacks('DashedRoute');
    
    $routes->resources('Addresses');
    
    $routes->resources('States', function ($routes) {
        $routes->resources('Cities');
    });
    
    $routes->resources('Countries', function ($routes) {
        $routes->resources('States');
    });
});

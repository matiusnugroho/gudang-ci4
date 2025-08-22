<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/auth', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->resource('products', ['filter' => 'auth']);
$routes->resource('purchases', ['filter' => 'auth']);
$routes->resource('incoming', ['controller' => 'IncomingItems','filter'=>'auth']);
$routes->resource('outgoing', ['controller' => 'Outcoming','filter'=>'auth']);
$routes->group('reports', [
    'namespace' => 'App\Controllers',
    'filter'    => 'auth',   // 🔒 hanya user login
], function($routes) {
    $routes->get('incoming', 'Reports::incoming');
    $routes->get('outgoing', 'Reports::outgoing');
    $routes->get('stock', 'Reports::stock');
});
$routes->resource('categories', ['filter' => 'auth']);

$routes->get('api/purchase-items/(:num)', 'Api::purchaseItems/$1');



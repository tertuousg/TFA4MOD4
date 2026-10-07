<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt', ['filter' => 'csrf']);
$routes->post('logout', 'Auth::logout', ['filter' => 'csrf']);

$routes->group('', ['filter' => 'auth'], static function (RouteCollection $routes): void {
    $routes->get('dashboard', 'Dashboard::index');

    $routes->get('products', 'Products::index');
    $routes->get('products/new', 'Products::new');
    $routes->post('products', 'Products::create', ['filter' => 'csrf']);
    $routes->get('products/(:num)/edit', 'Products::edit/$1');
    $routes->post('products/(:num)', 'Products::update/$1', ['filter' => 'csrf']);
    $routes->post('products/(:num)/delete', 'Products::delete/$1', ['filter' => 'csrf']);

    $routes->get('customers', 'Customers::index');
    $routes->get('customers/new', 'Customers::new');
    $routes->post('customers', 'Customers::create', ['filter' => 'csrf']);
    $routes->get('customers/(:num)/edit', 'Customers::edit/$1');
    $routes->post('customers/(:num)', 'Customers::update/$1', ['filter' => 'csrf']);
    $routes->post('customers/(:num)/delete', 'Customers::delete/$1', ['filter' => 'csrf']);

    $routes->get('users', 'Users::index');
    $routes->get('users/new', 'Users::new');
    $routes->post('users', 'Users::create', ['filter' => 'csrf']);
    $routes->get('users/(:num)/edit', 'Users::edit/$1');
    $routes->post('users/(:num)', 'Users::update/$1', ['filter' => 'csrf']);
    $routes->post('users/(:num)/delete', 'Users::delete/$1', ['filter' => 'csrf']);

    $routes->get('sales', 'Sales::index');
    $routes->get('sales/new', 'Sales::new');
    $routes->post('sales', 'Sales::create', ['filter' => 'csrf']);
});

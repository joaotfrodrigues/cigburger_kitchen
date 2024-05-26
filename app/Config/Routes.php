<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/',                                          'Main::index');
$routes->get('/delete_order/(:alphanum)',                  'Main::delete_order/$1');
$routes->get('/delete_order_confirm/(:alphanum)',          'Main::delete_order_confirm/$1');
$routes->get('/handle_order/(:alphanum)',                  'Main::handle_order/$1');
$routes->get('/handle_order_confirm/(:alphanum)',          'Main::handle_order_confirm/$1');

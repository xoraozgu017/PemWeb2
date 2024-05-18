<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages::index');

$routes->get('/books/(:segment)', 'Books::detail/$1');

$routes->delete('/books/(:num)', 'Books::delete/$1'); //kalau bisa diletakkan diatas routes /books/(:segmen)

$routes->setAutoRoute(true);
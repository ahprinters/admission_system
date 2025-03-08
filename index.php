<?php

// Autoload classes
require_once __DIR__ . '/vendor/autoload.php';

// Initialize router
$router = new \App\Router();

// Define routes
$router->add('GET', '/', '\App\Controllers\ApplicationController', 'index');
$router->add('GET', '/applications', '\App\Controllers\ApplicationController', 'index');
$router->add('GET', '/applications/view/{id}', '\App\Controllers\ApplicationController', 'view');
$router->add('GET', '/applications/create', '\App\Controllers\ApplicationController', 'create');
$router->add('POST', '/applications/create', '\App\Controllers\ApplicationController', 'create');
$router->add('GET', '/applications/approve/{id}', '\App\Controllers\ApplicationController', 'approve');
$router->add('GET', '/applications/reject/{id}', '\App\Controllers\ApplicationController', 'reject');
$router->add('POST', '/applications/add-note/{id}', '\App\Controllers\ApplicationController', 'addNote');

// Dispatch the request
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->dispatch($method, $uri);
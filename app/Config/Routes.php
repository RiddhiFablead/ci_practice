<?php
 
use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;
 
/**
 * @var RouteCollection $routes
 */
//  $routes->get('/', 'Home::index');
 $routes->get('about','Hello::about');
 $routes->get('hello','Hello::index');
 // Registration routes 
$routes->get('/', 'AuthController::register');
$routes->post('store', 'AuthController::store'); // Handle form submission
 $routes->get('/login', 'AuthController::index');
// $routes->post('store','AuthController::store');

<?php
 
use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;
 
/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
 
// $routes->get('hii','Hello::greet');
 
// $routes->get('welcome','Hello::index');
 
// $routes->group('first',function($routes){
//     $routes->get('index','Hello::index');
//     $routes->get('greet','Hello::greet');
//     $routes->get('bye','Hello::bye');
// });
 
// $routes->get('form','Form::store');
 
$routes->get('/', 'AuthController::index');
$routes->post('store','AuthController::store');

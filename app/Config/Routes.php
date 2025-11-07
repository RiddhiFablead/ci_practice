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

// Login page
 
$routes->get('/login', 'AuthController::login');
$routes->post('checkLogin', 'AuthController::checkLogin');// Login form submit (POST)
$routes->get('logout', 'AuthController::logout');// Logout
$routes->group('',['filter'=>'auth'],function($routes){
      $routes->get('dashboard', 'Dashboard::index');
      $routes->get('clothes', 'ClothesController::index');
    $routes->get('clothes/add', 'ClothesController::add');
    $routes->post('clothes/store', 'ClothesController::store');
});



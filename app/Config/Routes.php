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
      $routes->get('clothes/edit/(:num)', 'ClothesController::edit/$1');     // Fetch for edit modal
    $routes->post('clothes/update', 'ClothesController::update');          // Update (AJAX)
    $routes->delete('clothes/delete/(:num)', 'ClothesController::delete/$1'); // Delete
    $routes->get('clothes/download/(:num)', 'ClothesController::download/$1'); // Download
    $routes->get('clothes/filter', 'ClothesController::filter');  
    $routes->get('chatbot', 'Chatbot::index');
    $routes->post('chatbot/send', 'Chatbot::send');
    $routes->get('category', 'Category::index');
    $routes->get('category/create', 'Category::create');
    $routes->post('category/store', 'Category::store'); 
   $routes->get('category/edit/(:num)', 'Category::edit/$1'); // Show edit form for ID
$routes->post('category/update', 'Category::update');
    $routes->post('category/delete/(:num)', 'Category::delete/$1');

});



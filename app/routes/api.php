<?php

/**
 * API routes (if separating from web routes)
 */

use App\Core\Router;

$router = $app->getRouter();

// API version prefix
$apiPrefix = '/api/v1';

// Public API endpoints
$router->get($apiPrefix . '/schedules/search', 'HomeController@apiSearch');
$router->get($apiPrefix . '/cities', 'HomeController@getCities');
$router->get($apiPrefix . '/schedule/{id}/seats', 'BookingController@apiGetSeatMap');

// Authentication required API endpoints
$router->post($apiPrefix . '/auth/login', 'AuthController@doLogin');
$router->post($apiPrefix . '/auth/register', 'AuthController@doRegister');
$router->post($apiPrefix . '/auth/logout', 'AuthController@logout', ['auth']);

// User API
$router->get($apiPrefix . '/user/profile', 'UserController@profile', ['auth']);
$router->put($apiPrefix . '/user/profile', 'UserController@updateProfile', ['auth']);
$router->get($apiPrefix . '/user/bookings', 'UserController@apiBookings', ['auth']);
$router->get($apiPrefix . '/user/statistics', 'UserController@apiStatistics', ['auth']);

// Booking API
$router->post($apiPrefix . '/booking/select-seats', 'BookingController@apiSelectSeats', ['auth']);
$router->post($apiPrefix . '/booking', 'BookingController@createBooking', ['auth']);
$router->get($apiPrefix . '/booking/{code}', 'BookingController@viewBooking', ['auth']);
$router->delete($apiPrefix . '/booking/{code}', 'BookingController@cancelBooking', ['auth']);

// Payment API
$router->post($apiPrefix . '/payment/initiate', 'PaymentController@initiate', ['auth']);
$router->get($apiPrefix . '/payment/methods', 'PaymentController@getPaymentMethods');
$router->get($apiPrefix . '/payment/{id}/status', 'PaymentController@checkStatus', ['auth']);
$router->post($apiPrefix . '/payment/{id}/proof', 'PaymentController@uploadProof', ['auth']);

// Admin API
$router->get($apiPrefix . '/admin/stats', 'AdminController@apiDashboardStats', ['auth', 'admin']);
$router->get($apiPrefix . '/admin/bookings', 'AdminController@bookings', ['auth', 'admin']);
$router->post($apiPrefix . '/admin/payments/{id}/confirm', 'PaymentController@manualConfirm', ['auth', 'admin']);

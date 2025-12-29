<?php

/**
 * Web routes for Bus Ticket System
 */

use App\Core\Router;

$router = $app->getRouter();

// Public routes
$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');
$router->post('/contact', 'HomeController@submitContact');
$router->get('/faq', 'HomeController@faq');
$router->get('/terms', 'HomeController@terms');
$router->get('/privacy', 'HomeController@privacy');

// Search
$router->get('/search', 'HomeController@search');
$router->get('/api/search', 'HomeController@apiSearch');
$router->get('/api/cities', 'HomeController@getCities');

// Authentication
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@doLogin');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@doRegister');
$router->get('/logout', 'AuthController@logout');
$router->get('/forgot-password', 'AuthController@forgotPassword');
$router->post('/forgot-password', 'AuthController@doForgotPassword');
$router->get('/reset-password', 'AuthController@resetPassword');
$router->post('/reset-password', 'AuthController@doResetPassword');
$router->get('/verify-email', 'AuthController@verifyEmail');

// User dashboard (requires authentication)
$router->get('/dashboard', 'UserController@dashboard', ['auth']);
$router->get('/profile', 'UserController@profile', ['auth']);
$router->post('/profile', 'UserController@updateProfile', ['auth']);
$router->post('/change-password', 'UserController@changePassword', ['auth']);
$router->get('/bookings', 'UserController@bookings', ['auth']);
$router->get('/booking', 'UserController@viewBooking', ['auth']);
$router->get('/notifications', 'UserController@notifications', ['auth']);
$router->post('/notifications/read', 'UserController@markNotificationRead', ['auth']);

// Booking process (requires authentication)
$router->get('/booking/select-seats', 'BookingController@selectSeats', ['auth']);
$router->get('/booking/passenger-details', 'BookingController@passengerDetails', ['auth']);
$router->post('/booking/save-passenger-details', 'BookingController@savePassengerDetails', ['auth']);
$router->get('/booking/payment', 'BookingController@payment', ['auth']);
$router->post('/booking/create', 'BookingController@createBooking', ['auth']);
$router->get('/booking/confirmation', 'BookingController@confirmation', ['auth']);
$router->get('/booking/view', 'BookingController@viewBooking', ['auth']);
$router->post('/booking/cancel', 'BookingController@cancelBooking', ['auth']);
$router->get('/booking/ticket', 'BookingController@downloadTicket', ['auth']);

// Payment (requires authentication)
$router->get('/payment/instructions', 'PaymentController@instructions', ['auth']);
$router->post('/payment/initiate', 'PaymentController@initiate', ['auth']);
$router->post('/payment/upload-proof', 'PaymentController@uploadProof', ['auth']);
$router->get('/payment/status', 'PaymentController@checkStatus', ['auth']);

// Admin routes (requires admin authentication)
$router->get('/admin/dashboard', 'AdminController@dashboard', ['auth', 'admin']);
$router->get('/admin/users', 'AdminController@users', ['auth', 'admin']);
$router->get('/admin/user', 'AdminController@viewUser', ['auth', 'admin']);
$router->post('/admin/user/status', 'AdminController@updateUserStatus', ['auth', 'admin']);
$router->get('/admin/bookings', 'AdminController@bookings', ['auth', 'admin']);
$router->get('/admin/booking', 'AdminController@viewBooking', ['auth', 'admin']);
$router->post('/admin/booking/status', 'AdminController@updateBookingStatus', ['auth', 'admin']);
$router->post('/admin/booking/cancel', 'AdminController@cancelBooking', ['auth', 'admin']);
$router->get('/admin/payments', 'AdminController@payments', ['auth', 'admin']);
$router->post('/admin/payment/confirm', 'AdminController@confirmPayment', ['auth', 'admin']);
$router->get('/admin/schedules', 'AdminController@schedules', ['auth', 'admin']);
$router->post('/admin/schedule/create', 'AdminController@createSchedule', ['auth', 'admin']);
$router->get('/admin/buses', 'AdminController@buses', ['auth', 'admin']);
$router->get('/admin/bus-classes', 'AdminController@busClasses', ['auth', 'admin']);
$router->get('/admin/routes', 'AdminController@routes', ['auth', 'admin']);
$router->get('/admin/reports', 'AdminController@reports', ['auth', 'admin']);
$router->get('/admin/reports/export', 'AdminController@exportReport', ['auth', 'admin']);

// API routes
$router->post('/api/booking/select-seats', 'BookingController@apiSelectSeats', ['auth']);
$router->get('/api/booking/seat-map', 'BookingController@apiGetSeatMap');
$router->get('/api/user/bookings', 'UserController@apiBookings', ['auth']);
$router->get('/api/user/statistics', 'UserController@apiStatistics', ['auth']);
$router->get('/api/admin/stats', 'AdminController@apiDashboardStats', ['auth', 'admin']);
$router->get('/api/payment/methods', 'PaymentController@getPaymentMethods');
$router->post('/api/payment/callback', 'PaymentController@callback');
$router->post('/api/payment/webhook', 'PaymentController@webhook');
$router->post('/api/payment/manual-confirm', 'PaymentController@manualConfirm', ['auth', 'admin']);

// AJAX endpoints
$router->get('/api/auth/check', 'AuthController@apiCheckAuth');

<?php

use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserEventBookingController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', 'HomeController@index')->name('home');
Route::redirect('/home', '/admin');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Events
    Route::delete('events/destroy', 'EventsController@massDestroy')->name('events.massDestroy');
    Route::resource('events', 'EventsController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoriesController');

    // cities
    Route::delete('cities/destroy', 'CityController@massDestroy')->name('cities.massDestroy');
    Route::resource('cities', 'CityController');

    //Bookings
    Route::delete('bookings/destroy', 'BookingController@massDestroy')->name('bookings.massDestroy');
    Route::resource('bookings', 'BookingController');

    Route::get('my-bookings', 'MyBookingsController@index')->name('mybookings.index');
    Route::get('my-bookings/{booking}', 'MyBookingsController@show')->name('mybookings.show');
});

Route::get('/events', 'HomeController@events')->name('events');
Route::get('/pricing', 'HomeController@pricing')->name('pricing');
Route::get('/stepper', 'HomeController@stepper')->name('stepper');

Route::get('details', 'UserEventBookingController@eventDetails')->name('eventDetails');
Route::get('register-user', 'UserEventBookingController@registerUser')->name('registerUser.index');
Route::post('book-event', 'UserEventBookingController@bookEvent')->name('bookEvent');

Route::get('/stripe/refresh',[StripeController::class, 'refresh'])->name('refresh');
Route::get('/stripe/return',[StripeController::class, 'return'])->name('return');

Route::get('/payment/success',[UserEventBookingController::class, 'paymentSuccess'])->name('paymentSuccess');
Route::get('/payment/cancel',[UserEventBookingController::class, 'paymentCancel'])->name('paymentCancel');


// Stripe Webhook
Route::post('/webhook',[WebhookController::class, 'handle'])->name('webhook');

Route::get('/stripe/delete-account',[StripeController::class, 'deleteAccount'])->name('delete.account');
<?php

use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserEventBookingController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home',function(){
    return redirect()->route('admin.home');
});
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class,'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [RolesController::class,'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);

    // Users
    Route::delete('users/destroy', [UsersController::class,'massDestroy'])->name('users.massDestroy');
    Route::resource('users', UsersController::class);

    // Events
    Route::delete('events/destroy', 'EventsController@massDestroy')->name('events.massDestroy');
    Route::get('events/book','EventsController@book')->name('events.book');
    Route::post('events/handle-booking','EventsController@handleBooking')->name('events.handleBooking');
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

    Route::resource('settings/discount', DiscountController::class);


});

Route::post('/booking/is-valid-user', [UserEventBookingController::class,'isValidUser'])->name('isValidUser');


Route::get('/events', [HomeController::class,'events'])->name('events');
Route::get('/pricing', [HomeController::class,'pricing'])->name('pricing');
Route::get('/stepper', [HomeController::class,'stepper'])->name('stepper');


Route::get('details', [UserEventBookingController::class,'eventDetails'])->name('eventDetails');
Route::get('register-user', [UserEventBookingController::class,'registerUser'])->name('registerUser.index');
Route::post('book-event', [UserEventBookingController::class,'bookEvent'])->name('bookEvent');

Route::get('/stripe/refresh',[StripeController::class, 'refresh'])->name('refresh');
Route::get('/stripe/return',[StripeController::class, 'return'])->name('return');

Route::get('/payment/success',[UserEventBookingController::class, 'paymentSuccess'])->name('paymentSuccess');
Route::get('/payment/cancel',[UserEventBookingController::class, 'paymentCancel'])->name('paymentCancel');


// Stripe Webhook
Route::post('/webhook',[WebhookController::class, 'handle'])->name('webhook');

Route::get('/stripe/delete-account',[StripeController::class, 'deleteAccount'])->name('delete.account');
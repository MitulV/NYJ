<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\EventsApiController;
use Illuminate\Support\Facades\Route;

Route::post('login',[AuthApiController::class,'login']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::post('logout',[AuthApiController::class,'logout']);
    Route::get('events',[EventsApiController::class,'index']);

    Route::get('guests/{eventId}',[EventsApiController::class,'guests']);
    Route::post('bookings/{bookingId}/checkin', [EventsApiController::class, 'checkIn']);

    
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    
});
